<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessaccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processaccounts', function (Blueprint $table) {
            $table->boolean('process');
            $table->integer('account_number')->index();
            $table->integer('meter_number');
            $table->string('account_name', 50);
            $table->enum('status', ['pending', 'success', 'fail']);
            $table->timestamps();
            $table->temporary();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processaccounts');
    }
}
