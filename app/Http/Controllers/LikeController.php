<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class LikeController extends Controller
{

    function store(Request $request)
{
    $like = new Like();
    $like->task_id = $request->task_id;
    $like->user_id = Auth::user()->id;
    $like->save();

    if ($request->has('from_index')) {
        return redirect()->route('tasks.index');
    } elseif ($request->has('from_show')) {
        return redirect()->route('tasks.show', ['id' => $like->task_id]);
    } else {
        return redirect()->route('tasks.profile', ['id' => $like->task_id]);
    }
}

function destroy(Request $request)
{
    $like = Like::find($request->like_id);
    $like->delete();

    if ($request->has('from_index')) {
        return redirect()->route('tasks.index');
    } elseif ($request->has('from_show')) {
        return redirect()->route('tasks.show', ['id' => $like->task_id]);
    } else {
        return redirect()->route('tasks.profile', ['id' => $like->task_id]);
    }
}

}
