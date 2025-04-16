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
        Schema::create('smes', function (Blueprint $table) {
            $table->id();
            $table->string('sme_name');
            $table->string('sme_email')->unique();
            $table->string('sme_phone')->unique();
            $table->enum('sme_type', ['internal', 'external']);
            $table->string('sme_institution');
            $table->text('sme_description');
            $table->foreignId('consultant_id')->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_m_e_s');
    }
};
