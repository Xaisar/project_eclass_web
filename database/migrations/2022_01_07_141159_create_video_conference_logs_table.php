<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoConferenceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_conference_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('video_conference_id');
            $table->unsignedBigInteger('student_id');
            $table->timestamps();
            $table->foreign('video_conference_id')->references('id')->on('video_conferences')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_conference_logs');
    }
}
