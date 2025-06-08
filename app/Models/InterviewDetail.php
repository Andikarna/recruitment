<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InterviewDetail extends Model
{
    use HasFactory;

    public $table = 'interview_detail';

    public $timestamps = false;

    protected $fillable = [
        'interview_id',
        'interview_type_id',
        'name_progress',
        'interview_date',
        'interview_time',
        'file',
        'url',
        'user',
        'interview_status',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by',
    ];

    public function resource()
    {
        return $this->belongsTo(Interview::class, 'interview_id');
    }
}
