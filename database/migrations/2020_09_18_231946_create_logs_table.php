<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {

            $table->integer('account_number');
            $table->string('account_name');
            $table->dateTime('disconnection_date');
            $table->dateTime('reconnection_date');
            $table->timestamps();

            $table->index(['account_number','disconnection_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disconnectionlogs');
    }
}
