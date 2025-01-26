<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quiz_id',
        'question',
        'question_type'
    ];

    // Relasi ke Quiz
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    // Relasi ke QuestionOptions
    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }
}
