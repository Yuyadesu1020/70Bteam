<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TaskController extends Controller
{
    //
    function index()
    {
        $tasks = Task::all();//tasksテーブルから全てのデータをとってくる
        return view('tasks.index',compact('task'));
    }

    function create()
    {
        return view('tasks.create');
    }

    function store(Request $request)//ブラウザから送られてくる情報を$requestに引き継いでる
    {
        // フォームから送信された画像を取得
        $image = $request->file('image');

        // 画像を保存するためのファイル名を作成
        $imageName = time() . '_' . $image->getClientOriginalName();

        // 画像をstorage/app/publicディレクトリに保存
        $image->storeAs('public/storage', $imageName);
        
        $task = new Task;
        $task->title = $request->title;
        $task->body = $request->body;
        $task->user_id = Auth::id();
        $task->file_name = $imageName;//画像のファイル名を保存
        $task->file_path = 'storage/' . $imageName;//画像の保存パスを保存

        $task->save();
        return redirect()->route('tasks.index');
    }

    function show($id)
    {

    }

    function edit($id)
    {

    }

    function update(Request $request)
    {

    }

    function destroy($id)
    {
        
    }

    function uploadImage(Request $request,$task_id)
    {
        
    }
}
