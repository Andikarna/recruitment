<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Family extends Model
{
    use HasFactory;

    public $table = 'family';

    public $timestamps = false;

    protected $fillable = [
        'candidate_id',
        'name',
        'gender',
        'working',
        'education',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by',
    ];
}
