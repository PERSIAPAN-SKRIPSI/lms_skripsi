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
