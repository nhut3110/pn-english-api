<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name');
            $table->string('student_phone');
            $table->string('student_email');
            $table->string('parent_phone');
            $table->integer('age');
            $table->string('address');
            $table->string('description')->default("");
            $table->integer('current_class_id');
            $table->boolean('is_paid');
            $table->date("start_date")->nullable()->default(null);
            $table->date("end_date")->nullable()->default(null);
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
        Schema::dropIfExists('student');
    }
};
