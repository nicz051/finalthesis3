<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\itexmoo;
use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\Model\SendMessageRequest;
use Carbon\Carbon;
use App\DateTime;
use App\functions;

class CheckIncomingMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU4MDU1OTc5OCwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjc3MTA4LCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.0itAev15AZH70jnynEZbqL5K0Z_YQe-Kvp1m5MZ_Ij0";
        $datetime = new DateTime();
        $deviceid = 115241;
        $function = new functions();


        //Start Read Messages
            $searchArray = [];

            $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://smsgateway.me/api/v4/message/search",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 50,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "[  " . json_encode($searchArray) . "]",
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
            $messagesRaw = json_decode($response);
            $filteredMessages = [];
                   


            // dd(date('Y-m-d H:i:s'));
            foreach ($messagesRaw->results as $key => $message) {
                                
                $currentTime = date("Y-m-d H:i:s", strtotime("now")); //current time
                $adjustedTime = date('Y-m-d H:i:s', strtotime('-5 minutes',strtotime("now"))); //subtract 5mins from current time
                $messageTime = date("Y-m-d H:i:s", strtotime($message->created_at));
                    
                if($message->status == 'received' && $message->device_id == '115242' && $messageTime >= $adjustedTime && $messageTime <= $currentTime){
                    $filteredMessages[] = $message;  
                }  
            }

            // dd($filteredMessages);
            foreach ($filteredMessages as $key => $message){ 

                $content = $message->message;

                // echo $content;
                // echo "<br>";

                //split string
                $meternum = $function->splitmeternum($content);
                $status = $function->splitstatus($content);

                //prepare smsbody
                if ($status = 1){
                    $smsbody = $function->smsReconnect($meternum, $currentTime);
                }else if ($status = 0){
                    $smsbody = $function->smsDisconnect($meternum, $currentTime);
                }

                //send notif
                $function->sendnotif($smsbody, $meternum);

                //update tables-delete row from processaccounts
                $function->deletefromProcessAcc($meternum);

                //update status from accounts and add row to reconnected acc
                if ($status = 1){
                    $function->updatestatusOne($meternum);
                    $function->addReconnectedT($meternum, $currentTime);
                }else if ($status = 0){
                    $function->updatestatusZero($meternum);
                }
                

            }
        }
            //End Read SMS
    }
}
