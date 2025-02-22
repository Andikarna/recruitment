<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EducationNonFormal extends Model
{
    use HasFactory;

    public $table = 'education_nonformal';

    public $timestamps = false;

    protected $fillable = [
        'candidate_id',
        'name',
        'year',
        'duration',
        'certificate',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by',
    ];
}
