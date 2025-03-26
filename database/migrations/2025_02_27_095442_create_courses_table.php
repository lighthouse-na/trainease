<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('course_name');
            $table->string('course_description');
            $table->integer('course_fee');
            $table->string('course_image');
            $table->enum('course_type', ['online', 'face-to-face', 'hybrid']);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });

    }
};
