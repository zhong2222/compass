<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Comment;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //追加する
        $posts=Post::orderBy('created_at','desc')->get();
        $user=auth()->user();
        return view('post.index', compact('posts', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //追加する
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //追加する
        $inputs=request()->validate([
        // $inputs=$request->validate([
            'title'=>'required|max:255',
            'body'=>'required|max:1000',
            'pic'=>'image|max:1024'
        ]);

        // データ取得
        $post=new Post();
        $post->title=$request->title;
        $post->body=$request->body;
        $post->user_id=auth()->user()->id;
        
        if (request('pic')){
            $original  = request()->file('pic')->getClientOriginalName();
            // 日時追加
            $name = date('Ymd_His').'_'.$original;
            request()->file('pic')->move('storage/pics', $name);
            $post->pic = $name;
        }

        $post->save();
        return redirect()->route('post.create')->with('message', '投稿しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //追加する
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //追加する
        // 修正できるユーザーのpolice適用
        $this->authorize('update', $post);
        
        // dd($post);  
        
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //追加する
        // 更新できるユーザーのpolice適用        
        $this->authorize('update', $post);

        $inputs=$request->validate([
            'title'=>'required|max:255',
            'body'=>'required|max:1000',
            'pic'=>'image|max:1024'
        ]);

        $post->title=$request->title;
        $post->body=$request->body;
                
        if(request('pic')){
            $original=request()->file('pic')->getClientOriginalName();
            $name=date('Ymd_His').'_'.$original;
            $file=request()->file('pic')->move('storage/pics', $name);
            $post->pic=$name;
        }

        $post->save();

        return redirect()->route('post.show', $post)->with('message', '投稿を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // 削除できるユーザーのpolice適用    
        $this->authorize('delete', $post);
        
        //postとcommentを一緒に削除する
        $post->comments()->delete();
        $post->delete();
        return redirect()->route('post.index')->with('message', '投稿を削除しました');
    }

    public function mypost() {
        $user=auth()->user()->id;

        // where：データベースの中から、条件に合うデータを取得
        // モデル名::where('テーブルのカラム名', 条件）->get();
        // なおgetではなくfirstを付けると、一番最初に出現したときの値を取ってきます。
        $posts=Post::where('user_id', $user)->orderBy('created_at', 'desc')->get();
        
        return view('post.mypost', compact('posts'));
    }

    public function mycomment() {

        $user=auth()->user()->id;
        $comments=Comment::where('user_id', $user)->orderBy('created_at', 'desc')->get();
        return view('post.mycomment', compact('comments'));
    }
}
