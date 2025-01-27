<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaksList extends Model
{
    use HasFactory;

    public $table = 'takslist';
    public $timestamps = false;
    protected $fillable = [
        'resource_id',
        'resource_detail_id',
        'user_id',
        'username',
        'status',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by'
    ];

    public function resource()
    {
        return $this->belongsTo(Resource::class, 'resource_id');
    }

    public function resource_detail()
    {
        return $this->belongsTo(ResourceDetail::class, 'resource_detail_id');
    }
}
