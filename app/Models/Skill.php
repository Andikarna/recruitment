<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory;

    public $table = 'skill';

    public $timestamps = false;

    protected $fillable = [
        'candidate_id',
        'name',
        'level',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by',
    ];
}
