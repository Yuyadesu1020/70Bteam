<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TaskController extends Controller
{
    //
    function showTimelinePage()
    {
        $tweets=Tweet::latest()->simplepaginate(3);//0の方に最新のデータをとってくる
        return view('timeline',['tweets'=>$tweets]);
    }

    function postTweet(Request $request)
    {
        $validator=$request->validate([
            'tweet'=>['required','string','max:280',]
        ]);
        Tweet::create([
            'user_id'=>Auth::user()->id,
            'tweet'=>$request->tweet,
        ]);
        return back();
    }

    function destroy($id)
    {
        $tweet=Tweet::find($id);
        $tweet->delete();

        return redirect()->route('timeline');
    }
}
