<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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

class SendDisconnection implements ShouldQueue
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
        $itexmoo=new itexmoo();
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU4MzY3NjkzMywiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjc3ODg5LCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.c9cJLkJ35t_QOkrl0t3Z_7o-f6PwtS0nWRfJ3F2rR0A";
        $currentTime = date("Y-m-d H:i:s", strtotime("now")); //current time

        $posts = DB::table('posts')->get();

        foreach ($posts as $key => $post) {
            $smsBody = "$";
            $accountsDisc = DB::table('accounts')
                    ->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('bills')
                            ->whereRaw('bills.bills_account_number = accounts.account_number')
                            ->whereRaw('bills.disconnection_date <= CURDATE()')
                            ->whereRaw('bills.status = 0');
                    })
                    ->where('accounts_posts_id',$post->id)->get();



                    foreach($accountsDisc as $key => $account){
                        // if($account->status == 0){
                            $smsBody .= $account->meter_number . ",";
                        // }
                    }
                    $smsBody .= '%';

                    foreach($accountsDisc as $key => $account){
                        // if($account->status == 0){
                            $smsBody .= 0 . ",";
                        // }
                    }
                    $smsBody .= '*';

                    $postnum = $post->mobilenum;




                    //start send message
                    $array_fields['phone_number'] = $post->mobilenum;
                    $array_fields['message'] = $smsBody;
                    $array_fields['device_id'] = 115991;
                    

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
                        //Start Read Messages
                        $searchArray = [];
                        $filteredMessages = [];
                        while(sizeof($filteredMessages) == 0){
                            $curl = curl_init();
                            $filteredMessages = [];
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
                
                                foreach ($messagesRaw->results as $key => $message) {
                                                    
                                    $currentTime = date("Y-m-d H:i:s", strtotime("now")); //current time
                                    $adjustedTime = date('Y-m-d H:i:s', strtotime('-5 minutes',strtotime("now"))); //subtract 5mins from current time
                                    $messageTime = date("Y-m-d H:i:s", strtotime($message->created_at));
                                        
                                    if($message->status == 'sent' && $message->device_id == '115991' && $message->message == $smsBody && $messageTime >= $adjustedTime && $messageTime <= $currentTime){
                                        $filteredMessages[] = $message;

                                        
                                    }  
                                }
                            }
                        }
                            
                             
                    }
                    foreach($accountsDisc as $key => $account){
                        DB::table('processaccounts2')
                        ->insert([
                            'process' => 0,
                            'account_number' => $account->account_number,
                            'meter_number' => $account->meter_number,
                            'account_name' => $account->account_name,
                            'status' => 'pending',
                            'created' => $currentTime
                        ]);
                    }
                    // //end send message
                

                    
                //insert to processaccounts after sending disco command
                    // foreach($accountsDisc as $key => $account){


                    //     DB::table('processaccounts2')
                    //     ->insert([
                    //         'process' => 0,
                    //         'account_number' => $account->account_number,
                    //         'meter_number' => $account->meter_number,
                    //         'account_name' => $account->account_name,
                    //         'status' => 'pending',
                    //         'created' => $currentTime
                    //     ]);
                    // }
    

                echo $smsBody . " ";
                echo $postnum . " " .  "\n";





                //daan    

                // foreach ($posts as $key => $post) {
                //         $smsBody = "$";
                //         $accountsDisc = DB::table('accounts')
                //         ->whereExists(function ($query) {
                //             $query->select(DB::raw(1))
                //                     ->from('bills')
                //                     ->whereRaw('bills.bills_account_number = accounts.account_number')
                //                     ->whereRaw('bills.disconnection_date <= CURDATE()')
                //                     ->whereRaw('bills.status = 0');
                //         })->where('accounts_posts_id',$post->id)->get();

                //         foreach($accountsDisc as $key => $account){
                //             if($account->status == 0){
                //                 $smsBody .= $account->meter_number . ",";
                //             }
                //         }
                //         $smsBody .= '%';

                //         foreach($accountsDisc as $key => $account){
                //             if($account->status == 0){
                //                 $smsBody .= $account->status . ",";
                //             }
                //         }
                        // $smsBody .= '*';
                        // echo $smsBody;
                        // echo $post->mobilenum . " ";
                        // echo "<br>";

                        
                            // $status = $itexmoo->itexmo($post->mobilenum,$smsBody,"TR-KIMHO570240_43KNQ");
                            // if ($status == ""){
                            //     echo "iTexMo: No response from server!!!
                            //     Please check the METHOD used (CURL or CURL-LESS). If you are using CURL then try CURL-LESS and vice versa.	
                            //     Please CONTACT US for help. ";	
                            // }else if ($status == 0){
                            //     echo "Message Sent!";
                            // }
                            // else{	
                            //     echo "Error Num ". $status . " was encountered!";
                            // }
                        
                    // }
    
        }

    }
            

}