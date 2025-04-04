<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notifications extends Model
{
    use HasFactory;

    public $table = 'notifications';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'user_id',
        'user_name',
        'action_id',
        'title',
        'description',
        'isRead',
        'status',
        'created_date',
        'created_id',
        'created_by',
        'updated_date',
        'updated_id',
        'updated_by',
    ];
}
