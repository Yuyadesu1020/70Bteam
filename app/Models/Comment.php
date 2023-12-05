<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    //✅タスクモデル・ユーザーモデルとのリレーションを記述
    public function task()
    {
        return $this -> belongsTo('App\Models\Task');
    }

    public function user()
    {
        return $this -> belongsTo('App\Models\User');
    }
}
