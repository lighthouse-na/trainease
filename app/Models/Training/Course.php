<?php

namespace App\Models\Training;

use App\Models\Training\Quiz\Quiz;
use App\Models\Training\Reports\Summary;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\Training\CourseFactory> */
    use HasFactory;

    protected $fillable = ['course_name', 'course_description', 'course_fee', 'course_image', 'user_id', 'start_date', 'end_date', 'course_type'];

    protected $casts = [
        'start_date' => 'date:dd/mm/yyyy',
        'end_date' => 'date:dd/mm/yyyy',
    ];

    public function trainer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function enrollment()
    {
        return $this->belongsToMany(Enrollment::class, 'enrollments', 'course_id', 'user_id');
    }

    public function materials()
    {
        return $this->hasMany(CourseMaterial::class, 'course_id');
    }

    public function quizes()
    {
        return $this->hasMany(Quiz::class, 'course_id');
    }

    public function progress()
    {
        return $this->hasMany(CourseProgress::class, 'course_id', 'user_id', 'course_material_id', 'status');
    }

    public function summary(){
        return $this->hasMany(Summary::class);
    }



    public function enrolledUsers()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id');
    }

    public function feedback()
    {
        return $this->hasMany(CourseFeedback::class);
    }

    /**
     * Trainer KPI Functions
     */
    public function totalStudents()
    {
        return $this->enrolledUsers()->count();
    }


    public function mostPopularCourse(){
        return $this->enrollment()
            ->selectRaw('count(*) as total, course_id')
            ->groupBy('course_id')
            ->orderBy('total', 'desc')
            ->first();
    }

    public function totalCost(){
        return $this->course_fee;
    }

    public function passingRate(){
        $quizes = $this->quizes()->count();
        $passed = $this->quizes()->passRate();
        if($quizes == 0){
            return 0;
        }
        return ($passed / $quizes) * 100;
    }

    public function passRate()
    {
        $totalQuizzes = $this->quizes()->count();
        if ($totalQuizzes == 0) {
            return 0;
        }

        $totalPassRate = 0;
        foreach ($this->quizes as $quiz) {
            $totalPassRate += $quiz->passRate();
        }

        return $totalPassRate / $totalQuizzes;
    }

    public function avgCourseProgress()
    {
        $totalStudents = $this->totalStudents();
        $totalMaterials = $this->materials()->count();

        if ($totalMaterials == 0 || $totalStudents == 0) {
            return 0;
        }

        // Import the CourseProgress model at the top of your file
        // use App\Models\Training\CourseProgress;

        $userProgressData = \App\Models\Training\CourseProgress::where('course_id', $this->id)
            ->selectRaw('user_id, count(*) as completed_count')
            ->where('status', 'completed') // Assuming 'completed' is the status value
            ->groupBy('user_id')
            ->get();

        $totalProgress = 0;
        foreach ($userProgressData as $userProgress) {
            $userPercentage = ($userProgress->completed_count / $totalMaterials) * 100;
            $totalProgress += $userPercentage;
        }

        return round($totalProgress / $totalStudents, 2);
    }
    //to be used in course details KPIs
    public function courseAverages($userIds = null){
        $totalStudents = $userIds ? count($userIds) : $this->totalStudents();
        $totalMaterials = $this->materials()->count();

        if ($totalMaterials == 0 || $totalStudents == 0) {
            return 0;
        }

        $query = \App\Models\Training\CourseProgress::where('course_id', $this->id)
            ->where('status', 'completed');

        if ($userIds) {
            $query->whereIn('user_id', $userIds);
        }

        $userProgressData = $query
            ->selectRaw('user_id, count(*) as completed_count')
            ->groupBy('user_id')
            ->get();

        $totalProgress = 0;
        foreach ($userProgressData as $userProgress) {
            $userPercentage = ($userProgress->completed_count / $totalMaterials) * 100;
            $totalProgress += $userPercentage;
        }

        return $totalStudents > 0 ? round($totalProgress / $totalStudents, 2) : 0;
    }



}
