<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->bigInteger('bill_id')->primary()->unsigned();
            $table->integer('bills_meter_number')->unsigned()->nullable();
            $table->string('bill_month', 30);
            $table->date('bill_period_start');
            $table->date('bill_period_end');
            $table->string('previous_reading', 20);
            $table->string('current_reading', 20);
            $table->string('energy', 20);
            $table->date('bill_date');
            $table->date('due_date');
            $table->double('bill_amount', 10, 2);
            $table->date('disconnection_date');
            $table->boolean('status');
            $table->integer('bills_transaction_id')->unique()->unsigned()->nullable();
            $table->timestamps();

            //  $table->foreign('bills_meter_number')->references('meter_number')->on('accounts')
            //  ->onUpdate('cascade');
            //  $table->foreign('bills_transaction_id')->references('transaction_id')->on('transactions')
            //  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
