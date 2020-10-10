<?php
use App\Account;
use App\Bill;
use Illuminate\Support\Facades\Input;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', 'PagesController@index');

Route::view('/', 'auth.login');
Route::get('/dashboard', 'DashboardController@index');
Route::get('/user_profile', 'PagesController@user_profile');
Route::any ( '/search', function(){
    $q = Request::get ( 'q' );
    $user = Account::where('account_number','LIKE','%'.$q.'%')->orWhere('account_name','LIKE','%'.$q.'%')->get();
    // $bill = Bill::where('bills_account_number', 'LIKE','%'.$q.'%')->get();
    $bill = DB::table('bills')
            ->where('bills_account_number', $q)
            ->get();

    $transaction = DB::table('transactions')
            // ->whereExists(function ($query) {
            //     $query->select(DB::raw(1))
            //             ->from('bills')
            //             ->whereRaw('transactions.transactions_bill_id = bills.bill_id');
            // })
            ->join('bills', 'transactions.transactions_bill_id', 'bills.bill_id')
            ->where('bills.bills_account_number',$q)
            ->get();
            
    
    if(count($user) > 0)
        return view('pages.searchresults', ['bill' => $bill, 'transaction' => $transaction])->withDetails($user)->withQuery ( $q );
    else return view ('pages.searchresults')->withMessage('No Details found. Try to search again !');
});

Route::get('/data_table/accounts', 'AccountController@index');
Route::get('/data_table/disconnected_accounts', 'DisconnectedAccountController@index');
Route::get('/data_table/billing', 'BillController@index');
Route::get('/data_table/collection', 'TransactionController@index');



// Route::get('/SendReminder', 'ReminderController@Send');
// Route::get('/SendDisconnection', 'SendDisconnectionController@Send');
// Route::get('/userschart', 'UserChartController@index');


// Route::get('/home', 'HomeController@index')->name('home');

Auth::routes(['register' => false]);



// Route::get('/dashboard', 'DashboardController@index')->middleware('auth');
// Route::get('/user_profile', 'PagesController@user_profile')->middleware('auth');
// Route::get('/data_table/accounts', 'AccountController@index')->middleware('auth');
// Route::get('/data_table/disconnected_accounts', 'DisconnectedAccountController@index')->middleware('auth');
// Route::get('/data_table/billing', 'BillController@index')->middleware('auth');
// Route::get('/data_table/collection', 'TransactionController@index')->middleware('auth');

Route::group(['middleware' => ['auth:web']], function(){
    Route::group(['middleware' => ['admin']],function(){
        Route::get('/dashboard', 'DashboardController@index');
        Route::get('/user_profile', 'PagesController@user_profile');
        Route::get('/data_table/accounts', 'AccountController@index');
        Route::get('/data_table/disconnected_accounts', 'DisconnectedAccountController@index');
        Route::get('/data_table/billing', 'BillController@index');
        Route::get('/data_table/collection', 'TransactionController@index');
    });
    // Route::get('/dashboard', 'DashboardController@index');
    // Route::get('/data_table/accounts', 'AccountController@index');
    // Route::get('/data_table/disconnected_accounts', 'DisconnectedAccountController@index');
    // Route::get('/data_table/billing', 'BillController@index');
    // Route::get('/data_table/collection', 'TransactionController@index');

});