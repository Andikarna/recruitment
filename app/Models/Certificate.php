<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory;

    public $table = 'certificate';

    public $timestamps = false;

    protected $fillable = [
        'candidate_id',
        'name',
        'publisher',
        'year',
        'end_date',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by',
    ];
}
