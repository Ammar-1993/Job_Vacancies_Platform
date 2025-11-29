<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\JobCategory;

class JobVacancy extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'job_vacancies';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'description',
        'location',
        'salary',
        'type',
        'viewCount',
        'jobCategoryId',
        'companyId',

    ];

      protected $dates = [
        'deleted_at',
    ];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
            'type' => \App\Enums\JobType::class,
        ];
    }

    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class, 'jobCategoryId', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'companyId', 'id');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'jobVacancyId', 'id');
    }
}
