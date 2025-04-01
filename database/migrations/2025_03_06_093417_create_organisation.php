<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->createOrganisation();
    }

    public function createOrganisation()
    {
        // Insert default organisation
        DB::table('organisations')->insert([
            'organisation_name' => 'Telecom Namibia pty (ltd)',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Create initial divisions
        $divisions = ['Human Resources', 'Technical & Information', 'Marketing', 'Commercial', 'Finance', 'Corporate Communications & Public Relations', 'Technical Operations & Projects', 'Office of the CEO', 'Legal & Regulatory Services'];

        // Get the first organisation ID
        $organisationId = DB::table('organisations')->first()->id ?? 1;

        // Insert divisions
        foreach ($divisions as $divisionName) {
            DB::table('divisions')->insert([
                'organisation_id' => $organisationId,
                'division_name' => $divisionName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        // Get the Technical Operations & Projects division
        $technicalDivisionId = DB::table('divisions')
            ->where('division_name', 'Technical Operations & Projects')
            ->first()->id;

        // Define departments for Technical Operations & Projects
        $departments = [
            'DEPI',
            'Business Information & Technology',
            'Field Service',
            'Network Operations',
        ];

        // Insert departments
        // Insert departments for Technical Operations & Projects division
        foreach ($departments as $departmentName) {
            DB::table('departments')->insert([
                'division_id' => $technicalDivisionId,
                'department_name' => $departmentName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Get the Marketing division ID
        $marketingDivisionId = DB::table('divisions')
            ->where('division_name', 'Marketing')
            ->first()->id;

        // Define departments for Marketing
        $marketingDepartments = [
            'Office of the CMO',
            'Intelligence',
            'Product Research and Development',
            'Strategy',
        ];

        // Insert Marketing departments
        foreach ($marketingDepartments as $departmentName) {
            DB::table('departments')->insert([
                'division_id' => $marketingDivisionId,
                'department_name' => $departmentName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Get the Human Resources division ID
        $hrDivisionId = DB::table('divisions')
            ->where('division_name', 'Human Resources')
            ->first()->id;

        // Define departments for Human Resources
        $hrDepartments = [
            'Development and Organisational Effectiveness',
            'Employee Relations & Wellness',
            'Partnering and Administration',
        ];

        // Insert HR departments
        foreach ($hrDepartments as $departmentName) {
            DB::table('departments')->insert([
                'division_id' => $hrDivisionId,
                'department_name' => $departmentName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Get the Finance division ID
        $financeDivisionId = DB::table('divisions')
            ->where('division_name', 'Finance')
            ->first()->id;

        // Define departments for Finance
        $financeDepartments = [
            'Accounting & Control',
            'Credit Control',
            'Management Accounting & Financial Planning',
            'Supply Chain',
            'Revenue Assurance & Network Fraud',
        ];

        // Insert Finance departments
        foreach ($financeDepartments as $departmentName) {
            DB::table('departments')->insert([
                'division_id' => $financeDivisionId,
                'department_name' => $departmentName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Get the Commercial division ID
        $commercialDivisionId = DB::table('divisions')
            ->where('division_name', 'Commercial')
            ->first()->id;

        // Define departments for Commercial
        $commercialDepartments = [
            'Back Office',
            'Customer Contact Centre',
            'Central Business Area',
            'Government',
            'Maritime Rescue Coordination Centre',
            'Retail/Teleshop',
            'Wholesale',
            'Office of CCO',
            'Commercial Central',
            'Commercial Erongo',
            'Commercial North',
            'Commercial South',
        ];

        // Insert Commercial departments
        foreach ($commercialDepartments as $departmentName) {
            DB::table('departments')->insert([
                'division_id' => $commercialDivisionId,
                'department_name' => $departmentName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
};
