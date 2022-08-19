<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_language', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->integer('lang_id');
            $table->string('category_name',255);
            $table->string('meta_title',255);
            $table->text('meta_description');
            $table->string('meta_keywords',255);
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
        Schema::dropIfExists('category_language');
    }
}
