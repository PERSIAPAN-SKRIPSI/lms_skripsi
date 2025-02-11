<?php

// app/Models/Chapter.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
      'course_id',
        'name',
        'order', // Urutan chapter
    ];

      /**
 * Get the course that owns the Chapter
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function course(): BelongsTo
{
    return $this->belongsTo(Course::class);
}

 /**
 * Get all of the videos for the Chapter
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
public function videos(): HasMany
{
    return $this->hasMany(CourseVideo::class);
}
}
