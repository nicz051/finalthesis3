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



class CheckIncomingMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkincomingmessages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks incoming messages, notifies and updates tables';

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
        $datetime = new DateTime();
        $deviceid = 115988;
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
                   
                if($message->status == 'received' && $message->device_id == '115988' && $messageTime >= $adjustedTime && $messageTime <= $currentTime){
                    $filteredMessages[] = $message;
                }  
            }


        // // dd($filteredMessages);
        foreach ($filteredMessages as $key => $message){ // 
            $currentTime = date("Y-m-d H:i:s", strtotime("now")); //current time
            $messageTime = date("Y-m-d H:i:s", strtotime($message->created_at));
            $currentyear = date('Y', strtotime($currentTime));
            $currentmonth = date('m', strtotime($currentTime));
            $currentday = date('d', strtotime($currentTime));
            $currenthours = date('G', strtotime($currentTime));
            $currentminutes = date('i', strtotime($currentTime));
            $messageyear = date('Y', strtotime($messageTime));
            $messagemonth = date('m', strtotime($messageTime));
            $messageday = date('d', strtotime($messageTime)); 
            $messagehours = date('G', strtotime($messageTime));
            $messageminutes = date('i', strtotime($messageTime));
            echo $currentTime . "\n";
            echo $messageTime . "\n";

            if($currentyear == $messageyear && $currentmonth == $messagemonth && $currentday == $messageday && $currenthours == $messagehours && ($currentminutes<=$messageminutes || $messageminutes>=$currentminutes)){
                // $filteredMessages[] = $message;

                $currentTime = date("Y-m-d H:i:s", strtotime("now")); //current time
                $messageTime = date("Y-m-d H:i:s", strtotime($message->created_at));

                $content = $message->message;
                $stringcontent = str_replace(PHP_EOL, '', $content);
                echo $stringcontent."\n";
                echo $content."\n";
                echo strlen($stringcontent)."\n";
                echo strlen($content)."\n";
                echo "Right Message\n";

                // if ($message->phone_number == "+639278893743"){
                if (strlen($stringcontent) == 16){

                    //split string
                    $meternum1 = $function->splitmeternum1($content);
                    $status1 = $function->splitstat1($content);
                    $meternum2 = $function->splitmeternum2($content);
                    $status2 = $function->splitstat2($content);
                    $meternum3 = $function->splitmeternum3($content);
                    $status3 = $function->splitstat3($content);
                    $variables = array($meternum1=>$status1, $meternum2=>$status2, $meternum3=>$status3);

                    foreach ($variables as $meternum=>$status){                    

                            echo $meternum . " " . " " . $status;
                            echo "<br>";

                            $accounts = DB::table('accounts')
                            ->where('meter_number', $meternum)
                            ->first();
                            
                            DB::table('notifications')
                            ->insert([
                                'id' => $message->id,
                                'phone_number' => $message->phone_number,
                                'message' => $message->message,
                                'accountnum' =>$accounts->account_number,
                                'meternum' => $meternum,
                                'status' => $status,
                                'created' => $messageTime
                            ]);
                        

                            //prepare smsbody
                            if ($status == "1"){
                                $smsbody = $function->smsReconnect($meternum, $messageTime);
                            }else if ($status == "0"){
                                $smsbody = $function->smsDisconnect($meternum, $messageTime);
                            }
                            echo $smsbody . "<br>";

                            //send notif
                            $function->sendnotif($smsbody, $meternum);

                            //update tables-delete row from processaccounts
                            $function->deletefromProcessAcc($meternum);

                            //update status from accounts and add row to reconnected acc
                            if ($status == "1"){
                                $function->updatestatusOne($meternum);
                                $function->addReconnectedT($meternum, $currentTime);
                                $function->deletefromDisconnectedAcc($meternum, $messageTime);
                            }else if ($status == "0"){
                                $function->updatestatusZero($meternum);
                                $function->addDisconnectedT($meternum, $currentTime);
                            }
                    }

                }else if (strlen($stringcontent) == 12){
                    //split string
                    $meternum1 = $function->splitmeternumfirst($content);
                    $status1 = $function->splitstatfirst($content);
                    $meternum2 = $function->splitmeternumsecond($content);
                    $status2 = $function->splitstatsecond($content);
                    $variables = array($meternum1=>$status1, $meternum2=>$status2);


                    foreach ($variables as $meternum=>$status){                    

                        echo $meternum . " " . " " . $status;
                        echo "<br>";

                        $accounts = DB::table('accounts')
                        ->where('meter_number', $meternum)
                        ->first();
                        
                        DB::table('notifications')
                        ->insert([
                            'id' => $message->id,
                            'phone_number' => $message->phone_number,
                            'message' => $message->message,
                            'accountnum' =>$accounts->account_number,
                            'meternum' => $meternum,
                            'status' => $status,
                            'created' => $messageTime
                        ]);

                        //prepare smsbody
                        if ($status == "1"){
                            $smsbody = $function->smsReconnect($meternum, $messageTime);
                        }else if ($status == "0"){
                            $smsbody = $function->smsDisconnect($meternum, $messageTime);
                        }
                        echo $smsbody;

                        //send notif
                        $function->sendnotif($smsbody, $meternum);

                        //update tables-delete row from processaccounts
                        $function->deletefromProcessAcc($meternum);

                        //update status from accounts and add row to reconnected acc
                        if ($status == "1"){
                            $function->updatestatusOne($meternum);
                            $function->addReconnectedT($meternum, $currentTime);
                            $function->deletefromDisconnectedAcc($meternum, $messageTime);
                        }else if ($status == "0"){
                            $function->updatestatusZero($meternum);
                            $function->addDisconnectedT($meternum, $currentTime);
                        }
                    }

                }else if (strlen($stringcontent) == 8){

                    //split string
                    $meternum = $function->splitmeternum($content);
                    $status = $function->splitstatus($content);
                    echo $meternum . " " . " " . $status;
                    echo "<br>";

                    $accounts = DB::table('accounts')
                    ->where('meter_number', $meternum)
                    ->first();
                    
                    DB::table('notifications')
                    ->insert([
                        'id' => $message->id,
                        'phone_number' => $message->phone_number,
                        'message' => $message->message,
                        'accountnum' =>$accounts->account_number,
                        'meternum' => $meternum,
                        'status' => $status,
                        'created' => $messageTime
                    ]); 

                    //prepare smsbody
                    if ($status == "1"){
                        $smsbody = $function->smsReconnect($meternum, $messageTime);
                    }else if ($status == "0"){
                        $smsbody = $function->smsDisconnect($meternum, $messageTime);
                    }
                    echo $smsbody;

                    //send notif
                    $function->sendnotif($smsbody, $meternum);

                    //update tables-delete row from processaccounts
                    $function->deletefromProcessAcc($meternum);

                    //update status from accounts and add row to reconnected acc
                    if ($status == "1"){
                        $function->updatestatusOne($meternum);
                        $function->addReconnectedT($meternum, $currentTime);
                        $function->deletefromDisconnectedAcc($meternum, $messageTime);
                    }else if ($status == "0"){
                        $function->updatestatusZero($meternum);
                        $function->addDisconnectedT($meternum, $currentTime);
                    }
                }
                else{
                    echo "invalid format\n"."-----------------------------------------\n";
                }
            }
            else{
                echo "no message received\n"."----------------------------------------\n";
            }
        }
        }
            //End Read SMS
    }
}
