<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('users', function(Blueprint $table){
            $table->id();
            $table->string('username')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->text('bio');
            $table->boolean('private');
            $table->binary('profile_pic');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('user_followers', function(Blueprint $table){
            $table->id();
            $table->integer('user_id');
            $table->integer('follower_id');
            $table->timestamps();
        });

        Schema::create('blocked', function(Blueprint $table){
            $table->id();
            $table->integer('user_id');
            $table->integer('blocked_user_id');
            $table->timestamps();
        });

        Schema::create('follow_request', function(Blueprint $table){
            $table->id();
            $table->integer('user_id');
            $table->integer('follower_id')->unique();
            $table->boolean('status');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('users');
    }
}
