<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder; // Tambahkan ini

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'occupation',
        'avatar',
        'nik',
        'gender',
        'date_of_birth',
        'address',
        'phone_number',
        'division',
        'position',
        'employment_status',
        'join_date',
        // 'is_active',
        // 'is_approved'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_approved' => 'boolean', // Cast is_approved to boolean
    ];

    /**
     * Relasi ke model SubscribeTransaction
     */

    /**
     * Relasi ke model Course (kursus yang dibeli user)
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_employees')
        ;
    }

    public function quizAttempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }
}
