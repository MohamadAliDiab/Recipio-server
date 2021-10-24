<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('ingredients');
            $table->text('method');
            $table->integer('serves');
            $table->time('prep');
            $table->time('cook');
            $table->integer('media');
            $table->integer('nb_of_likes');
            $table->integer('nb_of_comments');
            $table->integer('posted_by');
            $table->time('time_created');
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->timestamps();
        });

        Schema::create('recipe_has_tags', function (Blueprint $table) {
            $table->id();
            $table->integer('recipe_id');
            $table->integer('tag_id');
            $table->timestamps();
        });

        Schema::create('recipe_has_likes', function (Blueprint $table) {
            $table->id();
            $table->integer('recipe_id');
            $table->integer('user_id');
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->integer('nb_of_likes');
            $table->integer('nb_of_replies');
            $table->integer('posted_by');
            $table->timestamps();
        });

        Schema::create('recipe_has_comment', function (Blueprint $table) {
            $table->id();
            $table->integer('recipe_id');
            $table->integer('comment_id');
            $table->timestamps();
        });

        Schema::create('comment_has_likes', function (Blueprint $table) {
            $table->id();
            $table->integer('comment_id');
            $table->integer('user_id');
            $table->timestamps();
        });

        Schema::create('comment_has_replies', function (Blueprint $table) {
            $table->id();
            $table->integer('comment_id');
            $table->integer('user_id');
            $table->text('body');
            $table->timestamps();
        });

        Schema::create('reply_has_likes', function (Blueprint $table) {
            $table->id();
            $table->integer('reply_id');
            $table->integer('user_id');
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
        Schema::dropIfExists('users');
    }
}
