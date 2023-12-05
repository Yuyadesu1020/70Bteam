<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //
    public function create($task_id)
    {
        $task = Task::find($task_id);
        return view('show', compact('task'));
    }

    public function store(Request $request)
    {
        $task = Task::find($request -> task_id);
        $comment = new Comment;
        $comment -> body = $request -> body;
        $comment -> user_id = Auth::id();
        $comment -> task_id = $request -> task_id;
        $comment -> save();
        //return view('posts.show', compact('post'));
        return redirect() -> route('tasks.show', $task -> id);

        // if (!$task) {
        //     // タスクが存在しない場合の処理
        //     abort(404); // 例として404エラーを返す
        // }
    }
    
}
