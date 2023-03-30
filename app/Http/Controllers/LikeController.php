<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use宣言追加
use App\Models\Project;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Project $project, Request $request){
        $like=New Like();
        $like->project_id=$project->id;
        $like->user_id=Auth::user()->id;
        $like->save();
        return back();
    }

    public function unlike(Project $project, Request $request){
        $user=Auth::user()->id;
        $like=Like::where('Project_id', $project->id)->where('user_id', $user)->first();
        $like->delete();
        return back();
    }
}
