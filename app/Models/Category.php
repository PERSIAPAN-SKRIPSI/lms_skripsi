<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo
class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'image', // Tambahkan 'image' disini
        'parent_id', // Tambahkan parent_id ke fillable
    ];

    /**
     * Get all of the courses for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
     // Relasi ke parent
    // Relasi ke parent
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

     // Relasi ke children
     public function children()
     {
         return $this->hasMany(Category::class, 'parent_id');
     }

     // Ambil semua keturunan (recursive)
     public function allChildren()
     {
         return $this->children()->with('allChildren');
     }

}
