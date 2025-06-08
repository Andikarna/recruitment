<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfferingApproval extends Model
{
    use HasFactory;

    public $table = 'offering_approval';

    public $timestamps = false;

    protected $fillable = [
        'offering_id',
        'resource_id',
        'manajemen_id',
        'message',
        'feedback',
        'status',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by'
    ];

    public function offering()
    {
        return $this->belongsTo(Offering::class, 'offering_id', 'id');
    }

    
}
