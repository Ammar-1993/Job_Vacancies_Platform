<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class JobApplication extends Model
{
    //
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'job_applications';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'status',
        'aiGeneratedScore',
        'aiGeneratedFeedback',
        'jobVacancyId',
        'userId',
        'resumeId',
        
    

    ];

      protected $dates = [
        'deleted_at',
    ];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
            'status' => \App\Enums\JobStatus::class,
        ];
    }

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'jobVacancyId', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function resume()
    {
        return $this->belongsTo(Resume::class, 'resumeId', 'id');
    }
}
