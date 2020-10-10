<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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

class ForTesting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:fortesting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        // $itexmoo=new itexmoo();
        // $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU4MzY2NDY3NSwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjc3ODg5LCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.h_B-LUEd5-XwsMThdLwTKNDyRSb7-fqqKEwbwi21f1w";
        // $datetime = new DateTime();
        // $deviceid = 115988;
        // $function = new functions();
        // $currentTime = date("Y-m-d H:i:s", strtotime("now")); //current time
        // $messageTime = date("Y-m-d H:i:s", strtotime("2020-02-20 09:09:07"));

        // echo $year = date('Y', strtotime($currentTime)) . "<br>";
        // echo $month = date('m', strtotime($currentTime)) . "<br>";
        // echo $day = date('d', strtotime($currentTime)) . "<br>";
        // echo $hours = date('G', strtotime($currentTime)) . "<br>";
        // echo $minutes = date('i', strtotime($currentTime));
        

        exec("mode COM1 BAUD=115200 PARITY=N data=8 stop=1 xon=off");
    
        $fp = fopen ("COM1", "w+");
        if ( !$fp ){
            return "Not open";
        }else {
            fwrite( $fp, "AT\n\r" );
            usleep( 500000 );
            fwrite( $fp, "AT+CMFG=1\n\r" );
            usleep( 500000 );
            fwrite( $fp, "AT+CMGS=09987653629\n\r" );
            usleep( 500000 );
            fwrite( $fp, "hi\n\r" );
            usleep( 500000 );
            fwrite( $fp, chr(26) );
            usleep( 7000000 );
            fclose( $fp );
            // $message=fread($fp,1);
            // fclose($fp);
        return 'open';







        // send through itexmo
        //     $status = $itexmoo->itexmo("09987653629","$1,2,3,%1,1,1,*","TR-KIMHO570240_43KNQ");
        //     if ($status == ""){
        //     echo "iTexMo: No response from server!!!
        //     Please check the METHOD used (CURL or CURL-LESS). If you are using CURL then try CURL-LESS and vice versa.	
        //     Please CONTACT US for help. ";	
        //     }else if ($status == 0){
        //     echo "Message Sent!";
        //     }
        //     else{	
        //     echo "Error Num ". $status . " was encountered!";
        //     }



        // // start send message through sms gateway 09509966988
        //     $array_fields['phone_number'] = '09083906258';
        //     $array_fields['message'] = '$1,2,3,%1,1,1,*';
        //     $array_fields['device_id'] = 115988;
            

        //     $curl = curl_init();

        //     curl_setopt_array($curl, array(
        //         CURLOPT_URL => "https://smsgateway.me/api/v4/message/send",
        //         CURLOPT_RETURNTRANSFER => true,
        //         CURLOPT_ENCODING => "",
        //         CURLOPT_MAXREDIRS => 10,
        //         CURLOPT_TIMEOUT => 50,
        //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //         CURLOPT_CUSTOMREQUEST => "POST",
        //         CURLOPT_POSTFIELDS => "[  " . json_encode($array_fields) . "]",
        //         CURLOPT_HTTPHEADER => array(
        //             "authorization: $token",
        //             "cache-control: no-cache"
        //         ),
        //     ));
        //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        //     $response = curl_exec($curl);
        //     $err = curl_error($curl);

        //     curl_close($curl);

            
        //     if ($err) {
        //         dd($err);
        //     } else {
        //             // dd($response);
        //    }
            //end send message
        



        //update table
            // DB::table('disconnectedaccounts')
            // ->where('meter_number', '=', '4')
            // ->update(['posts_id' => '2']);


        //add into disconnected accounts table
        //    $function->addDisconnectedT("4", $currentTime);

        //add into reconnected accounts table
            // $function->addReconnectedT("1", $currentTime);

        //add into processed acc
            // DB::table('processaccounts2')
            // ->insert([
            //     'process' => 0,
            //     'account_number' => '1396015',
            //     'meter_number' => '4',
            //     'account_name' => 'Cim, Bern',
            //     'status' => 'pending',
            //     'created' => $currentTime
            // ]);

        //empty a table
            //  DB::table('processaccounts2')->truncate();
            
            // DB::table('reconnectedaccounts')->truncate();
            //   DB::table('disconnectedaccounts')->truncate();
            // DB::table('notifications')->truncate();



        //when receive a confirmation
        //       $deviceid = 115241;
        //       $currentTime = date("Y-m-d H:i:s", strtotime("now")); //current time
        //       $function = new functions();

                    
            //    $content = "$5,%1,*****";
                    
            // //split string
            //     $meternum = $function->splitmeternum($content);
            //     $status = $function->splitstatus($content);
            //     echo $meternum . " " . $status;

            //prepare smsbody
                // if ($status = 1){
                //     $smsbody = $function->smsReconnect($meternum, $currentTime);
                // }else if ($status = 0){
                //     $smsbody = $function->smsDisconnect($meternum, $currentTime);
                // }
                // echo $smsbody;

            //send notif
                // $function->sendnotif($smsbody, $meternum);

            //update tables-delete row from processaccounts
                // $function->deletefromProcessAcc($meternum);

            //update status from accounts and add row to reconnected acc
                // if ($status = 1){
                //     $function->updatestatusOne($meternum);
                //     $function->addReconnectedT($meternum, $currentTime);
                // }else if ($status = 0){
                //     $function->updatestatusZero($meternum);
                // }








    //     //Start Read Messages
    //         $searchArray = [];

    //         $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => "https://smsgateway.me/api/v4/message/search",
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 50,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "POST",
    //         CURLOPT_POSTFIELDS => "[  " . json_encode($searchArray) . "]",
    //         CURLOPT_HTTPHEADER => array(
    //             "authorization: $token",
    //             "cache-control: no-cache"
    //         ),
    //     ));
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    //     $response = curl_exec($curl);
    //     $err = curl_error($curl);

    //     curl_close($curl);

    //    if ($err) {
    //         dd($err);
    //     } else {    
    //         $messagesRaw = json_decode($response);
    //         $filteredMessages = [];
                   


    //         foreach ($messagesRaw->results as $key => $message) {
                            
    //             $currentTime = date("Y-m-d H:i:s", strtotime("now")); //current time
    //             $adjustedTime = date('Y-m-d H:i:s', strtotime('-5 minutes',strtotime("now"))); //subtract 5mins from current time
    //             $messageTime = date("Y-m-d H:i:s", strtotime($message->created_at));
    //             $maxTime = date('Y-m-d H:i:s', strtotime('+5 minutes',strtotime("$messageTime"))); //add 5mins from message time
                    
    //             if($message->status == 'received' && $message->device_id == '115242'){
    //                 $filteredMessages[] = $message;
    //             }

    //             foreach ($messagesRaw->results as $key => $message) {
    //                 DB::table('messages')
    //                 ->insert([
    //                     'id' => $message->id,
    //                     'phone_number' => $message->phone_number,
    //                     'message' => $message->message,
    //                     'meternum' => '0',
    //                     'status' => '0',
    //                     'created' => $message->created_at
    //                 ]);

    //                 $content = $message->$message;
    //                 //split string
    //                 $meternum = $function->splitmeternum($content);
    //                 $status = $function->splitstatus($content);
                    
    //                 DB::table('messages')
    //                 ->update(['meternum' => $meternum],
    //                  ['status' => $status]);
                    
    //             } 
    //         }

    //         $accounts = DB::table('processaccounts2')
    //         ->where('status', '=', 'pending')
    //         ->count();


    //         foreach ($accounts as $account){
    //             $message = DB::table('messages')
    //             ->where('meternum', '=', $account->meter_number)
    //             ->whereBetween('created', [$messageTime, $maxTime])
    //             ->count();

    //             if ($message = 0){
    //                 $smsBody .= $account->meter_number . ",";
    //                 $smsBody .= '%';
    //                 $smsBody .= $account->process . ",";
    //                 $smsBody .= '*';

    //                 $post = DB::table('posts')->where('posts.id', '=', $account->meter_number)
    //                 ->get();

    //                 echo $smsBody . " " . $post->mobilenum;

                    

                    //split message functions testing

                    // $content = "$1,2,3,%1,0,1,*";
                    // $meternum1 = $function->splitmeternum1($content);
                    // $status1 = $function->splitstat1($content);
                    // $meternum2 = $function->splitmeternum2($content);
                    // $status2 = $function->splitstat2($content);
                    // $meternum3 = $function->splitmeternum3($content);
                    // $status3 = $function->splitstat3($content);
                    // echo $meternum1 . " " . $status1 . "\n";
                    // echo $meternum2 . " " . $status2 . "\n";
                    // echo $meternum3 . " " . $status3 . "\n";

    //             }
    //         }


    


               






                //every minute check incoming message
            
    //         $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU4MDU1OTc5OCwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjc3MTA4LCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.0itAev15AZH70jnynEZbqL5K0Z_YQe-Kvp1m5MZ_Ij0";
    //         $datetime = new DateTime();
    //         $deviceid = 115242;
    //         $function = new functions();
    
    
    //         //Start Read Messages
    //             $searchArray = [];
    
    //             $curl = curl_init();
    
    //         curl_setopt_array($curl, array(
    //             CURLOPT_URL => "https://smsgateway.me/api/v4/message/search",
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING => "",
    //             CURLOPT_MAXREDIRS => 10,
    //             CURLOPT_TIMEOUT => 50,
    //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST => "POST",
    //             CURLOPT_POSTFIELDS => "[  " . json_encode($searchArray) . "]",
    //             CURLOPT_HTTPHEADER => array(
    //                 "authorization: $token",
    //                 "cache-control: no-cache"
    //             ),
    //         ));
    //         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
    //         $response = curl_exec($curl);
    //         $err = curl_error($curl);
    
    //         curl_close($curl);
    
    //         if ($err) {
    //             dd($err);
    //         } else {    
    //             $messagesRaw = json_decode($response);
    //             $filteredMessages = [];
                        
    
    //             // dd(date('Y-m-d H:i:s'));
    //             foreach ($messagesRaw->results as $key => $message) {
                                    
    //                 $currentTime = date("Y-m-d H:i:s", strtotime("now")); //current time
    //                 $adjustedTime = date('Y-m-d H:i:s', strtotime('-5 minutes',strtotime("now"))); //subtract 5mins from current time
    //                 $messageTime = date("Y-m-d H:i:s", strtotime($message->created_at));
                        
    //                 if($message->status == 'received' && $message->device_id == '115242' && $messageTime >= $adjustedTime && $messageTime <= $currentTime){
    //                     $filteredMessages[] = $message;
    //                 }  
    //             }
    
    //         // // dd($filteredMessages);
    //         foreach ($filteredMessages as $key => $message){ // 
    //             $currentTime = date("Y-m-d H:i:s", strtotime("now")); //current time
    //             $messageTime = date("Y-m-d H:i:s", strtotime($message->created_at));
    //             $currentyear = date('Y', strtotime($currentTime)) . "<br>";
    //             $currentmonth = date('m', strtotime($currentTime)) . "<br>";
    //             $currentday = date('d', strtotime($currentTime)) . "<br>";
    //             $currenthours = date('G', strtotime($currentTime)) . "<br>";
    //             $currentminutes = date('i', strtotime($currentTime));
    //             $messageyear = date('Y', strtotime($messageTime)) . "<br>";
    //             $messagemonth = date('m', strtotime($messageTime)) . "<br>";
    //             $messageday = date('d', strtotime($messageTime)) . "<br>";
    //             $messagehours = date('G', strtotime($messageTime)) . "<br>";
    //             $messageminutes = date('i', strtotime($messageTime));
    
    //             if($currentyear == $messageyear && $currentmonth == $messagemonth && $currentday == $messageday && $currenthours == $messagehours && $currentminutes == $messageminutes){
    //                 $filteredMessages[] = $message;
    //         //     }
    //         // }
    
    //         // foreach ($filteredMessages as $message){ //
    //             $currentTime = date("Y-m-d H:i:s", strtotime("now")); //current time
    //             $messageTime = date("Y-m-d H:i:s", strtotime($message->created_at));
    
    //             $content = $message->message;
    
                
    //             if ($message->phone_number == "+639278893743"){
    //                 //split string
    //                 $meternum1 = $function->splitmeternum1($content);
    //                 $status1 = $function->splitstat1($content);
    //                 $meternum2 = $function->splitmeternum2($content);
    //                 $status2 = $function->splitstat2($content);
    //                 $meternum3 = $function->splitmeternum3($content);
    //                 $status3 = $function->splitstat3($content);
    //                 $variables = array($meternum1=>$status1, $meternum2=>$status2, $meternum3=>$status3);
    
    //                 foreach ($variables as $meternum=>$status){          
    //                 if($meternum != "x" && $status != "x"){          
    
    //                         echo $meternum . " " . " " . $status;
    //                         echo "<br>";
    
    //                         //prepare smsbody
    //                         if ($status == "1"){
    //                             $smsbody = $function->smsReconnect($meternum, $messageTime);
    //                         }else if ($status == "0"){
    //                             $smsbody = $function->smsDisconnect($meternum, $messageTime);
    //                         }
    //                         echo $smsbody;
    
    //                         // //send notif
    //                         // // $function->sendnotif($smsbody, $meternum);
    
    //                         // //update tables-delete row from processaccounts
    //                         // $function->deletefromProcessAcc($meternum);
    
    //                         // //update status from accounts and add row to reconnected acc
    //                         // if ($status == "1"){
    //                         //     $function->updatestatusOne($meternum);
    //                         //     $function->addReconnectedT($meternum, $currentTime);
    //                         //     $function->deletefromDisconnectedAcc($meternum);
    //                         // }else if ($status == "0"){
    //                         //     $function->updatestatusZero($meternum);
    //                         //     $function->addDisconnectedT($meternum, $currentTime);
    //                         // }
    //                     }
    //                 }
    
    
    //             }
    //             else{
    //                 //split string
    //                 $meternum = $function->splitmeternum($content);
    //                 $status = $function->splitstatus($content);
    //                 echo $meternum . " " . " " . $status;
    //                 echo "<br>";
    
    //                 //prepare smsbody
    //                 if ($status == "1"){
    //                     $smsbody = $function->smsReconnect($meternum, $messageTime);
    //                 }else if ($status == "0"){
    //                     $smsbody = $function->smsDisconnect($meternum, $messageTime);
    //                 }
    //                 echo $smsbody;
    
    //                 //send notif
    //                 // $function->sendnotif($smsbody, $meternum);
    
    //                 // //update tables-delete row from processaccounts
    //                 // $function->deletefromProcessAcc($meternum);
    
    //                 // //update status from accounts and add row to reconnected acc
    //                 // if ($status == "1"){
    //                 //     $function->updatestatusOne($meternum);
    //                 //     $function->addReconnectedT($meternum, $currentTime);
    //                 //     $function->deletefromDisconnectedAcc($meternum);
    //                 // }else if ($status == "0"){
    //                 //     $function->updatestatusZero($meternum);
    //                 //     $function->addDisconnectedT($meternum, $currentTime);
    //                 // }
    
                
    //         }
    //     }
    // }
        
    //     }
    //             //End Read SMS

                    
                

                   
              
                        

                

                    

       
        

    }
    
}
}
