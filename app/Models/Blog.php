<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
   
    protected $fillable = [
        'title', 'description',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public static function getDetail($id) {
        $post = static::where("id", $id)->first();
        return $post;
    }

}
