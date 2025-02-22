<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkingExperience extends Model
{
    use HasFactory;

    public $table = 'working_experience';

    public $timestamps = false;

    protected $fillable = [
        'candidate_id',
        'name',
        'industry',
        'address',
        'status',
        'start_date',
        'end_date',
        'description',
        'allowence',
        'salary',
        'reason',
        'project',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by',
    ];
}
