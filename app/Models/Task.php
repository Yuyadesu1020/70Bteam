<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    function user()
    {
        return $this->belongsTo('App\Models\User');//taskというモデルはUserが親
    }

    function likes()
    {
        return $this->hasMany('App\Models\Like');//taskはLikeをたくさん持つよ
    }

    function likedBy($user)
    {
        return Like::where('user_id',$user->id)->where('task_id',$this->id);
    }

}
