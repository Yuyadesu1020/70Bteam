<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class LikeController extends Controller
{
    //
    function store(Request $request)
    {
        $like = new Like();
        $like->task_id = $request->task_id;
        $like->user_id = Auth::user()->id;
        $like->save();

        return redirect('/show');
    }

    function destroy(Request $request)
    {
        $like = Like::find($request->like_id);
        $like->delete();

        return redirect('/show');
    }
}
