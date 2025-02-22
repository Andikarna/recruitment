<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EducationFormal extends Model
{
    use HasFactory;

    public $table = 'education_formal';

    public $timestamps = false;

    protected $fillable = [
       'candidate_id',
       'name',
       'level',
       'city',
       'major',
       'gpa',
       'start_date',
       'end_date',
       'created_date',
       'created_id',
       'created_by',
       'updated_date',
       'updated_id',
       'updated_by'
    ];
}
