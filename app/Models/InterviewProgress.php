<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewProgress extends Model
{
    use HasFactory;

    public $table = 'interview_progress';

    public $timestamps = false;
    protected $fillable = [
        'resource_id',
        'resource_detail_id',
        'interview_type_id',
        'name_progress',
        'isClient',
        'description',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by',
    ];
}
