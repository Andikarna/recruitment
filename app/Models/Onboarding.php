<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Onboarding extends Model
{
    use HasFactory;

    public $table = 'onboarding';

    public $timestamps = false;

    protected $fillable = [
        'candidate_id',
        'interivew_id',
        'resource_id',
        'resource_detail_id',
        'name',
        'gender',
        'address',
        'country',
        'province',
        'city',
        'zipcode',
        'place_of_birth',
        'date_of_birth',
        'blood_type',
        'religion',
        'home_phone',
        'mobile_phone',
        'number_id',
        'number_tax',
        'laptop',
        'join_date',
        'start_contract',
        'end_contract',
        'description',
        'status',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by'
    ];
    
    public function resource()
    {
        return $this->hasOne(Resource::class, 'id', 'resource_id');
    }

    public function resourceDetail()
    {
        return $this->hasOne(ResourceDetail::class, 'id', 'resource_detail_id');
    }

    


}
