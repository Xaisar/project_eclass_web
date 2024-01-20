<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('major_id');
            $table->string('uid')->unique();
            $table->string('identity_number')->unique();
            $table->string('name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('birthplace')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('parent_phone_number');
            $table->string('picture');
            $table->string('address');
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('major_id')->references('id')->on('majors')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
