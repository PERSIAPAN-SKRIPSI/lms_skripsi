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
        'is_completed', // Tambahkan ini untuk
        'is_approved', // Pastikan kolom ini ada
        "video_completions"
    ];
     // Add this line to cast 'enrolled_at' to a datetime object
     protected $casts = [
        'enrolled_at' => 'datetime',
        'video_completions' => 'array', // Cast video_completions ke arr
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
