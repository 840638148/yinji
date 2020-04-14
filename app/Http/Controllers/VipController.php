<?php

namespace App\Http\Controllers;

use DB;
use App\Models\UserCollect;
use App\Models\Article;
use App\Models\UserCollectFolder;
use App\Models\UserFinder;
use App\Models\UserFollow;
use App\Models\UserFinderFolder;
use App\Models\UserSubscription;
use App\Models\VipPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use SmsManager;
use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;
use App\Http\Error;
use App\Http\Output;
use App\User;
use App\Models\Payment;
use App\Models\VipBuyOrder;
use Omnipay\Omnipay;
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;


class VipController extends Controller
{
    public function __construct() {
        if (!Auth::check()) {
            return redirect('/');
        }
    }

   
    public function intro(Request $request)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';

        $user = $this->getUserInfo();
        $month_price = VipPrice::getPrice(1);
        $season_price = VipPrice::getPrice(2);
        $year_price = VipPrice::getPrice(3);

        $data = [
            'lang' => $lang,
            'user' => $user,
            'month_price' => $month_price,
            'season_price' => $season_price,
            'year_price' => $year_price,
        ];
        return view('vip.intro', $data);
    }
    
    public function ad(Request $request)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';
        $user = $this->getUserInfo();
         $data = [
            'lang' => $lang,
            'user' => $user,
        ];
        return view('vip.ad', $data);
    }
    public function job_service(Request $request)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';
        $user = $this->getUserInfo();
        $month_price = VipPrice::getPrice(1);
        $season_price = VipPrice::getPrice(2);
        $year_price = VipPrice::getPrice(3);

        $data = [
            'lang' => $lang,
            'user' => $user,
            'month_price' => $month_price,
            'season_price' => $season_price,
            'year_price' => $year_price,
        ];
        return view('vip.job_service', $data);
    }
    
    public function promotion(Request $request)
    {
         $lang = $request->session()->get('language') ?? 'zh-CN';
         $user = $this->getUserInfo();
         $data = [
            'lang' => $lang,
            'user' => $user,
        ];
        return view('vip.promotion', $data);
    }
    
    public function vip_service(Request $request)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';
        $user = $this->getUserInfo();
        $month_price = VipPrice::getPrice(1);
        $season_price = VipPrice::getPrice(2);
        $year_price = VipPrice::getPrice(3);

        $data = [
            'lang' => $lang,
            'user' => $user,
            'month_price' => $month_price,
            'season_price' => $season_price,
            'year_price' => $year_price,
        ];
        return view('vip.vip_service', $data);
    }

    public function finder(Request $request)
    {
    	
        $lang = $request->session()->get('language') ?? 'zh-CN';

        $user = $this->getUserInfo();
//        if (!$user || true !== $user->is_vip) {
//            return redirect('vip/intro');
//        }
        $month_price = VipPrice::getPrice(1);
        $season_price = VipPrice::getPrice(2);
        $year_price = VipPrice::getPrice(3);

        if ($user) {
            $user->finders = UserFinder::recommendFinders($user->id);
            $user->collections = UserFinder::recommendFolders($user->id);
            $user->recommend_users = UserFinder::recommendUsers($user->id);
			$user->my_folders = UserFinder::getMyFolders($user->id);
        } else {
			$user = new \StdClass();
            $user->finders = UserFinder::recommendFinders();
            $user->collections = UserFinder::recommendFolders();
            $user->recommend_users = UserFinder::recommendUsers();
            $user->my_folders = UserFinder::getMyFolders();
            
		}
        
        // dd($user);
		//查出已经收藏的
		$user_id = Auth::id();
		$issc = UserCollect::where('user_id', $user_id)->get();
		$issc=json_encode($issc);

        $data = [
            'lang' => $lang,
            'user' => $user,
            'month_price' => $month_price,
            'season_price' => $season_price,
            'year_price' => $year_price,
            'issc' => $issc,
        ];
        return view('vip.finder', $data);
    }

	//发现-->推荐收藏夹-->通过用户id来显示收藏夹的列表
    public function folderlist(Request $request)
    {
    	
        $lang = $request->session()->get('language') ?? 'zh-CN';
		$user_id = Auth::id();
		$user = $this->getUserInfo();
        
        //通过user_id查出该收藏夹和收藏夹下的信息
        $folistname=UserFinderFolder::where('user_finder_folders.id',$request->id)->get()->toArray();//收藏夹文件名
        $folist=UserFinderFolder::where('user_finder_folders.id',$request->id)->leftjoin('user_finders','user_finder_folders.id','user_finders.user_finder_folder_id')->get()->toArray();
        
        //通过遍历将文章的标题和跳转地址放进去
        foreach ($folist as $key =>$folists){
        	$articleid=Article::where('id',$folists['photo_source'])->get()->toArray();
			foreach ($articleid as $aid){
        		$articlename=$aid['title_name_cn'].$aid['title_intro_cn'];
		        $folist[$key]['articlename']=$articlename;
		        $folist[$key]['static_url']=$aid['static_url'];
			}
        }
    	//通过用户id获取收藏夹名字
    	$userscname = UserFinderFolder::where('user_finder_folders.user_id',$user_id)->get()->toArray();
        $data = [
            'lang' => $lang,
            'user' => $user,
            'articleid' => $articleid,
            'folist' => $folist,
            'folistname' => $folistname,
            'articlename' => $articlename,
            'userscname' => $userscname,
        ];
        return view('vip.folderlist', $data);
    } 
    
    //推荐收藏中心的收藏api
    public function addfolders(Request $request){
    	// dd('123');
    	$result = UserCollect::foldercollectById('0', $request);
		
        if (true === $result) {
            return Output::makeResult($request, null);
        }
        return Output::makeResult($request, null, Error::SYSTEM_ERROR, $result);
    }
    
    //推荐收藏中心的收藏的真实状态
    public function scstatus(Request $request){
    	
    	$result = UserCollect::where('user_id', Auth::id())->where('collect_id',$request->collect_id)
    	    ->where('user_collect_folder_id', $request->folder_id)
    	    ->where('photourl', $request->tpsrc)->first();
    	if (is_null($result)) {
    		// 没被收藏
    		return Output::makeResult($request, null,ERROR::IS_OK);
    	} else {
    		//已收藏
    		$result = $result->toArray();
    		return Output::makeResult($request, null, Error::SYSTEM_ERROR, $result);
    	}
		
		
    }
    

    public function addFinder(Request $request)
    {
        if (empty($request->user_finder_folder_id)) {
            return Output::makeResult($request, null, 500, '请选择收藏夹');
        }
        if (empty($request->photo_url)) {
            return Output::makeResult($request, null, 500, '请选择图片');
        }
        if (empty($request->photo_source)) {
            return Output::makeResult($request, null, 500, '缺少文章来源');
        }

        $result = UserFinder::finderByUrl($request);
        if (true === $result) {
            return Output::makeResult($request, null);
        } else {
            return Output::makeResult($request, null, Error::SYSTEM_ERROR, $result);
        }
    }

    public function addFinderFolder(Request $request)
    {	
    	$user_id = Auth::id();
    	//一个用户不能有重复的文件名，不同用户可以创建相同的文件名
    	$findername=UserFinderFolder::where('user_id',$user_id)->get()->toArray();
		
		// dd($findername);
		//查询到为空的，说明没有记录，判断不为空时
		if($findername != null){  
			if(empty($request->finder_folder_name)){ 
	            return Output::makeResult($request, null, 500, '请填写发现夹名称');   
	    	}
	
	    	foreach ($findername as $k=>$fname){
	    		if($fname['name'] == $request->finder_folder_name) {
	        		return Output::makeResult($request, null, 500, '文件夹名不能重复');
	    		}   
	    	}
	    
		}
	
		 	
	        $folder_data = [   
	            'user_id' => $user_id,   
	            'name' => $request->finder_folder_name,
	            'brief' => $request->finder_folder_brief,
	            'is_open' => $request->is_open,
	            'created_at' => now(),  
	            'updated_at' => now(),
	        ];  
	        $result = UserFinderFolder::insertGetId($folder_data);
        
	        if ($result) {
	        	$folder_data['kid'] = $result;    
	        	$folder_data['status_code'] = 0; 
	        	$folder_data['articleid']=$request->articleid;  
	        	return json_encode($folder_data);
	            //return Output::makeResult($request, null);
	        } else {
	            return Output::makeResult($request, null, Error::SYSTEM_ERROR);
	        }
	        
	
		
    }

    public function addCollectFolder(Request $request)
    {
        if (empty($request->collect_folder_name)) {
            return Output::makeResult($request, null, 500, '请填写收藏夹名称');
        }

        $collect_data = [
            'user_id' => Auth::id(),
            'name' => $request->collect_folder_name,
            'brief' => $request->collect_folder_brief,
            'is_open' => $request->is_open,
        ];
        $result = UserCollectFolder::insertgetid($collect_data);
        if ($result) {
        	return json_encode($collect_data);
            //return Output::makeResult($request, null);
        } else {
            return Output::makeResult($request, null, Error::SYSTEM_ERROR);
        }
    }



    public function deleteFolder(Request $request)
    {
        if (empty($request->folder_id) || empty($request->folder_type)) {
            return Output::makeResult($request, null, 500, '请选择收藏夹');
        }

        $user_id = Auth::id();
        if ('find' == $request->folder_type) {
            $obj = UserFinderFolder::where('user_id', $user_id)
            ->where('id', $request->folder_id)
            ->first();
        } else {
            $obj = UserCollectFolder::where('user_id', $user_id)
                ->where('id', $request->folder_id)
                ->first();
        }
        if ($obj) {
            if ('find' == $request->folder_type) {
                UserFinder::where('user_finder_folder_id', $request->folder_id)->delete();
            } else {
                UserCollect::where('user_collect_folder_id', $request->folder_id)->delete();
            }
            $obj->delete();
            return Output::makeResult($request, null);
        } else {
            return Output::makeResult($request, null, Error::SYSTEM_ERROR, '收藏夹不存在');
        }
    }

    /**
     * 获取文件夹的信息（名称，简介，是否公开）
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFolderInfo(Request $request)
    {
        $user_id = Auth::id();
        if ('find' == $request->folder_type) {
            $obj = UserFinderFolder::where('user_id', $user_id)
                ->where('id', $request->folder_id)
                ->first();
        } else {
            $obj = UserCollectFolder::where('user_id', $user_id)
                ->where('id', $request->folder_id)
                ->first();
        }
        if ($obj) {
            $folder_info = [
                'id' => $obj->id,
                'name' => $obj->name,
                'brief' => $obj->brief,
                'is_open' => $obj->is_open,
            ];
            return Output::makeResult($request, $folder_info);
        } else {
            return Output::makeResult($request, null, Error::SYSTEM_ERROR, '收藏夹不存在');
        }
    }

    /**
     * 编辑文件夹的信息（名称，简介，是否公开）
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editFolderInfo(Request $request)
    {
        $user_id = Auth::id();
        if ('find' == $request->folder_type) {
            $obj = UserFinderFolder::where('user_id', $user_id)
                ->where('id', $request->folder_id)
                ->first();
        } else {
            $obj = UserCollectFolder::where('user_id', $user_id)
                ->where('id', $request->folder_id)
                ->first();
        }
        if ($obj) {
            $obj->name = $request->folder_name;
            $obj->brief = $request->folder_brief;
            $obj->is_open = $request->is_open;
            $obj->save();
            return Output::makeResult($request, null);
        } else {
            return Output::makeResult($request, null, Error::SYSTEM_ERROR, '收藏夹不存在');
        }
    }

    /**
     * 获取文件夹的详细内容，包含图片
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFolderDetail(Request $request)
    {
        $folder_id = $request->folder_id;
        $folder_detail = UserFinder::getFolderDetail($folder_id);
        // $folder_details = UserFinder::where('user_finder_folder_id',$folder_id)->get()->toArray();
        // $folder_details = UserFinder::leftjoin('user_finder_folders','user_finders.user_finder_folder_id','user_finder_folders.id')->get()->toArray();
        if (Auth::check()) {
            $user_finder_folders = UserFinderFolder::getSelectOptionsByUserId(Auth::id());
            $user_collect_folders = UserCollectFolder::getSelectOptionsByUserId(Auth::id());
            
        } else {
            $user_finder_folders = [];
            $user_collect_folders = [];
        }
        
        // dd($folder_detail['article']->title_designer_cn);
        $title = $folder_detail['article']->title_designer_cn.' | '.$folder_detail['article']->title_intro_cn;
        
		foreach ($folder_detail['images'] as $k=>$v){
			$folder_detail['images'][$k]['titlename']=$title;
	    }
		// dd($folder_detail);
		//判断是否为vip
		 $user_id = Auth::id();
		 $isvip=UserFinderFolder::where('user_id',$user_id)->leftjoin('users','user_finder_folders.id','users.id')->first()->toArray();

		//通过连表左查询查出已经收藏的
		$issc=UserFinder::where('user_finders.user_id',$user_id)->leftjoin('user_finder_folders','user_finder_folders.id','user_finders.user_finder_folder_id')->get()->toArray();

		
	
		$data=[
			'folder_detail'=>$folder_detail,
			'isvip'=>$isvip,
			'issc'=>$issc,
		];
		
        return view('vip.folder_detail', $data);
    }
    
    public function generateOrderNo($prefix = null, $user_id = null)
	{
		return $prefix . date('YmdHis') . rand(100000, 999999) . $user_id;
	}
	
	/**
	 * 支付前检查
	 */
	public function prePay(Request $request)
	{
		$user = $this->getUserInfo();
        if (isset($user) && $user->is_vip) {
            return Output::makeResult($request, null, Error::SYSTEM_ERROR, '您已经是本站会员！');
        }
		
		$wx_url = VipPrice::wxpay($request);
		$alipay_url = VipPrice::alipay($request);
		return Output::makeResult($request, ['wx_url' => $wx_url, 'alipay_url' => $alipay_url]);
	}

    public function pay(Request $request)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';
        $user = $this->getUserInfo();
        $vip_type = $request->input('vip_type', '1');

        $pay_total = $pay_total = VipPrice::getPrice($vip_type);
		switch ($vip_type) {
			case '1':
				$order_title = '印际月度会员';
				break;
			case '2':
				$order_title = '印际季度会员';
				break;
			case '3':
				$order_title = '印际年度会员';
				break;
			default:
			    $order_title = '印际月度会员';
		}
        
        $point_total = 1;
		
		
        $wx_code_url = '';

        $data = [
            'lang' => $lang,
            'user' => $user,
            'pay_total' => $pay_total,
            'point_total' => $point_total,
            'order_title' => $order_title,
            'wx_code_url' => $wx_code_url,
        ];
        return view('vip.pay', $data);
    }

    public function buy(Request $request)
    {
        $user = $this->getUserInfo();
        if (isset($user) && $user->is_vip) {
            return Output::makeResult($request, null, Error::SYSTEM_ERROR, '您已经是本站会员！');
        }
        $payment = Payment::where('payment_code', $request->payment_code)->firstOrFail();
        $prefix = 'YJVIP';
        $order_no = $this->generateOrderNo($prefix, Auth::id());
        $pay_total = VipPrice::getPrice($request->vip_type);
        $record = [
                'user_id'         => Auth::id(),
                'order_no'        => $order_no,
                'vip_type'        => $request->vip_type,
                'payment_code'    => $request->payment_code,
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

        $redirect_url = $ali_response->getRedirectUrl();
        return Output::makeResult($request, ['payment_code' => $request->payment_code, 'alipay_url' => $redirect_url]);
        //$ali_response->redirect();
    }

    public function wxbuy(Request $request)
    {
        $user = $this->getUserInfo();
        if (isset($user) && $user->is_vip) {
            return Output::makeResult($request, null, Error::SYSTEM_ERROR, '您已经是本站会员！');
        }
        $payment = Payment::where('payment_code', $request->payment_code)->firstOrFail();
        $prefix = 'YJVIP';
        $order_no = $this->generateOrderNo($prefix, Auth::id());
        $pay_total = VipPrice::getPrice($request->vip_type);
        $record = [
            'user_id'         => Auth::id(),
            'order_no'        => $order_no,
            'vip_type'        => $request->vip_type,
            'payment_code'    => $request->payment_code,
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
                //'open_id'           => $request->open_id,
        ];

		$response    = $gateway->purchase($order)->send();

		//available methods
		//$response->isSuccessful();
		//$response->getData(); //For debug
		//$response->getAppOrderData(); //For WechatPay_App
		//$response->getJsOrderData(); //For WechatPay_Js
		//$response->getCodeUrl(); //For Native Trade Type
		//dd($order);

        if ($response->isSuccessful()) {
            $tmp_data = $response->getData();
            $payment_info = [
                    'prepay_id' => $tmp_data['prepay_id'],
            ];
            $ret->pay_no = $tmp_data['prepay_id'];
            $ret->save();
            $code_url = $response->getCodeUrl(); //For Native Trade Type
            return Output::makeResult($request, ['code_url' => $code_url, 'payment_info' => $payment_info]);
        } else {
            return Output::makeResult($request, $response->getData(), Error::CREATE_ORDER_FAIL);
        }

    }

    /**
     * 微信支付到账通知
     *
     * @param Request $request
     */
    public function weixinNotify(Request $request)
    {
        $gateway = Omnipay::create('WechatPay');
        $gateway->setAppId(env('WECHATPAY_APP_ID'));
        $gateway->setMchId(env('WECHATPAY_MCH_ID'));
        $gateway->setApiKey(env('WECHATPAY_MCH_API_KEY'));//注意这里的 ApiKey 是我们在微信商户后台设置的一个32位的随机字符串，和微信公众号里面的 AppSecret 不是一回事。

        try {
            $response = $gateway->completePurchase([
                'request_params' => file_get_contents('php://input')
            ])->send();
            $requestData = $response->getRequestData();

            $logger = new Logger('alipay-notify-log');
            $logger->pushHandler(new StreamHandler('/tmp/weixin-notify.log', Logger::DEBUG));
            $logInfo = ['ali_response' => $requestData];
            $logger->info('', $logInfo);

            if ($response->isPaid()) {
                //pay success

                $order = VipBuyOrder::where('order_no', $requestData['out_trade_no'])->first();
                if ($order) {
                    if (2 == $order->pay_status) {
                        $logInfo = ['status' => '已经支付', 'request' => $requestData, 'order_info' => $order];
                        $logger->info('', $logInfo);
                        die('success');
                    }

                    if ($requestData['total_fee'] != intval($order->pay_total * 100)) {
                        $logInfo = ['status' => '支付金额不符', 'request' => $requestData, 'order_info' => $order];
                        $logger->info('', $logInfo);

                        die('success');
                    }
                    $order->pay_status      = '2';
                    $order->pay_status_name = '已支付';
                    $order->pay_time        = date('Y-m-d H:i:s');
                    $order->save();
                    VipBuyOrder::dealVip($order->order_no);

                } else {
                    $logInfo = ['error' => '没有找到该订单','request' => $requestData, 'order_info' =>$order];
                    $logger->info('', $logInfo);

                    die('success');
                }
                die('success'); //The notify response should be 'success' only
            }else{
                //pay fail
                die('fail'); //The notify response
            }
        } catch (Exception $e) {
            /**
             * Payment is not successful
             */
            die('fail'); //The notify response
        }

    }

    /**
     * 支付宝到账通知
     *
     * @param Request $request
     */
    public function alipayNotify(Request $request)
    {
        $post_data = array_merge($_POST, $_GET);
		file_put_contents('/tmp/alipay.log', var_export($post_data, true), FILE_APPEND);

        $gateway = Omnipay::create('Alipay_AopPage');
        $gateway->setSignType('RSA2'); //RSA/RSA2
        $gateway->setAppId(env('ALIPAY_APP_ID'));
        $gateway->setPrivateKey(env('ALIPAY_APP_PRIVATE_KEY'));
        $gateway->setAlipayPublicKey(env('ALIPAY_PUBLIC_KEY'));

        $ali_request = $gateway->completePurchase();
        $ali_request->setParams($post_data); //Don't use $_REQUEST for may contain $_COOKIE

        /**
         * @var AopCompletePurchaseResponse $response
         */
        try {
            $ali_response = $ali_request->send();

            $logger = new Logger('alipay-notify-log');
            $logger->pushHandler(new StreamHandler('/tmp/alipay-notify.log', Logger::DEBUG));
            $logInfo = ['ali_response' => $ali_response];
            $logger->info('', $logInfo);


            if($ali_response->isPaid()){
                $order = VipBuyOrder::where('order_no', $post_data['out_trade_no'])->first();
                if ($order) {
                    if (2 == $order->pay_status) {
                        $logInfo = ['status' => '已经支付', 'request' => $post_data, 'order_info' => $order];
                        $logger->info('', $logInfo);
                        return 'success';
                    }

                    if ($post_data['total_amount'] != $order->pay_total) {
                        $logInfo = ['status' => '支付金额不符', 'request' => $post_data, 'order_info' => $order];
                        $logger->info('', $logInfo);

                        return 'success';
                    }
                    $order->pay_status      = '2';
                    $order->pay_status_name = '已支付';
                    $order->pay_no          = $post_data['trade_no'];
                    $order->pay_time        = $post_data['gmt_payment'];
                    $order->save();
                    VipBuyOrder::dealVip($order->order_no);

                }  
                die('success'); //The notify response should be 'success' only
            }else{
                /**
                 * Payment is not successful
                 */
                die('fail'); //The notify response
            }
        } catch (Exception $e) {
            /**
             * Payment is not successful
             */
            die('fail'); //The notify response
        }
    }
}
