<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reference extends Model
{
    use HasFactory;

    public $table = 'reference';

    public $timestamps = false;

    protected $fillable = [
        'candidate_id',
        'name',
        'number',
        'position',
        'relation',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by',
    ];

}
