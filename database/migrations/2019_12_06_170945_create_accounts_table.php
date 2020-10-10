<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->integer('meter_number')->primary()->unsigned();
            $table->integer('account_number');
            $table->string('account_name', 50);
            $table->string('address', 50);
            $table->string('type', 20);
            $table->integer('accounts_transaction_id')->unsigned()->nullable();
            $table->double('credit_balance',10, 2);
            $table->string('contact_number', 11);
            $table->timestamps();

            // $table->foreign('accounts_transaction_id')->references('transaction_id')->on('transactions')
            // ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
