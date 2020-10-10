<?php

namespace App\Http\Controllers;

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

class FunctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendReminder()
    {
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
