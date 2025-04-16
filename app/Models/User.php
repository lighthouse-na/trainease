<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Organisation\Department;
use App\Models\Organisation\Division;
use App\Models\Organisation\Organisation;
use App\Models\SkillHarbor\Qualification;
use App\Models\Training\Course;
use App\Models\Training\CourseMaterial;
use App\Models\Training\CourseProgress;
use App\Models\Training\Enrollment;
use App\Models\Training\Quiz\QuizResponse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 */
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

    /**
     * @return HasOne<UserDetail, $this>
     */
    public function user_detail(): HasOne
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    /**
     * @return HasOneThrough<UserDetail, Department, $this>
     */
    public function department(): HasOneThrough
    {
        return $this->hasOneThrough(UserDetail::class, Department::class);
    }

    /**
     * @return HasOneThrough<UserDetail, Division, $this>
     */
    public function division(): HasOneThrough
    {
        return $this->hasOneThrough(UserDetail::class, Division::class);
    }

    /**
     * @return HasOneThrough<UserDetail,Organisation, $this>
     */
    public function organisation(): HasOneThrough
    {
        return $this->hasOneThrough(UserDetail::class, Organisation::class);
    }

    /**
     * @return HasMany<Enrollment, $this>
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * @return HasMany<CourseProgress, $this>
     */
    public function courseProgress(): HasMany
    {
        return $this->hasMany(CourseProgress::class);
    }

    public function calculateProgress(int $courseId): int
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

        return $totalMaterials > 0 ? (int) (round(($completedMaterials / $totalMaterials) * 100, 0)) : 0;
    }

    /**
     * @return HasMany<QuizResponse, $this>
     */
    public function quizResponses(): HasMany
    {
        return $this->hasMany(QuizResponse::class, 'user_id');
    }

    /**
     * @param  int  $quiz_id  <int>
     */
    public function getQuizAttempts(int $quiz_id): int
    {
        return (int) ($this->quizResponses()
            ->where('quiz_id', $quiz_id)
            ->sum('attempts'));
    }

    public function hasCompletedQuiz(): bool
    {
        return $this->quizResponses()
            ->where('status', 'passed')
            ->exists();
    }

    /**
     * @param  int  $quiz_id  <int>
     */
    public function userHasPassed(int $quiz_id): bool
    {
        return $this->quizResponses()
            ->where('quiz_id', $quiz_id)
            ->where('status', 'passed')
            ->exists();

    }

    /**
     * @return HasMany<Course, $this>
     */
    public function trainerCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'user_id');
    }

    /**
     * @return BelongsToMany<Qualification, $this>
     */
    public function qualifications(): BelongsToMany
    {
        return $this->belongsToMany(Qualification::class, 'user_qualification')->withPivot('from_date', 'end_date', 'status');
    }
}
