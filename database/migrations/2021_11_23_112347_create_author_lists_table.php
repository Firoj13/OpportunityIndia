<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company');
            $table->string('designation');
            $table->string('address');
            $table->string('image_path');
            $table->bigInteger('phone_number')->unique();
            $table->string('linkedin_profile');
            $table->string('fb_profile');
            $table->string('twitter_profile');
            $table->string('intro_desc');
            $table->string('email')->unique();
            $table->string('slug');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('author_lists');
    }
}
