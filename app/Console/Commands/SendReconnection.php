<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\itexmoo;
use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\Model\SendMessageRequest;
use Carbon\Carbon;
use App\DateTime;
use App\functions;

class SendReconnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendreconnection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send reconnection command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU4MzY2NDY3NSwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjc3ODg5LCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.h_B-LUEd5-XwsMThdLwTKNDyRSb7-fqqKEwbwi21f1w";
        
        $currentTime = date("Y-m-d H:i:s", strtotime("now")); //current time
        $currentyear = date('Y', strtotime($currentTime));
        $currentmonth = date('m', strtotime($currentTime));
        $currentday = date('d', strtotime($currentTime));
        $currenthours = date('G', strtotime($currentTime));
        $currentminutes = date('i', strtotime($currentTime));

        $transactions = DB::table('transactions')->get();

        foreach($transactions as $key => $transaction){

            $year = date('Y', strtotime($transaction->date_time));
            $month = date('m', strtotime($transaction->date_time));
            $day = date('d', strtotime($transaction->date_time));
            $hours = date('G', strtotime($transaction->date_time));
            $minutes = date('i', strtotime($transaction->date_time));
        

            if ($year == $currentyear && $month == $currentmonth && $day == $currentday && $hours == $currenthours && $minutes == $currentminutes){
                echo $transaction->transaction_id . "\n";
                echo $transaction->date_time . "\n";
                echo $currentTime . "\n";

                $bills = DB::table('bills')
                    ->where('bills.bill_id', $transaction->transactions_bill_id)
                    ->where('bills.status', 1)->get();

                    foreach($bills as $bill){
                        echo $bill->bill_id . "\n";


                        $disconnectedaccounts = DB::table('disconnectedaccounts')
                                ->where('disconnectedaccounts.account_number', $bill->bills_account_number)->get();

                            foreach($disconnectedaccounts as $disconnectedaccount){

                                $accounts = DB::table('accounts')
                                        ->where('accounts.account_number', $disconnectedaccount->account_number)->get();


                                        foreach($accounts as $account){
                                            echo $account->account_name . "\n";

                                            $smsBody = "$" . $account->meter_number . "," . '%' . 1 . "," . '*';

                                            $posts = DB::table('posts')
                                                ->where('posts.id', $account->accounts_posts_id)->get();
                                                
                                                foreach($posts as $post){
                                                    $postnum = $post->mobilenum;
                                                    // echo $post->id;
                                                }
                                            
                                            echo $smsBody;
                                            echo $postnum . " " .  "\n";
                                            

                                            //send command via gsm

                                            exec("mode COM1 BAUD=115200 PARITY=N data=8 stop=1 xon=off");
    
                                            $fp = fopen ("COM1", "w+");
                                            if ( !$fp ){
                                                return "Not open";
                                            }else {
                                                fwrite( $fp, "AT\n\r" );
                                                usleep( 500000 );
                                                fwrite( $fp, "AT+CMFG=1\n\r" );
                                                usleep( 500000 );
                                                fwrite( $fp, "AT+CMGS=$postnum \n\r" );
                                                usleep( 500000 );
                                                fwrite( $fp, "$smsBody\n\r" );
                                                usleep( 500000 );
                                                fwrite( $fp, chr(26) );
                                                usleep( 7000000 );
                                                fclose( $fp );
                                                // $message=fread($fp,1);
                                                // fclose($fp);
                                                return 'open';
                                            }


                                            // //start send message
                                            // $array_fields['phone_number'] = $post->mobilenum;
                                            // $array_fields['message'] = $smsBody;
                                            // $array_fields['device_id'] = 115988;
                                            

                                            // $curl = curl_init();

                                            // curl_setopt_array($curl, array(
                                            //     CURLOPT_URL => "https://smsgateway.me/api/v4/message/send",
                                            //     CURLOPT_RETURNTRANSFER => true,
                                            //     CURLOPT_ENCODING => "",
                                            //     CURLOPT_MAXREDIRS => 10,
                                            //     CURLOPT_TIMEOUT => 50,
                                            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                            //     CURLOPT_CUSTOMREQUEST => "POST",
                                            //     CURLOPT_POSTFIELDS => "[  " . json_encode($array_fields) . "]",
                                            //     CURLOPT_HTTPHEADER => array(
                                            //         "authorization: $token",
                                            //         "cache-control: no-cache"
                                            //     ),
                                            // ));
                                            // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                                            // $response = curl_exec($curl);
                                            // $err = curl_error($curl);

                                            // curl_close($curl);

                                            
                                            // if ($err) {
                                            //     dd($err);
                                            // } else {
                                            //         // dd($response);

                                            //         //Start Read Messages
                                            //         $searchArray = [];
                                            //         $filteredMessages = [];
                                            //         while(sizeof($filteredMessages) == 0){
                                            //             $curl = curl_init();
                                            //             $filteredMessages = [];
                                            //             curl_setopt_array($curl, array(
                                            //                 CURLOPT_URL => "https://smsgateway.me/api/v4/message/search",
                                            //                 CURLOPT_RETURNTRANSFER => true,
                                            //                 CURLOPT_ENCODING => "",
                                            //                 CURLOPT_MAXREDIRS => 10,
                                            //                 CURLOPT_TIMEOUT => 50,
                                            //                 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                            //                 CURLOPT_CUSTOMREQUEST => "POST",
                                            //                 CURLOPT_POSTFIELDS => "[  " . json_encode($searchArray) . "]",
                                            //                 CURLOPT_HTTPHEADER => array(
                                            //                     "authorization: $token",
                                            //                     "cache-control: no-cache"
                                            //                 ),
                                            //             ));
                                            //             curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                                                
                                            //             $response = curl_exec($curl);
                                            //             $err = curl_error($curl);
                                                
                                            //             curl_close($curl);
                                                
                                            //             if ($err) {
                                            //                 dd($err);
                                            //             } else {    
                                            //                 $messagesRaw = json_decode($response);
                                            //                 $filteredMessages = [];   
                                            
                                            //                 foreach ($messagesRaw->results as $key => $message) {
                                                                                
                                            //                     $currentTime = date("Y-m-d H:i:s", strtotime("now")); //current time
                                            //                     $adjustedTime = date('Y-m-d H:i:s', strtotime('-5 minutes',strtotime("now"))); //subtract 5mins from current time
                                            //                     $messageTime = date("Y-m-d H:i:s", strtotime($message->created_at));
                                                                    
                                            //                     if($message->status == 'sent' && $message->device_id == '115988' && $message->message == $smsBody && $messageTime >= $adjustedTime && $messageTime <= $currentTime){
                                            //                         $filteredMessages[] = $message;

                                                                    
                                            //                     }  
                                            //                 }
                                            //             }
                                            //         }
                                            // }
                                            // //end send message
                                        

                                            
                                         //insert to processaccounts after sending disco command
                                        
                                            // DB::table('processaccounts2')
                                            // ->insert([
                                            //     'process' => 1,
                                            //     'account_number' => $account->account_number,
                                            //     'meter_number' => $account->meter_number,
                                            //     'account_name' => $account->account_name,
                                            //     'status' => 'pending',
                                            //     'created'  => $currentTime
                                            // ]);
                                        
                                            
                                            // // echo $smsBody . " ";
                                            
                                        
                                
                            

                                // $posts = DB::table('posts')->get();

                                // foreach ($posts as $key => $post) {
                                //     $smsBody = "$";
                                //     $accountsDisc = DB::table('accounts')
                                //             ->where('accounts.account_number',$disconnectedaccount->account_number)
                                //             ->where('accounts_posts_id',$post->id)->get();



                                //     foreach($accountsDisc as $key => $account){
                                //         // if($account->status == 0){
                                //             $smsBody .= $account->meter_number . ",";
                                //         // }
                                //     }
                                //     $smsBody .= '%';

                                //     foreach($accountsDisc as $key => $account){
                                //         // if($account->status == 0){
                                //             $smsBody .= 0 . ",";
                                //         // }
                                //     }
                                //     $smsBody .= '*';

                                //     $postnum = $post->mobilenum;
                                //     echo $smsBody;
                                //     echo $postnum . " " .  "\n";
                                // }
                                        

                                        }
                           
                            }
                    }
            }
        
            else{
            echo "no transaction found \n";
            }
            
        
            
        }
               

    }

    


}