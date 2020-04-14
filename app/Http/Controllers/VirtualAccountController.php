<?php

namespace App\Api\v1\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use DB;
use App\Http\Error;
use App\Http\Output;
use App\Models\VirtualAccount;
use App\Models\VirtualAccountDetail;
use App\Models\VirtualAccountChargeOrder;
use App\Models\Payment;
use App\Models\Settlement;
use App\Models\WithdrawLog;
use Omnipay\Omnipay;
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use App\Models\WechatPayInfo;
use App\Models\Tenancy;




class VirtualAccountController extends BaseController
{
   
    
    public function lists(Request $request)
    {
        try {
        	if (!$user = JWTAuth::parseToken()->authenticate()) {
        		return response()->json(Output::makeResult($request, null, Error::MISS_USER), 404);
        	}
        	$validator = Validator::make($request->all(), [
        			'account_type' => 'required|numeric|between:1,3',
        			'in_out'       => 'nullable|numeric|between:-1,1',
        	]);
        	if ($validator->fails()) {
        		return Output::makeResult($request, $validator->errors(), Error::MISS_PARAM);
        	}
        	
        	$where = [
        			'user_id' => $user->id,
        			'account_type' => $request->account_type,
        	];
        	if ($request->in_out) {
        		$where['in_out'] = $request->in_out;	
        	}
        	$ret = VirtualAccountDetail::where($where)->paginate(intval($request->per_page));
        	return Output::makeResult($request, ['lists' => $ret]);
        } catch (\Exception $e) {
        	return Output::makeResult($request, null, Error::SYSTEM_ERROR, $e->getMessage());
        }
    }
   
    
    public function charge(Request $request)
    {
        try {
        	if (!$user = JWTAuth::parseToken()->authenticate()) {
        		return response()->json(Output::makeResult($request, null, Error::MISS_USER), 404);
        	}
        	$validator = Validator::make($request->all(), [
        			'account_type' => 'required|numeric|between:1,2',
        			'pay_total'    => 'required|numeric',
        			'payment_code' => 'required',
        			'open_id'      => 'required',
        	]);
        	if ($validator->fails()) {
        		return Output::makeResult($request, $validator->errors(), Error::MISS_PARAM);
        	}

        	if (1 == $request->account_type) {
        		$prefix = 'B';
        	} elseif (2 == $request->account_type) {
        		$prefix = 'D';
        		
        		$account = VirtualAccount::where('user_id', $user->id)->firstOrFail();
        		if ('1' == $account->deposit_status) {
        			return Output::makeResult($request, null, Error::DEPOSIT_EXISTS);
        		} elseif ('2' == $account->deposit_status) {
        			return Output::makeResult($request, null, Error::REFUND_HANDLE);
        		}
        	} else {
        		$prefix = '';
        	}
        	
        	$payment = Payment::where('payment_code', $request->payment_code)->firstOrFail();
        	
        	$gift = 0;
        	$record = [
        			'user_id'         => $user->id,
        			'order_no'        => $this->generateOrderNo($prefix, $user->id),
        			'account_type'    => $request->account_type,
        			'payment_code'    => $request->payment_code,
        			'payment_name'    => $payment->payment_name,
        			'pay_status'      => '0',
        			'pay_status_name' => '未支付',
        			'pay_total'       => $request->pay_total,
        			'gift'            => $gift,
        			'pay_no'          => '',
        	];
        	$ret  = VirtualAccountChargeOrder::create($record);
        	
        	//gateways: WechatPay_App, WechatPay_Native, WechatPay_Js, WechatPay_Pos
        	$gateway = Omnipay::create('WechatPay_Js');
        	$gateway->setAppId(env('WX_APP_ID'));
        	$gateway->setMchId(env('WX_MCH_ID'));
        	$gateway->setApiKey(env('WX_MCH_API_KEY'));
        	$gateway->setNotifyUrl(env('APP_URL') . '/api/weixin_notify');
        	
        	$order = [
        			'body'              => '充值',
        			'out_trade_no'      => $record['order_no'],
        			'total_fee'         => $record['pay_total'],
        			'spbill_create_ip'  => $request->getClientIp(),
        			'fee_type'          => 'CNY',
        			'open_id'           => $request->open_id,
        	];
        	
        	$response = $gateway->purchase($order)->send();
        	
        	if ($response->isSuccessful()) {
        		$tmp_data = $response->getData();
        		$payment_info = [
        				'prepay_id' => $tmp_data['prepay_id'],
        		];
        		$ret->pay_no = $tmp_data['prepay_id'];
        		$ret->save();
        		return Output::makeResult($request, ['detail' => $ret, 'payment_info' => $payment_info]);
        	} else {
        		return Output::makeResult($request, $response->getData(), Error::CREATE_ORDER_FAIL);
        	}
        	
        } catch (\Exception $e) {
        	return Output::makeResult($request, null, Error::SYSTEM_ERROR, $e->getMessage());
        }
    }

    /**
     * 支付到账通知
	 *
     * @param string $order_no
     */
    public function weixinNotify(Request $request)
    {
    	$gateway = Omnipay::create('WechatPay');
    	$gateway->setAppId(env('WX_APP_ID'));
    	$gateway->setMchId(env('WX_MCH_ID'));
    	$gateway->setApiKey(env('WX_MCH_API_KEY'));
    	
    	$response = $gateway->completePurchase([
    			'request_params' => file_get_contents('php://input')
    	])->send();
    	$requestData = $response->getRequestData();
    	
    	$logger = new Logger('weixin-notify-log');
    	$logger->pushHandler(new StreamHandler('/data/logs/web_log/api/weixin-notify.log', Logger::DEBUG));
    	
    	$logInfo = ['url' => $request->fullUrl(), 'header' => $request->header(), 'request' => $requestData];
    	$logger->info('', $logInfo);
    	
    	if ($response->isPaid()) {
    		//pay success
    		
    		$order = VirtualAccountChargeOrder::where('order_no', $requestData['out_trade_no'])->sharedLock()->first();
    		if ($order) {
    			
    			if (2 == $order->pay_status) {
    				$logInfo = ['status' => '已经支付','request' => $requestData, 'order_info' =>$order];
    				$logger->info('', $logInfo);
    				return 'success';
    			}
    			
    			if ($requestData['total_fee'] != $order->pay_total) {
    				$logInfo = ['status' => '支付金额不符','request' => $requestData, 'order_info' =>$order];
    				$logger->info('', $logInfo);
    				
    				return 'success';
    			}
    			
    			$account = VirtualAccount::where('user_id', $order->user_id)->sharedLock()->firstOrFail();
    			if ('1' == $order->account_type) {
    				$account->balance = $account->balance + $order->pay_total;
    			} elseif ('2' == $order->account_type) {
    				$account->deposit        = $order->pay_total;
    				$account->deposit_status = '1';
    			}
    			
    			DB::transaction(function () use (&$order, &$account) {
    				$order->pay_status      = '2';
    				$order->pay_status_name = '已支付';
    				$order->save();
    				$account->save();
    				$account_detail = [
    						'user_id'      => $order->user_id,
    						'account_type' => ('1' == $order->account_type) ? VirtualAccount::TYPE_BALANCE: VirtualAccount::TYPE_DEPOSIT,
    						'in_out'       => VirtualAccount::CHARGE_INCOME,
    						'price'        => $order->pay_total,
    						'remark'       => ('1' == $order->account_type) ? '充值' : '押金充值',
    						'keyword'      => $order->order_no,
    				];
    				VirtualAccountDetail::create($account_detail);
    			});
    		} else {
    			$logInfo = ['error' => '没有找到该订单','request' => $requestData, 'order_info' =>$order];
    			$logger->info('', $logInfo);
    			
    			return 'success';
    		}
    		
    		$logInfo = ['status' => 'success','request' => $requestData, 'order_info' =>$order];
    		$logger->info('', $logInfo);
    		return 'success';
    	} else {
    		//pay fail
    		$logInfo = ['status' => 'fail','request' => $requestData, 'order_info' =>$order];
    		$logger->info('', $logInfo);
    		return 'fail';
    	}
    	
    }
    
    /**
     * 微信退款
     *
     * @param string $order_no
     */
    private function weixinRefund($order_no)
    {
    	$order = VirtualAccountChargeOrder::where('order_no', $order_no)->firstOrFail();
    	$certPath = '';
    	$keyPath  = '';
    	
    	$gateway = Omnipay::create('WechatPay');
    	$gateway->setAppId(env('WX_APP_ID'));
    	$gateway->setMchId(env('WX_MCH_ID'));
    	$gateway->setApiKey(env('WX_MCH_API_KEY'));
    	$gateway->setCertPath(env('WX_CERT_PATH'));
    	$gateway->setKeyPath(env('WX_KEY_PATH'));
    	
    	$request_data = [
    			//'transaction_id' => '1217752501201407033233368018', //The wechat trade no
    			'out_trade_no'  => $order->order_no,
    			'out_refund_no' => $order->order_no,
    			'total_fee'     => $order->pay_total,
    			'refund_fee'    => $order->pay_total,
    	];
    	$response = $gateway->refund($request_data)->send();
    	
    	$logger = new Logger('weixin-refund-log');
    	$logger->pushHandler(new StreamHandler('/data/logs/web_log/api/weixin-refund.log', Logger::DEBUG));
    	
    	$logInfo = ['request' => $request_data, 'response' => $response->getData()];
    	$logger->info('', $logInfo);
    	
    	return $response->isSuccessful();
    }


    public function depositRefund(Request $request)
    {
    	try {
    		if (!$user = JWTAuth::parseToken()->authenticate()) {
    			return response()->json(Output::makeResult($request, null, Error::MISS_USER), 404);
    		}
    		
    		$virtualObj = VirtualAccount::where('user_id', $user->id)->first();
    		if (1 != $virtualObj->deposit_status || $virtualObj->deposit <= 0) {
    			return Output::makeResult($request, null, Error::EMPTY_DEPOSIT);
    		}
    		
    		$inuse = Tenancy::where('user_id', $user->id)
    		->where('status', '1')
    		->first();
    		if ($inuse) {
    			return Output::makeResult($request, null, Error::UMBRELLA_IN_USE);
    		}
    		
    		$virtualObj->deposit = '0';
    		$virtualObj->deposit_status = '2';
    		$virtualObj->save();
    		
    		$order = VirtualAccountChargeOrder::where('user_id', $user->id)
    		->where('account_type', 2)
    		->where('pay_status', 2)
    		->orderBy('created_at', 'desc')
    		->firstOrFail();
    		$refund_status = $this->weixinRefund($order->order_no);
    		if (true === $refund_status) {
    			$virtualObj->deposit_status = '-1';
    			$virtualObj->save();
    			return Output::makeResult($request, null, ERROR::IS_OK, '已提交处理，押金将在7个工作日内退回到原来的账户');
    		} else {
    			return Output::makeResult($request, null, Error::UNKNOWN_ERROR);
    		}
    		
    	} catch (\Exception $e) {
    		return Output::makeResult($request, null, Error::SYSTEM_ERROR, $e->getMessage());
    	}
    }
    
    
    public function withdrawApply(Request $request)
    {
    	try {
    		if (!$user = JWTAuth::parseToken()->authenticate()) {
    			return response()->json(Output::makeResult($request, null, Error::MISS_USER), 404);
    		}
    		$validator = Validator::make($request->all(), [
    				'withdraw_profit' => 'required|numeric',
    		]);
    		if ($validator->fails()) {
    			return Output::makeResult($request, $validator->errors(), Error::MISS_PARAM);
    		}
    		
    		$withdraw = WithdrawLog::where('user_id', $user->id)->where('withdraw_status', '0')->first();
    		if ($withdraw) {
    			return Output::makeResult($request, null, Error::WITHDRAW_EXISTS);
    		}
    		
    		$profit_toal = Settlement::where('user_id', $user->id)->sum('user_total');
    		$account     = VirtualAccount::where('user_id', $user->id)->firstOrFail();
    		if (($request->withdraw_profit < 1000) || ($profit_toal < 1000) || (($profit_toal - $account->withdraw_profit) < 1000)) {
    			return Output::makeResult($request, null, Error::WITHDRAW_MIN_10);
    		}
    		
    		$record = [
    				'user_Id'         => $user->id,
    				'withdraw_profit' => $request->withdraw_profit ,
    		];
    		$ret = WithdrawLog::create($record);
    		
    		
    		return Output::makeResult($request, null, ERROR::IS_OK, '申请成功，请等候处理');
    		
    	} catch (\Exception $e) {
    		return Output::makeResult($request, null, Error::SYSTEM_ERROR, $e->getMessage());
    	}
    }
    
    public function withdrawLists(Request $request)
    {
    	try {
    		if (!$user = JWTAuth::parseToken()->authenticate()) {
    			return response()->json(Output::makeResult($request, null, Error::MISS_USER), 404);
    		}
    		
    		$where = [
    				'user_id' => $user->id,
    		];
    		$ret = WithdrawLog::where($where)->paginate(intval($request->per_page));
    		return Output::makeResult($request, ['lists' => $ret]);
    	} catch (\Exception $e) {
    		return Output::makeResult($request, null, Error::SYSTEM_ERROR, $e->getMessage());
    	}
    }
    
}
