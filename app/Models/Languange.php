<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Languange extends Model
{
    use HasFactory;

    public $table = 'languange';

    public $timestamps = false;

    protected $fillable = [
       'candidate_id',
       'name_languange',
       'write',
       'speak',
       'read',
       'created_date',
       'created_id',
       'created_by',
       'updated_date',
       'updated_id',
       'updated_by',
    ];
}
