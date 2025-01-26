<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'certificate',
        'cv',
        'specialization',
        'experience_years',
        'is_active'
    ];

    public function getCertificateUrl()
    {
        return Storage::url($this->certificate);
    }

    public function getCvUrl()
    {
        return Storage::url($this->cv);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
