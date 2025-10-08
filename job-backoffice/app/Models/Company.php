<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\JobVacancy;
use App\Models\JobApplication;

class Company extends Model
{
    //
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'companies';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'address',
        'industry',
        'website',
        'ownerId',

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

    public function owner()
    {
        return $this->belongsTo(User::class, 'ownerId', 'id');
    }

    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'companyId', 'id');
    }

    /**
     * Get all job applications for the company via job vacancies.
     */
    public function jobApplications()
    {
        return $this->hasManyThrough(JobApplication::class, JobVacancy::class, 'companyId', 'jobVacancyId', 'id', 'id');
    }
}
