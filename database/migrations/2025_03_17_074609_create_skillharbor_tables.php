<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /**
         * Create assessments table
         *
         */
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->string('assessment_title');
            $table->dateTime('closing_date')->nullable();
            $table->timestamps();
        });
        /**
         * Create JCPs Table
         */
        Schema::create('jcps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('position_title');
            $table->string('job_grade');
            $table->string('duty_station');
            $table->string('job_purpose');
            $table->integer('is_active')->default(1);

            // Add a unique constraint

            $table->timestamps();
        });

        /**
         * Create skill_categories table
         */
        Schema::create('skill_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_title');
            $table->timestamps();
        });

        /**
         * Create skills table
         */
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('skill_title');
            $table->string('skill_description');
            $table->timestamps();
        });

        /**
         *Create Qualifications Table
         *
         */
        Schema::create('qualifications', function (Blueprint $table) {
            $table->id();
            $table->string('qualification_title');
            $table->timestamps();
        });

        $this->seedQualification();

        /**
         * Create user_qualifications table
         */
        Schema::create('qualification_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qualification_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        /**
         *
         * Create JCP Qualifications Table
         *
         */
        Schema::create('jcp_qualification', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jcp_id')->constrained()->cascadeOnDelete();
            $table->foreignId('qualification_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
        /**
         * Create Skillharbor enrollments table
         */

         Schema::create('skillharbor_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assessment_id')->constrained()->cascadeOnDelete();
            $table->integer('user_status')->default(0);
            $table->integer('supervisor_status')->default(0);
            $table->timestamps();
        });

        /**
         * Create jcp_skills table
         */
        Schema::create('jcp_skill', function (Blueprint $table) {
            $table->foreignId('jcp_id')->constrained()->cascadeOnDelete();
            $table->foreignId('skill_id')->constrained()->cascadeOnDelete();
            $table->integer('required_level')->nullable();
            $table->integer('supervisor_rating')->default(0);
            $table->integer('user_rating')->default(0);
            $table->timestamps();

        });


    }

    /**
     * Reverse the migrations.
     */

     public function seedQualification(){
        $qualifications = [
            'Bachelor Degree',
            'Masters Degree',
            'PhD',
            'Diploma',
            'Certificate'
        ];

        foreach ($qualifications as $qualification) {
            DB::table('qualifications')->insert([
                'qualification_title' => $qualification
            ]);
        }
     }
};
