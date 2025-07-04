<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resource extends Model
{
    use HasFactory;

    public $table = 'resource';

    protected $fillable = [
        'name',
        'client',
        'project',
        'level_priority',
        'target_date',
        'requirment',
        'file',
        'created_date',
        'created_by',
        'created_date',
        'updated_date',
        'updated_by',
        'updated_date',
    ];

    protected $casts = [
        'target_date' => 'datetime',
    ];

    public function resource_detail()
    {
        return $this->hasOne(ResourceDetail::class, 'resource_id', 'id');
    }

    public function interview(){
         return $this->hasOne(Interview::class, 'resource_id', 'id');
    }
    
}
