<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowledgeAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('knowledge_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assignment_id');
            $table->unsignedBigInteger('student_id');
            $table->enum('attachment_type', ['file', 'link'])->nullable();
            $table->string('attachment')->nullable();
            // $table->tinyText('comment')->nullable();
            $table->double('grade');
            $table->double('score')->nullable();
            $table->double('remedial')->nullable();
            $table->boolean('is_finished');
            $table->tinyText('feedback')->nullable();
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
        Schema::dropIfExists('knowledge_assessments');
    }
}
