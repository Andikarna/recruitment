<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory;

    public $table = 'organization';

    public $timestamps = false;

    protected $fillable = [
       'candidate_id',
       'name',
       'type',
       'year',
       'position',
       'created_date',
       'created_id',
       'created_by',
       'updated_date',
       'updated_id',
       'updated_by',
    ];

}
