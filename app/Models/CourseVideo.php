<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseVideo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'path_video',
        'course_id',
        'chapter_id', // TAMBAHKAN INI!
    ];

    /**
     * Get the course that owns the CourseVideo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    public function chapter(): BelongsTo
    {
       return $this->belongsTo(Chapter::class);
    }
}
