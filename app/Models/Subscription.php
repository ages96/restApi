<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
   
    protected $fillable = [
        'email', 'sent',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

}
