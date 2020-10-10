<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisconnectedaccsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disconnectedaccs', function (Blueprint $table) {
            $table->integer('account_number')->index();
            $table->integer('meter_number');
            $table->string('account_name', 50);
            $table->timestamp('time',0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disconnectedaccs');
    }
}
