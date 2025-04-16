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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('division_id')->nullable();
            $table->foreignId('department_id')->nullable();
            $table->foreignId('supervisor_id')->nullable();
            $table->integer('salary_ref_number');
            $table->string('gender');
            $table->date('dob');
            $table->string('phone_number');
            $table->string('address');
            $table->string('job_grade');
            $table->string('aa_title');
            $table->string('consultant_domain')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
