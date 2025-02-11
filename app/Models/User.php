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
use Illuminate\Support\Facades\Storage;
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

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
        'is_active',
        'is_approved' // Tambahkan is_approved disini
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
        return $this->belongsToMany(Course::class, 'course_karyawans')
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

    public function getAvatarUrlAttribute()
    {
        return Storage::url($this->avatar);
    }
     /**
     * Cek apakah user adalah PRO (employee)
     */
   /**
     * Check if user is an approved employee and thus PRO
     */
    public function isPro(): bool
    {
        return $this->employment_status === 'employee' && $this->is_approved;
    }

    // Attribute to get pro status
    public function getProStatusAttribute(): string
    {
        if ($this->isPro()) {
            return 'PRO';
        } elseif ($this->employment_status === 'employee' && !$this->is_approved) {
            return 'Pending Approval';
        } else {
            return '';
        }
    }
     // Scope untuk mendapatkan hanya karyawan (employees)
 // Scope untuk mendapatkan hanya karyawan (employees)
 public function scopeEmployees(Builder $query): void
 {
     $query->where('employment_status', 'employee');
 }

 // Scope untuk mendapatkan employees yang belum di-approve
 public function scopePendingApproval(Builder $query): void
 {
     $query->employees()->where('is_approved', false);
 }
}
