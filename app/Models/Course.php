<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'path_trailer',
        'about',
        'thumbnail',
        'teacher_id',
        'category_id',

    ];

    /**
     * Get the category that owns the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the teacher that owns the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get all of the videos for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos(): HasMany
    {
        return $this->hasMany(CourseVideo::class);
    }

    /**
     * Get all of the keypoints for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function keypoints(): HasMany
    {
        return $this->hasMany(CourseKeypoint::class);
    }
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
    /**
     * The students that belong to the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_employees')
            ->withPivot('enrolled_at', 'is_completed')
            ->withTimestamps();
    }
}
