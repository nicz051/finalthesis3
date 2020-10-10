<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->integer('transaction_id')->primary()->unsigned();
            $table->timestamp('date_time');
            $table->bigInteger('transactions_bill_id')->unique()->unsigned()->nullable();
            $table->double('amount_paid', 10, 2);
            $table->double('credit_balance', 10, 2);
            $table->timestamps();

            // $table->foreign('transactions_bill_id')->references('bill_id')->on('bills')
            //  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
