<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceFacility extends Model
{
    use HasFactory;
    public $table = 'resource_facility';
    public $timestamps = false;
    protected $fillable = [
        'resource_id',
        'resource_detail_id',
        'fasilitas_name',
        'ket_fasilitas',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by',
    ];


}
