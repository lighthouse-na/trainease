<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Organisation\Department;
use App\Models\Organisation\Division;
use App\Models\Training\Course;
use App\Models\Training\CourseMaterial;
use App\Models\Training\CourseProgress;
use App\Models\Training\Enrollment;
use App\Models\Training\Quiz\QuizResponse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function user_details_filled(): bool
    {
        return $this->user_detail()->exists();
    }

    public function user_detail()
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    public function department()
    {
        return $this->user_detail->department();
    }

    public function division()
    {
        return $this->user_detail->division();
    }

    public function organisation(){
        return $this->division->organisation();
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function courseProgress()
    {
        return $this->hasMany(CourseProgress::class);
    }

    public function calculateProgress($courseId)
    {

        // Get all course materials for the training

        $courseMaterials = CourseMaterial::where('course_id', $courseId)->get();
        $totalMaterials = $courseMaterials->count();

        // Get completed materials for the user in this training

        $completedMaterials = $this->courseProgress()

            ->whereIn('course_material_id', $courseMaterials->pluck('id'))

            ->where('status', 'completed')

            ->count();

        // Calculate progress percentage

        return $totalMaterials > 0 ? round(($completedMaterials / $totalMaterials) * 100,0) : 0;
    }

    public function quizResponses()
    {
        return $this->hasMany(QuizResponse::class, 'user_id');
    }

    public function getQuizAttempts($quiz_id)
    {
        return $this->quizResponses()
            ->where('quiz_id', $quiz_id)
            ->sum('attempts');
    }

    public function hasCompletedQuiz(){
        return $this->quizResponses()
            ->where('status', 'passed')
            ->exists();
    }

    public function userHasPassed($quiz_id)
    {
        return $this->quizResponses()
            ->where('quiz_id', $quiz_id)
            ->where('status', 'passed')
            ->exists();

    }

    public function trainerCourses(){
        return $this->hasMany(Course::class, 'trainer_id');
    }


}
