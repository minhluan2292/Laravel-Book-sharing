<?php
namespace App\Providers;

use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\Log;

class RequestHelper 
{
    private function handleFailedRequest($user_id, $action, $log_error_message)
    {
        $result = SalesForceErrorLog::create(['user_id' => $user_id, 'action' => $action]);
        Log::error(sprintf('SALESFORCE: user id : %s, log error id: %s. Raw response error: %s', $user_id, isset($result->id) ? $result->id : 'Failed to insert to error log', $log_error));
    }
    private function executeRequest($data, $method, $url, $createdNew = false)
    {   
        
    }
    public static function simpleExecuteURL($url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return "error";
        } else {
            return json_decode($response);
        }
    }


}