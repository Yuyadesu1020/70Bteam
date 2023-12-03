<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use Illuminate\Auth\Events\Validated;

class TaskController extends Controller
{
    //
    // latest() -> 

    function index(Request $request)
    {
        $tasks = Task::simplepaginate(4);//tasksテーブルから全てのデータをとってくる

        return view('tasks.index',compact('tasks'));
    }

    function create()
    {
        $task = new Task;

        return view('tasks.create', compact('task'));
    }

    function store(Request $request)
    {
        // $validated = $request->validate([
        //     'title' => 'required|unique:tasks|max:200',
        //     'body' => 'required',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        
        // ],[
        //     'title.required'=> 'Inform your title',
        //     'title.unique' => 'This title exists',
        //     'title.max' => 'Your title need to be under 200',
        //     'body.required' => 'Inform your content',
        // ]);

        $validated = $request->validate([
            'title' => 'required|unique:tasks|max:200',
            'body' => 'required',
            'postimage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // postimageを追加して画像が選択されていなくても良いことを示す
        ],[
            'title.required'=> 'Inform your title',
            'title.unique' => 'This title exists',
            'title.max' => 'Your title needs to be under 200',
            'body.required' => 'Inform your content',
        ]);
        

    $task = new Task;

    // フォームから送信された画像を取得
    $image = $request->file('postimage'); // ファイル名を修正
    if ($image) {
        // 画像を保存するためのファイル名を作成
        $imageName = time() . '_' . $image->getClientOriginalName();
        // 画像を public/storage/images ディレクトリに保存
        // $image->move(public_path('/storage/images'), $imageName);
        $image->storeAs('public/images', $imageName);
        $task->file_name = $imageName; // 画像のファイル名を保存
        $task->file_path = 'storage/images/' . $imageName; // 画像の保存パスを保存   
    }
    // else{
    //     $task->file_name = null;
    //     $task->file_path = null;
    // }
        $task->title = $request->title;
        $task->body = $request->body;
        $task->user_id = Auth::id();
        $task->save();

    return redirect()->route('tasks.index'); 
    }

    function show($id)
    {
        $task = Task::find($id);

        return view('tasks.show',compact('task'));
    }

    function edit($id)
    {
        $task = Task::find($id);

        return view('tasks.edit',compact('task'));
    }

    function update(Request $request,$id)
    {
        $task = Task::find($id);

        $task->title = $request->title;
        $task->body = $request->body;
        //$task->file_name = $task->file_path;

        // 新しい画像が送信されたかどうかを確認
    if ($request->hasFile('newImage')) {
        // 既存の画像をストレージから削除する場合はここで行う

        // 新しい画像を取得して保存する
        $image = $request->file('newImage');
        $newImageName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('public/images', $newImageName);

        // 画像パスを更新する
        $task->file_name = $newImageName;
        $task->file_path = 'storage/images/' . $newImageName;
    }

        $task->save();

        return redirect()->route('tasks.index');
    }

    function destroy($id)
    {
        $task = Task::find($id);

        $task->delete();

        return redirect()->route('tasks.index');
    }


    function uploadImage(Request $request, $task_id)
    {
        // タスクを取得
        $task = Task::find($task_id);

        // フォームから送信された画像を取得
        $image = $request->file('image');

        if ($image) {
            // 画像を保存するためのファイル名を作成
            $imageName = time() . '_' . $image->getClientOriginalName();

            // 画像を public/storage/images ディレクトリに保存
            $image->storeAs('public/images', $imageName);

            // 以前の画像が存在する場合は削除する（オプション）
            if ($task->file_name) {
                Storage::delete('public/images/' . $task->file_name);
            }

            // タスクの画像情報を更新
            $task->file_name = $imageName;
            $task->file_path = 'storage/images/' . $imageName;
            $task->save();
        }

        return redirect()->route('tasks.index');
    }

}
