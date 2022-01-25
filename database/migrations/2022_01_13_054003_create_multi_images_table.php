<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultiImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multi_images', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->bigInteger('manga_information_id')->unsigned();
            $table->integer('volume_id');
            $table->bigInteger('episode_id')->unsigned();
            $table->string('manga_image');
            $table->string('image_name');
            $table->timestamps();
        });
        Schema::table('multi_images',function (Blueprint $table){
            $table->foreign('manga_information_id')->references('id')->on('manga_information')->onDelete('cascade');
            $table->foreign('episode_id')->references('id')->on('episodes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('multi_images');
    }
}
