<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Resume extends Model
{
    //
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'resumes';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
      
        'fileName',
        'fileUrl',
        'summary',
        'contactDetails',
        'education',
        'experience',
        'skills',
        'userId',
        
    ];

      protected $dates = [
        'deleted_at',
    ];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'resumeId', 'id');
    }


}
