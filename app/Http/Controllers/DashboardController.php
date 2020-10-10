<?php

namespace App\Http\Controllers;

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
use App\Charts\UserChart;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        // $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU4MDU1OTc5OCwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjc3MTA4LCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.0itAev15AZH70jnynEZbqL5K0Z_YQe-Kvp1m5MZ_Ij0";

        //start send message
        // $array_fields['phone_number'] = '+639776498142';
        // $array_fields['message'] = 'Testing data';
        // $array_fields['device_id'] = 115241;

        

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
        // }
        //     //end send message

        //Start Read Messages
        //    - $searchArray = [];

        //     $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "https://smsgateway.me/api/v4/message/search",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 50,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "POST",
        //     CURLOPT_POSTFIELDS => "[  " . json_encode($searchArray) . "]",
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
        //     $messagesRaw = json_decode($response);
        //     $filteredMessages = [];
        //     // dd(date('Y-m-d H:i:s'));
        //     foreach ($messagesRaw->results as $key => $message) {
        //         if($message->status == 'received' && $message->device_id == '115242'){
        //             $filteredMessages[] = $message;
              
        //             $date = $message->created_at;
        //             $convertedDate = date("Y-m-d H:i:s", strtotime($date)); //change format
        //             $adjustedTime = date('Y-m-d H:i:s', strtotime('-5 minutes',strtotime("now"))); //subtract 5mins
                    
        //             // interval or date_diff()
        //             $diff = abs(strtotime($convertedDate) - strtotime($adjustedTime)); 
        //             $years   = floor($diff / (365*60*60*24)); 
        //             $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
        //             $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        //             $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
        //             $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
                    
        //             // $interval =  date(date_diff($convertedDate, $adjustedTime));
                    
        //             echo $convertedDate . " " . $adjustedTime;
        //             echo "<br>";
                    
        //             // adjustedTime = date_add(currentTime,' -5 mins'); // Y-m-d H:i:s
        //             // $date = sadasd
        //             // $time = wqqwdqw
        //             // convertedDateTime = $date . " " . $time;
        //             // $messageTime =date_add($convertedDateTime, '8 hours');
        //             // if($message->status == 'received' && $message->device_id == '115242' && date_diff($convertedDate, $messageTime) >=0){
        //             if($diff >= 0){
        //                 $filteredMessages[] = $message;
        //         }
        //     }
        // }
        //     dd($filteredMessages);
        // }
        
        //-End Read SMS


        
            $accounts = DB::table('accounts')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                        ->from('bills')
                        ->whereRaw('bills.bills_account_number = accounts.account_number')
                        ->whereRaw('bills.due_date <= CURDATE()')
                        ->whereRaw('bills.status = 0');
            })
            ->get();

           $accounts1 = DB::table('accounts')
           ->whereExists(function ($query) {
               $query->select(DB::raw(1))
                     ->from('bills')
                     ->whereRaw('bills.bills_account_number = accounts.account_number')
                     ->whereRaw('bills.disconnection_date <= CURDATE()')
                     ->whereRaw('bills.status = 0');
           })
           ->get();

           $notifications = DB::table('notifications')
            ->whereDate('created', today())
            ->latest('created')
            ->limit(3)
            ->get();

    // 
        $bM = DB::table('bills')
                ->select(DB::raw('bill_month,sum(energy*1)total_energy'))
                ->groupBy('bill_month')
                ->get();


        $ECCchart = new UserChart;
        $ECCchart->labels( [$bM[0]->bill_month ,  $bM[1]->bill_month ,  $bM[2]->bill_month ,  $bM[3]->bill_month  ]) ;
        $ECCchart->dataset( 'Kilowatt Hour' , 'line' , [$bM[0]->total_energy,$bM[1]->total_energy,$bM[2]->total_energy,$bM[3]->total_energy] )
                ->backgroundcolor( "rgb(255, 150, 65)",
                "rgb(255, 99, 55)")
                ->fill(false)
                ->linetension(0)
                // ->showLine(false)
                ->options([]);

        
    
        $status = DB::table('accounts')
            ->select(DB::raw('(select count(status) from accounts where status = 1)withpower,
            (select count(status) from accounts where status = 0)withoutpower'))
            ->get();

        $powerConsumption = DB::table('bills as b')
            ->select(DB::raw('a.category,sum(b.energy*1)total_energy'))
            ->join('accounts as a','a.account_number','b.bills_account_number')
            ->groupBy('a.category')
            ->get();

        
        $subscriberStatus = new UserChart;
        $subscriberStatus->labels( [ 'With Power' , 'Without Power' ]) ;
        $subscriberStatus->dataset( 'Status' , 'pie' , [$status[0]->withpower,$status[0]->withoutpower] )
                        ->backgroundColor([
                            "rgb(255, 150, 65)",
                            "rgb(255, 99, 55)"
        ]);




        $total = $powerConsumption[0]->total_energy + $powerConsumption[1]->total_energy;
        $resi = $powerConsumption[0]->total_energy/$total*100;
        $commer= $powerConsumption[1]->total_energy/$total*100;


        $consumption = new UserChart;
        $consumption->labels( [ 'Residential' , 'Commercial' ]) ;
        $consumption->dataset( 'Percentage' , 'bar' , [$resi,$commer] )
                            ->backgroundColor([
                                "rgb(255, 150, 65)",
                            "rgb(255, 99, 55)"
        ]);
        



        // $discon = DB::table('logs')
        // ->select(DB::raw('count(account_number)'))
        // ->groupBy('YEAR(disconnection_date)')
        // // ->groupBy('MONTH(disconnection_date)')
        // ->get();

        $discon = DB::table('logs') 
        ->select(DB::raw('count(account_number) as `data`'),DB::raw('YEAR(disconnection_date) year, MONTH(disconnection_date) month'))
           ->groupby('year','month')
           ->get();

        
       
       

        // SELECT COUNT(account_number) FROM `logs` group BY YEAR(disconnection_date), MONTH(disconnection_date)
        // $discon[0]->month,  $discon[1]->month, $discon[2]->month, $discon[3]->month
        
        $powercuts = new UserChart;
        $powercuts->labels( [$discon[0]->month,  $discon[1]->month, $discon[2]->month]) ;
        $powercuts->dataset( 'Users' , 'line' , [$discon[0]->data, $discon[1]->data, $discon[2]->data] )
                ->backgroundcolor("rgb(255, 150, 65)","rgb(255, 99, 55)")
                ->fill(false)
                ->linetension(0)
                // ->showLine(false)
                ->options([]);





           return view('pages.dashboard', ['accounts' => $accounts, 'accounts1' => $accounts1, 'notifications' => $notifications,
           'ECCchart' => $ECCchart, 'substatus' => $subscriberStatus, 'consumption' => $consumption, 'powercuts' => $powercuts]);
    }

    




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
