<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage; // Import the Storage facade

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
        'duration',
        'demo_video_storage',
        'demo_video_source',
        'description'
    ];

    protected $casts = [
        'demo_video_storage' => 'string',
        'demo_video_source' => 'string',
    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function videos(): HasMany
    {
        return $this->hasMany(CourseVideo::class);
    }

    public function keypoints(): HasMany
    {
        return $this->hasMany(CourseKeypoint::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_employees')
            ->withPivot('enrolled_at', 'is_approved') // Correct pivot columns
            ->withTimestamps();
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class)->orderBy('order'); // Order chapters
    }

    public function students(): BelongsToMany
    {
        return $this->employees(); // Alias to employees()
    }

    // Accessor for the full thumbnail URL
// Accessor untuk thumbnail
    public function getThumbnailUrlAttribute(): ?string
    {
        if (empty($this->thumbnail)) {
            return asset('thumbnails/default.png');
        }

        try {
            return Storage::exists($this->thumbnail)
                ? Storage::url($this->thumbnail)
                : asset('thumbnails/default.png');
        } catch (\Exception $e) {
            return asset('thumbnails/default.png');
        }
    }

    // Accessor untuk demo video
    public function getDemoVideoUrlAttribute(): ?string
    {
        if (empty($this->demo_video_source)) {
            return null;
        }

        switch ($this->demo_video_storage) {
            case 'upload':
                return Storage::exists($this->demo_video_source)
                    ? Storage::url($this->demo_video_source)
                    : null;
            case 'youtube':
            case 'external_link':
                return $this->demo_video_source;
            default:
                return null;
        }
    }
}
