<?php

namespace App\Http;

class Error
{
	////////////////系统状态代码////////////////
	const IS_OK                = 0;       //Everything is OK
	const USER_NOT_LOGIN       = -1;      //用户未登录
	
	
	////////////////系统错误代码////////////////
	const UNKNOWN_ERROR        = 100000;  //未知错误
	const SYSTEM_ERROR         = 100001;  //系统错误
	const OUT_OF_SERVICE       = 100002;  //服务暂停
	const REMOTE_SERVER_ERROR  = 100003;  //远程服务错误
	const IP_LIMITED           = 100004;  //IP限制不能请求该资源
	const SYSTEM_BUSY          = 100005;  //系统繁忙
	const TASK_OVERTIME        = 100006;  //任务超时
	const ILLEGAL_REQUEST      = 100007;  //非法请求
	const INTERFACE_LIMITED    = 100008;  //接口访问权限受限
	const INTERFACE_NONEXISTS  = 100009;  //接口不存在
	const METHOD_NOT_SUPPORT   = 100010;  //请求的HTTP METHOD不支持，请检查是否选择了正确的POST/GET方式
	const TOKEN_ILLEGAL        = 100011;  //token非法
	const TOKEN_OVERTIME       = 100012;  //token过期absent
	const TOKEN_CREATE_FAILED  = 100013;  //token创建失败
	const TOKEN_ABSENT         = 100014;  //缺少token


	////////////////服务错误代码////////////////
	const MISS_PARAM           = 200001;  //参数验证错误
	const MISS_USER            = 200002;  //用户不存在
	const PHOTO_NOT_SUPPORT    = 200003;  //不支持的图片类型，仅仅支持JPG、GIF、PNG
	const PHOTO_TOO_LARGE      = 200004;  //图片太大
	const CONTENT_IS_NULL      = 200005;  //内容为空
	const TEXT_TOO_LONG_50     = 200006;  //输入文字太长，请确认不超过50个字符
	const TEXT_TOO_LONG_100    = 200007;  //输入文字太长，请确认不超过100个字符
	const REPEAT_CONTENT       = 200008;  //提交相同的信息
	const CONTENT_ILLEGAL      = 200009;  //包含非法内容
	const TEST_AND_VERIFY      = 200010;  //需要验证码(请先发送验证码)
	const LIST_NOT_EXISTS      = 200011;  //列表不存在
	const OBJECT_EXISTS        = 200012;  //记录已存在
	const DB_ERROR             = 200013;  //数据库错误，请联系系统管理员
	const MOBILE_EXISTS        = 200014;  //该手机号已经被使用
	const PASSWORD_ERROR       = 200015;  //用户名或密码不正确
	const CAPTCHA_ILLEGAL      = 200016;  //验证码不正确
	const CAPTCHA_OVERTIME     = 200017;  //验证码超时
	const CAPTCHA_LIMITED      = 200018;  //验证码多次输入错误
	const PASSWORD_CONFIRM_ERR = 200019;  //两次输入密码不一致
	const EMPTY_DEPOSIT        = 200020;  //未充值押金
	const BOOKING_FAILED       = 200021;  //预约失败
	const BOOKING_EXISTS       = 200022;  //已经存在预约
	const ORDER_EXISTS         = 200023;  //存在未完成订单
	const UMBRELLA_CANNOT_BUY  = 200024;  //该雨伞不可购买
	const BALANCE_NOT_ENOUGH   = 200025;  //余额不足
	const UMBRELLA_CANNOT_DELAY= 200026;  //该雨伞不可延期
	const UMBRELLA_NOT_USE     = 200027;  //雨伞不在使用中
	const UMBRELLA_HOLE_INUSE  = 200028;  //伞孔使用中
	const OBJECT_NOT_EXISTS    = 200029;  //记录不存在
	const NOT_ENTERPRISE       = 200030;  //非有效企业用户
	const UNLOCK_FAILED        = 200031;  //开锁失败
	const DEPOSIT_EXISTS       = 200032;  //已充值押金
	const REFUND_HANDLE        = 200033;  //退款处理中
	const WITHDRAW_MIN_10      = 200034;  //大于10元才可提现
	const WITHDRAW_EXISTS      = 200035;  //您有未完成的提现记录
	const UMBRELLA_HAS_BUY     = 200036;  //您已经购买过该雨伞
	const CREATE_ORDER_FAIL    = 200037;  //下单失败
	const UMBRELLA_IN_USE      = 200038;  //雨伞正在使用中
	const USER_CANNOT_DELAY    = 200039;  //您已没有延期次数
	const WITHDRAW_NOT_ENOUGH  = 200040;  //提现金额不符
	const UMBRELLA_INACTIVE    = 200041;  //没有可用的雨伞
	const UNKNOWN_STAND_ID     = 200042;  //无法识别的伞架ID
	
	
	public static function getErrorMessage($statusCode = null)
	{
		$errorMsg = [
				////////////////系统状态代码////////////////
				self::IS_OK                => 'Everything is OK',
				self::USER_NOT_LOGIN       => '用户未登录',
				
				
				////////////////系统错误代码////////////////
				self::UNKNOWN_ERROR        => '未知错误',
				self::SYSTEM_ERROR         => '系统错误',
				self::OUT_OF_SERVICE       => '服务暂停',
				self::REMOTE_SERVER_ERROR  => '远程服务错误',
				self::IP_LIMITED           => 'IP限制不能请求该资源',
				self::SYSTEM_BUSY          => '系统繁忙',
				self::TASK_OVERTIME        => '任务超时',
				self::ILLEGAL_REQUEST      => '非法请求',
				self::INTERFACE_LIMITED    => '接口访问权限受限',
				self::INTERFACE_NONEXISTS  => '接口不存在',
				self::METHOD_NOT_SUPPORT   => '请求的HTTP METHOD不支持，请检查是否选择了正确的POST/GET方式',
				self::TOKEN_ILLEGAL        => 'token非法',
				self::TOKEN_OVERTIME       => 'token过期',
				self::TOKEN_CREATE_FAILED  => 'token创建失败',
				self::TOKEN_ABSENT         => '缺少token',
					
					
				////////////////服务错误代码////////////////
				self::MISS_PARAM           => '参数验证错误',
				self::MISS_USER            => '用户不存在',
				self::PHOTO_NOT_SUPPORT    => '不支持的图片类型，仅仅支持JPG、GIF、PNG',
				self::PHOTO_TOO_LARGE      => '图片太大',
				self::CONTENT_IS_NULL      => '内容为空',
				self::TEXT_TOO_LONG_50     => '输入文字太长，请确认不超过50个字符',
				self::TEXT_TOO_LONG_100    => '输入文字太长，请确认不超过100个字符',
				self::REPEAT_CONTENT       => '提交相同的信息',
				self::CONTENT_ILLEGAL      => '包含非法内容',
				self::TEST_AND_VERIFY      => '需要验证码(请先发送验证码)',
				self::LIST_NOT_EXISTS      => '列表不存在',
				self::OBJECT_EXISTS        => '记录已存在',
				self::DB_ERROR             => '数据库错误，请联系系统管理员',
				self::MOBILE_EXISTS        => '该手机号已经被使用',
				self::PASSWORD_ERROR       => '用户名或密码不正确',
				self::CAPTCHA_ILLEGAL      => '验证码不正确',
				self::CAPTCHA_OVERTIME     => '验证码超时',
				self::CAPTCHA_LIMITED      => '验证码多次输入错误',
				self::PASSWORD_CONFIRM_ERR => '两次输入密码不一致',
				self::EMPTY_DEPOSIT        => '未充值押金',
				self::BOOKING_FAILED       => '预约失败',
				self::BOOKING_EXISTS       => '已经存在预约',
				self::ORDER_EXISTS         => '存在未完成订单',
				self::UMBRELLA_CANNOT_BUY  => '该雨伞不可购买',
				self::BALANCE_NOT_ENOUGH   => '余额不足',
				self::UMBRELLA_CANNOT_DELAY=> '该雨伞不可延期',
				self::UMBRELLA_NOT_USE     => '雨伞不在使用中',
				self::UMBRELLA_HOLE_INUSE  => '伞孔使用中',
				self::OBJECT_NOT_EXISTS    => '记录不存在',
				self::NOT_ENTERPRISE       => '非有效企业用户',
				self::UNLOCK_FAILED        => '开锁失败',
				self::DEPOSIT_EXISTS       => '已充值押金',
				self::REFUND_HANDLE        => '退款处理中',
				self::WITHDRAW_MIN_10      => '大于10元才可提现',
				self::WITHDRAW_EXISTS      => '您有未完成的提现记录',
				self::UMBRELLA_HAS_BUY     => '您已经购买过该雨伞',
				self::CREATE_ORDER_FAIL    => '下单失败',
				self::UMBRELLA_IN_USE      => '雨伞正在使用中',
				self::USER_CANNOT_DELAY    => '您已没有延期次数',
				self::WITHDRAW_NOT_ENOUGH  => '提现金额不符',
				self::UMBRELLA_INACTIVE    => '没有可用的雨伞',
				self::UNKNOWN_STAND_ID     => '无法识别的伞架ID',
	];
		
		return isset($errorMsg[$statusCode]) ? $errorMsg[$statusCode] : null;
	}
};
