<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model
{
    use HasFactory;

    public $table = 'candidate';

    public $timestamps = false;

    protected $fillable = [
        'uniq_code',
        'name',
        'position',
        'qualification',
        'education',
        'experience',
        'status',
        'gender',
        'major',
        'source',
        'url',
        'isSpecial',
        'isFavoriteId',
        'isFavoriteName',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by'
    ];

}
