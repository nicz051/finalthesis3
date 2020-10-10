<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        return view('layouts.app');
    }

    public function dashboard(){
        return view('pages.dashboard');
    }
    public function user_profile(){
        return view('pages.user_profile');
    }
    public function notifications(){
        return view('pages.notification');
    }
    public function data_table(){
        return view('pages.data_table');
    }

    public function accounts(){
        return view('pages.accounts');
    }

    public function disconnected_accounts(){
        return view('pages.disconnected_accounts');
    }
    public function billing(){
        return view('pages.billing');
    }
    public function collection(){
        return view('pages.collection');
    }
}
