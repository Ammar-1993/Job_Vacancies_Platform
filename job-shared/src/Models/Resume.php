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
      
        // canonical names (DB columns)
        'fileName',
        'fileUrl',
        // alternate names used elsewhere in the app (map to canonical names)
        'filename',
        'fileUri',
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

    /**
     * Accessor for legacy/alternate attribute `filename` -> maps to DB `fileName`.
     */
    public function getFilenameAttribute()
    {
        return $this->attributes['fileName'] ?? null;
    }

    /**
     * Mutator for legacy/alternate attribute `filename` -> maps to DB `fileName`.
     */
    public function setFilenameAttribute($value)
    {
        $this->attributes['fileName'] = $value;
    }

    /**
     * Accessor for legacy/alternate attribute `fileUri` -> maps to DB `fileUrl`.
     */
    public function getFileUriAttribute()
    {
        return $this->attributes['fileUrl'] ?? null;
    }

    /**
     * Mutator for legacy/alternate attribute `fileUri` -> maps to DB `fileUrl`.
     */
    public function setFileUriAttribute($value)
    {
        $this->attributes['fileUrl'] = $value;
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'resumeId', 'id');
    }


}
