<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignTodo extends Model
{
    use HasFactory;

    public $table = 'assign_todo';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'user_id',
        'user_name',
        'action_id',
        'title',
        'description',
        'status',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by',
    ];
   
}
