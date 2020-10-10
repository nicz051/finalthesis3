<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Bill;
use App\Charts\UserChart;



class UserChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $usersChart1 = new UserChart;

        $billmonth = DB::table('bills')->where('bill_month', 'SEPT 2019')->get();
        $usersChart1->labels(['SEPT 2019', 'OCT 2019', 'DEC 2019', 'MARCH 2020']);    

        $billsept = DB::table('bills')->where('bill_month', 'SEPT 2019')->get();
        $billoct = DB::table('bills')->where('bill_month', 'OCT 2019')->get();
        $billdec = DB::table('bills')->where('bill_month', 'DEC 2019')->get();
        $billmarch = DB::table('bills')->where('bill_month', 'MARCH 2020')->get();

        // list($xsept, $y) = split('[ ]', $energysept);
        // list($xoct, $y) = split('[ ]', $energyoct);
        // list($xdec, $y) = split('[ ]', $energydec);
        // list($xmarch, $y) = split('[ ]', $energymarch);

        $array=[];

        foreach($billsept as $bill){
            $energy=$bill->energy;
            list($xsept, $y) = preg_split('[ ]', $energy);
            $z=intval($xsept);
            $array[]=$z;    
        }
        $sumsept=array_sum($array);
        $avesept=$sumsept/4;

        foreach($billoct as $bill){
            $energy=$bill->energy;
            list($xoct, $y) = preg_split('[ ]', $energy);
            $z=intval($xoct);
            $array[]=$z;    
        }
        $sumoct=array_sum($array);
        $aveoct=$sumoct/4;

        foreach($billdec as $bill){
            $energy=$bill->energy;
            list($xdec, $y) = preg_split('[ ]', $energy);
            $z=intval($xdec);
            $array[]=$z;    
        }
        $sumdec=array_sum($array);
        $avedec=$sumdec/4;

        foreach($billmarch as $bill){
            $energy=$bill->energy;
            list($xmarch, $y) = preg_split('[ ]', $energy);
            $z=intval($xmarch);
            $array[]=$z;    
        }
        $summarch=array_sum($array);
        $avemarch=$summarch/4;
        



        $usersChart1->dataset('Average Energy Consumed', 'line', [$avesept, $aveoct, $avedec, $avemarch])
            ->backgroundcolor("#EB984E")
            ->color("white");       


            $borderColors = [
                "rgba(255, 99, 132, 1.0)",
                "rgba(22,160,133, 1.0)",
                "rgba(255, 205, 86, 1.0)",
                "rgba(51,105,232, 1.0)",
                "rgba(244,67,54, 1.0)",
                "rgba(34,198,246, 1.0)",
                "rgba(153, 102, 255, 1.0)",
                "rgba(255, 159, 64, 1.0)",
                "rgba(233,30,99, 1.0)",
                "rgba(205,220,57, 1.0)"
            ];
            $fillColors = [
                "rgba(255, 99, 132, 0.2)",
                "rgba(22,160,133, 0.2)",
                "rgba(255, 205, 86, 0.2)",
                "rgba(51,105,232, 0.2)",
                "rgba(244,67,54, 0.2)",
                "rgba(34,198,246, 0.2)",
                "rgba(153, 102, 255, 0.2)",
                "rgba(255, 159, 64, 0.2)",
                "rgba(233,30,99, 0.2)",
                "rgba(205,220,57, 0.2)"
    
            ];

        $usersChart2=new Userchart;
        
        $accounts=DB::table('accounts')->get();
        $accountsdis=DB::table('accounts')->where('status',0)->get();

        $usersChart2->labels([count($accounts), count($accountsdis)]);   
        $usersChart2->dataset('Disconnected Account Rate', 'doughnut', [count($accounts), count($accountsdis)]) 
            ->color($borderColors)
            ->backgroundcolor($fillColors);
        


        $usersChart3=new Userchart;
        
        $transactions=DB::table('transactions')->get();
        $usersChart3->labels(['morning', 'afternoon']);
        $half1=[];
        $half2=[];

        foreach($transactions as $transaction){
            $currentTime = date("Y-m-d H:i:s", strtotime("now")); //current time
            $messageTime = date("Y-m-d H:i:s", strtotime($transaction->date_time));

            $currentyear = date('Y', strtotime($currentTime));
            $currentmonth = date('m', strtotime($currentTime));
            $currentday = date('d', strtotime($currentTime));
            $currenthours = date('G', strtotime($currentTime));

            $messageyear = date('Y', strtotime($messageTime));
            $messagemonth = date('m', strtotime($messageTime));
            $messageday = date('d', strtotime($messageTime));
            $messagehours = date('G', strtotime($messageTime));

            if ($messageyear == $currentyear && $messagemonth == $currentmonth && $messageday == $currentday && ($messagehours>='8' || $messagehours<='12')){
                $half1[]=$transaction;
            }

            else if ($messageyear == $currentyear && $messagemonth == $currentmonth && $messageday == $currentday && ($messagehours>='12' || $messagehours<='16')){
                $half2[]=$transaction;
            }
        }

        $usersChart3->dataset('Transaction Rate', 'bar', [count($half1), count($half2)]) 
            ->color($borderColors)
            ->backgroundcolor($fillColors);
        

       


        return view('pages.userschart', [ 'usersChart1' => $usersChart1, 'usersChart2' => $usersChart2, 'usersChart3' => $usersChart3] );

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
