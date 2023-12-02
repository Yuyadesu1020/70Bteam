<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //profileを考慮してないもの
    // function show($id)
    // {
    //     $user=User::find($id);

    //     return view('tasks.profile',['user'=>$user]);
    // }

    //profileを考慮したもの
    public function show($id)
    {
    $user = User::find($id);
    $tasks = $user->tasks; // あるいは適切なリレーションを使用して、ユーザーに関連するタスクを取得する方法を指定します。

    return view('tasks.profile', ['user' => $user, 'tasks' => $tasks]);
    }

    public function posts(User $user)
    {
        // ユーザーの投稿一覧を取得してビューに渡す例
        $tasks = $user->tasks()->paginate(10); // ユーザーのタスク一覧を取得
    
        return view('tasks.profile', [
            'user' => $user,
            'tasks' => $tasks, // $tasks をビューに渡す
        ]);
    }
}
