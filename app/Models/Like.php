<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // public function task()
    // {
    //     return $this->belongsTo('App\Models\Task');
    // }
}
