<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceDetail extends Model
{
    use HasFactory;
    
    public $table = 'resource_detail';
    public $timestamps = false;
    protected $fillable = [
        'resource_id',
        'position',
        'skill',
        'quantity',
        'education',
        'qualification',
        'experience',
        'contract',
        'description',
        'created_date',
        'created_by',
        'created_id',
        'updated_date',
        'updated_by',
        'updated_id'
    ];

    public function resource()
    {
        return $this->belongsTo(Resource::class, 'resource_id');
    }
}
