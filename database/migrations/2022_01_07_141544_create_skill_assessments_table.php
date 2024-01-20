<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skill_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assignment_id');
            $table->unsignedBigInteger('student_id');
            $table->enum('attachment_type', ['file', 'link'])->nullable();
            $table->string('attachment')->nullable();
            // $table->tinyText('comment')->nullable();
            $table->double('grade');
            $table->double('theory_score')->nullable();
            $table->double('process_score')->nullable();
            $table->double('rhetoric_score')->nullable();
            $table->double('feedback_score')->nullable();
            $table->double('result_score')->nullable();
            $table->double('total_score')->nullable();
            $table->double('score')->nullable();
            $table->tinyText('description')->nullable();
            $table->timestamps();
            $table->foreign('assignment_id')->references('id')->on('assignments')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('skill_assessments');
    }
}
