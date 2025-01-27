<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    public $table = 'interview_candidate';

    public $timestamps = false;

    protected $fillable = [
        'candidate_id',
        'resource_id',
        'resource_detail_id',
        'name',
        'position',
        'qualification',
        'project',
        'interview_progress',
        'interview_date',
        'status',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by'
    ];
}
