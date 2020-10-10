<?php

namespace App;

use  App\Exceptions\Handler;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\itexmoo;
use App\functions;
use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\Model\SendMessageRequest;
use Carbon\Carbon;
use App\DateTime;


class functions {
    

    function splitmeternum1($message){
        list($first, $second, $third, $stat1, $stat2, $stat3, $end) = preg_split('[,]', $message);
        $array = str_split($first, 1);
        $meternumfin1 = $array[1];

        return $meternumfin1;
    }

    function splitmeternum2($message){
        list($first, $second, $third, $stat1, $stat2, $stat3, $end) = preg_split('[,]', $message);
        
        return $second;
    }

    function splitmeternum3($message){
        list($first, $second, $third, $stat1, $stat2, $stat3, $end) = preg_split('[,]', $message);
        
        return $third;
    }

    function splitstat1($message){
        list($first, $second, $third, $stat1, $stat2, $stat3, $end) = preg_split('[,]', $message);
        $array = str_split($stat1, 1);
        $statfin1 = $array[1];

        return $statfin1;
    }

    function splitstat2($message){
        list($first, $second, $third, $stat1, $stat2, $stat3, $end) = preg_split('[,]', $message);
       
        return $stat2;
    }

    function splitstat3($message){
        list($first, $second, $third, $stat1, $stat2, $stat3, $end) = preg_split('[,]', $message);
       
        return $stat3;
    }



    function splitmeternumfirst($message){
        list($first, $second, $stat1, $stat2, $end) = preg_split('[,]', $message);
        $array = str_split($first, 1);
        $meternumfin1 = $array[1];

        return $meternumfin1;
    }

    function splitmeternumsecond($message){
        list($first, $second,$stat1, $stat2, $end) = preg_split('[,]', $message);
        
        return $second;
    }

    function splitstatfirst($message){
        list($first, $second, $stat1, $stat2, $end) = preg_split('[,]', $message);
        $array = str_split($stat1, 1);
        $statfin1 = $array[1];

        return $statfin1;
    }


    function splitstatsecond($message){
        list($first, $second, $stat1, $stat2, $end) = preg_split('[,]', $message);
       
        return $stat2;
    }



    
    function splitmeternum($message){
        
        list($meternum, $stat, $end) = preg_split('[,]', $message);
        $array = str_split($meternum, 1);
        $meternumfin = $array[1];
        
        return $meternumfin;
    }

    function splitstatus($message){
        
        list($meternum, $stat, $end) = preg_split('[,]', $message);
        $array = str_split($stat, 1);
        $status = $array[1];
        
        return $status;
    }


    function smsReconnect($meternum, $currentTime){
        $datetime = new DateTime();
        $account = DB::table('accounts')->where('meter_number', $meternum)->first();
        $smsBodyy =  $currentTime . " " . $account->account_number . "/" . $account->account_name . ". Your account had just been reconnected. Thank you.";
        
        return $smsBodyy;
    }

    function smsDisconnect($meternum, $currentTime){
        $datetime = new DateTime();
        $account = DB::table('accounts')->where('meter_number', $meternum)->first();
        $smsBodyy =  $currentTime . " " . $account->account_number . "/" . $account->account_name . ". Your account had just been disconnected. Please pay immediately with the reconnection fee to continue your electrical service. Thank you.";
        
        return $smsBodyy;
    }


    function sendnotif($smsBodyy, $meternum){
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU4MzY2NDY3NSwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjc3ODg5LCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.h_B-LUEd5-XwsMThdLwTKNDyRSb7-fqqKEwbwi21f1w";
        
        $account = DB::table('accounts')->where('meter_number', $meternum)->first();

        $array_fields['phone_number'] = $account->contact_number;
        $array_fields['message'] = $smsBodyy;
        $array_fields['device_id'] = 115988;
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://smsgateway.me/api/v4/message/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 50,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "[  " . json_encode($array_fields) . "]",
            CURLOPT_HTTPHEADER => array(
                "authorization: $token",
                "cache-control: no-cache"
            ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            dd($err);
        } else {
                // dd($response);
        }
        //end send message
    }

    function sendDisconnection($mobilenum, $smsBody){
        $array_fields['phone_number'] = $mobilenum;
        $array_fields['message'] = $smsBody;
        $array_fields['device_id'] = 115988;
        

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://smsgateway.me/api/v4/message/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 50,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "[  " . json_encode($array_fields) . "]",
            CURLOPT_HTTPHEADER => array(
                "authorization: $token",
                "cache-control: no-cache"
            ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        
        if ($err) {
            dd($err);
        } else {
                // dd($response);
        }
        //end send message   
    }



    function deletefromProcessAcc($meternum){
        DB::table('processaccounts2')
        ->where('meter_number', '=', $meternum)->delete();
    }

    function updatestatusOne($meternum){
        DB::table('accounts')
        ->where('meter_number', '=', $meternum)
        ->update(['status' => '1']);
    }

    function updatestatusZero($meternum){
        DB::table('accounts')
        ->where('meter_number', '=', $meternum)
        ->update(['status' => '0']);
    }

    function addReconnectedT($meternum, $currentTime){
        $account = DB::table('accounts')->where('meter_number', $meternum)->first();
        
        DB::table('reconnectedaccounts')
        ->insert([
            'account_number' => $account->account_number,
            'meter_number' => $account->meter_number,
            'account_name' => $account->account_name,
            'time' => $currentTime
        ]);
    }

    function addDisconnectedT($meternum, $currentTime){
        $account = DB::table('accounts')->where('meter_number', $meternum)->first();
        
        DB::table('disconnectedaccounts')
        ->insert([
            'meter_number' => $account->meter_number,
            'account_number' => $account->account_number,
            'account_name' => $account->account_name,
            'address' => $account->address,
            'category' => $account->category,
            'accounts_posts_id' => $account->accounts_posts_id,
            'post_type' => $account->post_type,
            'contact_number' => $account->contact_number,
            'status' => '0',
            'time' => $currentTime
        ]);
    }

    function deletefromDisconnectedAcc($meternum, $messageTime){
        DB::table('disconnectedaccounts')
        ->where('meter_number', '=', $meternum)
        ->where('time', '=', $messageTime)->delete();
    }

}