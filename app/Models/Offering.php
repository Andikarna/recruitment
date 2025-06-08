<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offering extends Model
{

    use HasFactory;

    public $table = 'offering';

    public $timestamps = false;

    protected $fillable = [
        'candidate_id',
        'resource_id',
        'resource_detail_id',
        'interview_id',
        'name',
        'position',
        'qualification',
        'project',
        'interview_progress',
        'status',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by'
    ];

    public function offeringApprovals()
    {
        return $this->hasMany(OfferingApproval::class, 'offering_id', 'id');
    }
  
}
