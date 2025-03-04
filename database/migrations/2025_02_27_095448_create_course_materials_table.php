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
        Schema::create('course_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('material_name'); // Title of the material
            $table->text('description')->nullable(); // Description of the material
            $table->text('material_content')->nullable(); // For text content or JSON quiz data
            $table->timestamps();
        });

    }
};
