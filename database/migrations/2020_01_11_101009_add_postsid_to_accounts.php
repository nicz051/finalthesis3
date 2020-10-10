<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPostsidToAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->integer('accounts_posts_id')->unsigned()->nullable();

            $table->foreign('accounts_posts_id')->references('id')->on('posts')
            ->onUpdate('cascade');
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->integer('accounts_posts_id')->primary()->unsigned();


            $table->foreign('accounts_posts_id')->references('id')->on('posts')
            ->onUpdate('cascade');
            //
        });
    }
}

          
