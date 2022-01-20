<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMangaInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manga_information', function (Blueprint $table) {
            $table->id();
            $table->string('manga_name');
            $table->string('alternative_name');
            $table->string('author');
            $table->integer('admin_id');
            $table->string('visual_key')->nullable();
            $table->string('release_date');
            $table->string('status');
            $table->mediumText('description');
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
        Schema::dropIfExists('manga_information');
    }
}
