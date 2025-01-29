<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfferingFasility extends Model
{
    use HasFactory;
    public $table = 'offering_facility';
    public $timestamps = false;
    protected $fillable = [
        'offering_id',
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
