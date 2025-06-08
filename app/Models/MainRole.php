<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MainRole extends Model
{
      use HasFactory;

    public $table = 'main_role';

    public $timestamps = false;

    protected $fillable = [
        'name_role',
    ];

    public function user(){
         return $this->hasOne(User::class, 'role_id', 'id');
    }

}
