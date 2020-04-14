<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Omnipay\Omnipay;

class VipPrice extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static function getPrice($type)
    {
        $price = 0.00;
        $obj = self::find($type);
        if ($obj) {
            $price = $obj->price;
        }
        return $price;
    }
	
	public static function generateOrderNo($prefix = null, $user_id = null)
	{
		return $prefix . date('YmdHis') . rand(100000, 999999) . $user_id;
	}
	
	public static function wxpay($request)
    {
		$vip_type = $request->input('vip_type', '1');
		$payment_code = 'wechatpay';
		$payment = Payment::where('payment_code', $payment_code)->firstOrFail();
        $prefix = 'YJVIP';
        $order_no = self::generateOrderNo($prefix, Auth::id());
        $pay_total = VipPrice::getPrice($vip_type);
        $record = [
            'user_id'         => Auth::id(),
            'order_no'        => $order_no,
            'vip_type'        => $vip_type,
            'payment_code'    => $payment_code,
            'payment_name'    => $payment->payment_name,
            'pay_status'      => '0',
            'pay_status_name' => '未支付',
            'pay_total'       => $pay_total,
            'pay_no'          => '',
        ];
        $ret  = VipBuyOrder::create($record);
        //微信支付
		//gateways: WechatPay_App, WechatPay_Native, WechatPay_Js, WechatPay_Pos, WechatPay_Mweb
		$gateway    = Omnipay::create('WechatPay_Native');
        $gateway->setAppId(env('WECHATPAY_APP_ID'));
        $gateway->setMchId(env('WECHATPAY_MCH_ID'));
        $gateway->setApiKey(env('WECHATPAY_MCH_API_KEY'));//注意这里的 ApiKey 是我们在微信商户后台设置的一个32位的随机字符串，和微信公众号里面的 AppSecret 不是一回事。
        $gateway->setNotifyUrl(env('APP_URL') . '/notify/weixin');

		$order = [
                'body'              => 'VIP',
                'out_trade_no'      => $record['order_no'],
                'total_fee'         => intval($record['pay_total'] * 100),
                'spbill_create_ip'  => $request->getClientIp(),
                'fee_type'          => 'CNY',
        ];

		$response    = $gateway->purchase($order)->send();

        if ($response->isSuccessful()) {
            $tmp_data = $response->getData();
            $ret->pay_no = $tmp_data['prepay_id'];
            $ret->save();
            $code_url = $response->getCodeUrl(); //For Native Trade Type
            return $code_url;
        } else {
            return false;
        }
	}
	
	
	
	public static function alipay($request)
    {
		$payment_code = 'alipay';
		$payment = Payment::where('payment_code', $payment_code)->firstOrFail();
        $prefix = 'YJVIP';
        $order_no = self::generateOrderNo($prefix, Auth::id());
        $pay_total = VipPrice::getPrice($request->vip_type);
        $record = [
                'user_id'         => Auth::id(),
                'order_no'        => $order_no,
                'vip_type'        => $request->vip_type,
                'payment_code'    => $payment_code,
                'payment_name'    => $payment->payment_name,
                'pay_status'      => '0',
                'pay_status_name' => '未支付',
                'pay_total'       => $pay_total,
                'pay_no'          => '',
        ];
        $ret  = VipBuyOrder::create($record);
        //支付宝
        $gateway = Omnipay::create('Alipay_AopPage');
        $gateway->setSignType('RSA2'); //RSA/RSA2
        $gateway->setAppId(env('ALIPAY_APP_ID'));
        $gateway->setPrivateKey(env('ALIPAY_APP_PRIVATE_KEY'));
        $gateway->setAlipayPublicKey(env('ALIPAY_PUBLIC_KEY'));
        $gateway->setReturnUrl(url('/member'));
        $gateway->setNotifyUrl(url('/notify/alipay'));

        $ali_request = $gateway->purchase();
        $ali_request->setBizContent([
            'out_trade_no' => $record['order_no'],
            'total_amount' => $record['pay_total'],
            'subject'      => 'VIP购买',
            'product_code' => 'FAST_INSTANT_TRADE_PAY',
        ]);

        /**
         * @var AopTradePagePayResponse $response
         */
        $ali_response = $ali_request->send();

		if ($ali_response) {
			return $ali_response->getRedirectUrl();
		} else {
			return false;
		}
	}
}
