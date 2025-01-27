<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceSalary extends Model
{
    use HasFactory;

    public $table = 'resource_salary';
    public $timestamps = false;
    protected $fillable = [
        'resource_id',
        'resource_detail_id',
        'min_salary',
        'max_salary',
        'ket_salary',
        'pph21',
        'ket_pph21',
        'bpjs_ket',
        'ket_bpjsket',
        'bpjs_kes',
        'ket_bpjskes',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by',
    ];
}
