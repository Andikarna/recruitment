<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfferingSalary extends Model
{
    use HasFactory;

    public $table = 'offering_salary';
    public $timestamps = false;
    protected $fillable = [
        'offering_id',
        'salary',
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
