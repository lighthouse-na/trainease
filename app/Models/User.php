<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Organisation\Department;
use App\Models\Training\Badge;
use App\Models\Training\Certificate;
use App\Models\Training\CourseMaterial;
use App\Models\Training\CourseProgress;
use App\Models\Training\Enrollment;
use App\Models\Training\SubsistenceAndTravel;
use App\Models\Training\Training;
use App\Models\Training\TrainingRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles;


    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

        'first_name',
        'last_name',
        'email',
        'password',
        'salary_ref_number',
        'supervisor_id',
        'department_id',
        'dob',
        'gender',
        'supervisor_id',
        'training_id',
        'status',
        'enrolled_at'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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
     * Get the Supervisor of the user
     */
    public function supervisor(){
        return $this->belongsTo(User::class,'supervisor_id');
    }
    /**
     * Get the users a user is supervising
     */
    public function supervising(){
        return $this->hasMany(User::class, 'supervisor_id');
    }
    /**
     * Get the users badges
     */
    public function badges(){
        return $this->hasMany(Badge::class, 'user_id');
    }
    /**
     * Get the Training Requests of the user
     */
    public function trainingRequests(){
        return $this->hasMany(TrainingRequest::class, 'user_id');
    }
    /**
     * Get the S&T Requests of the user
     */
    public function subsistenceAndTravelRequests(){
        return $this->hasMany(SubsistenceAndTravel::class, 'user_id');
    }
    /**
     * Get the users department
     */
    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }
    /**
     * Get the trainings a user is enrolled in
     */
    public function trainerTrainings(){
        return $this->hasMany(Training::class, 'user_id');
    }
    /**
     * Get the users enrollments
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }


    public function courseProgress()
    {
        return $this->hasMany(CourseProgress::class);
    }
    public function calculateProgress($trainingId)

    {

        // Get all course materials for the training

        $courseMaterials = CourseMaterial::where('training_id', $trainingId)->get();
        $totalMaterials = $courseMaterials->count();


        // Get completed materials for the user in this training

        $completedMaterials = $this->courseProgress()

            ->whereIn('course_material_id', $courseMaterials->pluck('id'))

            ->where('status', 'completed')

            ->count();


        // Calculate progress percentage

        return $totalMaterials > 0 ? ($completedMaterials / $totalMaterials) * 100 : 0;

    }




}
