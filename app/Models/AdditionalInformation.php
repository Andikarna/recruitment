<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdditionalInformation extends Model
{
    use HasFactory;

    public $table = 'additional_information';

    public $timestamps = false;
    
    protected $fillable = [
       'candidate_id',
       'source',
       'been_treated',
       'disease',
       'strength',
       'weakness',   
       'against_weakness',
       'created_date',
       'created_id',
       'created_by',
       'updated_date',
       'updated_id',
       'updated_by',
    ];

}
