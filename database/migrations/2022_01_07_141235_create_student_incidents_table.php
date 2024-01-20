<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_incidents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('student_id');
            $table->string('incident');
            $table->enum('attitude_item', ['responsibility','honest','mutual_cooperation','self_confident','discipline']);
            $table->enum('attitude_value', ['positive','negative']);
            $table->string('follow_up')->nullable();
            $table->date('date');
            $table->timestamps();
            $table->foreign('course_id')->references('id')->on('courses')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('student_incidents');
    }
}
