<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_group_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('study_year_id');
            $table->unsignedBigInteger('shift_id');
            $table->timestamps();
            $table->foreign('class_group_id')->references('id')->on('class_groups')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('student_id')->references('id')->on('students')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('study_year_id')->references('id')->on('study_years')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('shift_id')->references('id')->on('shifts')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_classes');
    }
}
