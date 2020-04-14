<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDownRecord extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'down_type', 'down_id',
    ];
}
