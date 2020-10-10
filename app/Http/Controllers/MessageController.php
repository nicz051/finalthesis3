<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(){

        $messages = \App\Account::all();
        return view('pages.notification',compact('message'));


    }
}
