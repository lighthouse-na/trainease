<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->decimal('facilitator_cost', 10, 2)->default(0.00)->nullable();
            $table->decimal('course_material_cost', 10, 2)->default(0.00)->nullable();
            $table->decimal('assessment_cost', 10, 2)->default(0.00)->nullable();
            $table->decimal('certification_cost', 10, 2)->default(0.00)->nullable();
            $table->decimal('travel_cost', 10, 2)->default(0.00)->nullable();
            $table->decimal('accommodation_cost', 10, 2)->default(0.00)->nullable();
            $table->decimal('subsistence_cost', 10, 2)->default(0.00)->nullable();
            $table->decimal('other_cost', 10, 2)->default(0.00)->nullable();
            $table->decimal('total_cost', 10, 2)->default(0.00)->nullable();

            // File columns for invoices
            $table->string('facilitator_invoice')->nullable(); // Path for facilitator invoice
            $table->string('course_material_invoice')->nullable();  // Path for course material invoice
            $table->string('assessment_invoice')->nullable();  // Path for assessment invoice
            $table->string('certification_invoice')->nullable();  // Path for certification invoice
            $table->string('travel_invoice')->nullable();  // Path for travel invoice
            $table->string('accommodation_invoice')->nullable();  // Path for accommodation invoice
            $table->string('subsitence_invoice')->nullable();  // Path for subsitence invoice
            $table->string('other_invoice')->nullable();  // Path for other invoice

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('summaries');
    }
};
