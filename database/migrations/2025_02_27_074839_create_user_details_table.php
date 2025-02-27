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
            $table->foreignId('user_id')->onDelete('cascade');
            $table->foreignId('division_id')->onDelete('cascade')->nullable();
            $table->foreignId('department_id')->onDelete('cascade')->nullable();
            $table->foreignId('supervisor_id')->onDelete('cascade')->nullable();
            $table->integer('salary_ref_number');
            $table->string('gender');
            $table->date('dob');
            $table->string('phone_number');
            $table->string('address');
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
