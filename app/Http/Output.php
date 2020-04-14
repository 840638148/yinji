<?php

namespace App\Http;


use App\Http\Error;
use Illuminate\Http\Request;
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;

class Output
{
    public static function makeResult(Request $request, $data = null, $status_code = ERROR::IS_OK, $message = '')
    {
        $ret = [ 'status_code' => intval($status_code) ];
        
        if ($message != '') {
            $ret['message'] = $message;
        } elseif (Error::getErrorMessage($status_code)) {
        	$ret['message'] = Error::getErrorMessage($status_code);
        }
        
        if ($data !== null) {
            $ret['data'] = $data;
        }
        
        $logger = new Logger('api-access-log');
        $filename = env('API_LOG_PATH', '/data/logs/api/') . date('Ymd') . '.log';
        $logger->pushHandler(new StreamHandler($filename, Logger::DEBUG));

        $logInfo = ['url' => $request->fullUrl(), 'header' => $request->header(), 'request' => $request->all(), 'response' => $ret];
        $logger->info('', $logInfo);
        
        return $ret;
    }
};
