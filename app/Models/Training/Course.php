<?php

namespace App\Models\Training;

use App\Models\Training\Quiz\Quiz;
use App\Models\Training\Reports\Summary;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static findOrFail(int $courseId)
 * @method static create(array $array)
 */
class Course extends Model
{
    /** @use HasFactory<\Database\Factories\Training\CourseFactory> */
    use HasFactory;

    protected $fillable = ['course_name', 'course_description', 'course_fee', 'course_image', 'user_id', 'sme_id', 'start_date', 'end_date', 'course_type', 'is_stem'];

    protected $casts = [
        'start_date' => 'date:dd/mm/yyyy',
        'end_date' => 'date:dd/mm/yyyy',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function sme(): BelongsTo
    {
        return $this->belongsTo(SME::class, 'sme_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsToMany<Enrollment, $this>
     */
    public function enrollment(): BelongsToMany
    {
        return $this->belongsToMany(Enrollment::class, 'enrollments', 'course_id', 'user_id');
    }

    /**
     * @return HasMany<CourseMaterial, $this>
     */
    public function materials(): HasMany
    {
        return $this->hasMany(CourseMaterial::class, 'course_id');
    }

    /**
     * @return HasMany<Quiz, $this>
     */
    public function quizes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'course_id');
    }

    /**
     * @return HasMany<CourseProgress, $this>
     */
    public function progress(): HasMany
    {
        return $this->hasMany(CourseProgress::class, 'course_id', 'user_id');
    }

    /**
     * @return HasOne<Summary, $this>
     */
    public function summary(): HasOne
    {
        return $this->hasOne(Summary::class);
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function enrolledUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id');
    }

    /**
     * @return HasMany<CourseFeedback, $this>
     */
    public function feedback(): HasMany
    {
        return $this->hasMany(CourseFeedback::class);
    }

    /**
     * Trainer KPI Functions
     */
    public function totalStudents(): int
    {
        return $this->enrolledUsers()->count();
    }

    /**
     * Trainer KPI Functions
     */
    public function mostPopularCourse(): ?Course
    {
        $mostPopular = $this->enrollment()
            ->selectRaw('count(*) as total, course_id')
            ->groupBy('course_id')
            ->orderBy('total', 'desc')
            ->first();

        return $mostPopular ? self::find($mostPopular->course_id) : null;
    }

    /**
     * Trainer KPI Functions
     */
    public function totalCost(): int
    {
        return $this->course_fee;
    }

    /**
     * Trainer KPI Functions
     */
    public function passingRate(): float
    {
        $quizes = (int) ($this->quizes()->count());
        $passed = $this->quizes->sum(function ($quiz) {
            return $quiz->passRate();
        });
        if ($quizes == 0) {
            return 0;
        }

        return ($passed / $quizes) * 100;
    }

    /**
     * Trainer KPI Functions
     */
    public function passRate(): float
    {
        $totalQuizzes = (int) ($this->quizes()->count());
        if ($totalQuizzes == 0) {
            return 0;
        }

        /**
         * @var int $totalPassRate
         */
        $totalPassRate = 0;
        foreach ($this->quizes()->get() as $quiz) {
            $totalPassRate += $quiz->passingScore();
        }

        return intdiv($totalPassRate, $totalQuizzes);
    }

    /**
     * Trainer KPI Functions
     */
    public function avgCourseProgress(): float
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
            $userPercentage = ($userProgress['completed_count'] / $totalMaterials) * 100;
            $totalProgress += $userPercentage;
        }

        return round($totalProgress / $totalStudents, 2);
    }

    // to be used in course details KPIs
    /**
     * Trainer KPI Functions
     *
     * @param  array<int, int>  $userIds
     */
    public function courseAverages(array $userIds): int
    {
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
            $userPercentage = ($userProgress['completed_count'] / $totalMaterials) * 100;
            $totalProgress += $userPercentage;
        }

        return $totalStudents > 0 ? (int) (round($totalProgress / $totalStudents, 0)) : 0;
    }
}
