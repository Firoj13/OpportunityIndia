<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentAssignedTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_assigned_tags', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('content_id');
            $table->bigInteger('tag_id');
            $table->tinyInteger('sequence_order');
            $table->tinyInteger('content_type');
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
        Schema::dropIfExists('content_assigned_tags');
    }
}
