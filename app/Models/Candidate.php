<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model
{
    use HasFactory;

    public $table = 'candidate';

    public $timestamps = false;

    protected $fillable = [
        'uniq_code',
        'name',
        'position',
        'mobile_phone',
        'qualification',
        'education',
        'experience',
        'status',
        'gender',
        'major',
        'source',
        'url',
        'isSpecial',
        'isFavoriteId',
        'isFavoriteName',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by'
    ];

    public function emergencyContact()
    {
        return $this->hasOne(EmergencyContact::class, 'candidate_id', 'id');
    }

    public function family()
    {
        return $this->hasOne(Family::class, 'candidate_id', 'id');
    }

    public function education_formal()
    {
        return $this->hasOne(EducationFormal::class, 'candidate_id', 'id');
    }

    public function education_nonformal()
    {
        return $this->hasOne(EducationNonFormal::class, 'candidate_id', 'id');
    }

    public function skill()
    {
        return $this->hasOne(Skill::class, 'candidate_id', 'id');
    }
    
    public function languange()
    {
        return $this->hasOne(Languange::class, 'candidate_id', 'id');
    }
    
    public function certificate()
    {
        return $this->hasOne(Certificate::class, 'candidate_id', 'id');
    }

    public function organization()
    {
        return $this->hasOne(Organization::class, 'candidate_id', 'id');
    }

    public function working_experience()
    {
        return $this->hasOne(WorkingExperience::class, 'candidate_id', 'id');
    }

    public function additional_information()
    {
        return $this->hasOne(AdditionalInformation::class, 'candidate_id', 'id');
    }

    public function reference()
    {
        return $this->hasOne(Reference::class, 'candidate_id', 'id');
    }



}
