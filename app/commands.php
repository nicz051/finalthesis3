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


class commands {
    

    function sendreminder(){
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU4MDU1OTc5OCwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjc3MTA4LCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.0itAev15AZH70jnynEZbqL5K0Z_YQe-Kvp1m5MZ_Ij0";
        $currentTime = date("Y-m-d H:i:s", strtotime("now")); //current time

        $accountsdue = DB::table('accounts')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                        ->from('bills')
                        ->whereRaw('bills.bills_account_number = accounts.account_number')
                        ->whereRaw('bills.due_date = CURDATE()')
                        ->whereRaw('bills.status = 0');
            })
            ->get();

            $accountsoverdue = DB::table('accounts')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                        ->from('bills')
                        ->whereRaw('bills.bills_account_number = accounts.account_number')
                        ->whereRaw('bills.due_date < CURDATE()')
                        ->whereRaw('bills.status = 0');
            })
            ->get();

        foreach($accountsdue as $key => $account){
            
            $smsBody= $currentTime . " " . $account->account_number . "/" . $account->account_name . ". Your account is due today.Please pay today to avoid disconnection and extra fee.";
            // echo $smsBody;
            // echo $account->contact_number;
            // echo "\n";
                //start send message
                    $array_fields['phone_number'] = $account->contact_number;
                    $array_fields['message'] = $smsBody;
                    $array_fields['device_id'] = 115242;


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
        
        //
        }

        foreach($accountsoverdue as $key => $account){
            
            $smsBody= $account->account_number . "/" . $account->account_name . ". Your account is overdue.Please pay today to avoid disconnection and extra fee.";
            // echo $smsBody . " ";
            // echo $account->contact_number;
            // echo "\n";
            //start send message
                    $array_fields['phone_number'] = $account->contact_number;
                    $array_fields['message'] = $smsBody;
                    $array_fields['device_id'] = 115242;


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
    }

}