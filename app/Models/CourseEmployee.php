<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseEmployee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'course_id',
        'enrolled_at', // Tambahkan kolom baru
        'is_completed', // Tambahkan kolom baru
        'is_approved', // Pastikan kolom ini ada
    ];
     // Add this line to cast 'enrolled_at' to a datetime object
     protected $casts = [
        'enrolled_at' => 'datetime',
    ];
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id'); // Asumsi relasi ke model User
    }
}
