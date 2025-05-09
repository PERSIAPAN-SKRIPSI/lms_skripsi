<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'passing_score',
        'duration',
        'is_active',
        'chapter_id', // Pastikan chapter_id ada di sini!

    ];

    // Relasi ke Course
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    // Relasi ke Questions
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    // Relasi ke QuizAttempts
    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
