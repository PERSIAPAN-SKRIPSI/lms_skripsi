<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionOption extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct'
    ];

    // Relasi ke Question
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
