<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
// use App\Models\Company;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $projects=Project::all();
        $projects=Project::orderBy('created_at','desc')->get();
        $user=auth()->user();
        return view('Project.index', compact('projects', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 以下追加
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //追加する バリエーション
        $inputs=request()->validate([
        // $inputs=$request->validate([
            'title'=>'required|max:255',
            'content'=>'required|max:1000',
            'image'=>'image|max:1024'
        ]);

        // データ取得
        $project=new Project();
        $project->title=$request->title;
        $project->content=$request->content;
        $project->user_id=auth()->user()->id;
        
        // company_id とcategory_idは一時敵にuser_idにする
        $project->company_id=auth()->user()->id;
        $project->category_id=auth()->user()->id;

        // $project->category_id=->$request->category_id;

        // 画像保存
        
        if (request('image')){
            $original = request()->file('image')->getClientOriginalName();
            // 日時追加
            $name = date('Ymd_His').'_'.$original;

            request()->file('image')->move('storage/images', $name);
            // 別の保存メソッド
            // request()->file('image')->storeAs('public/images', $name);

            $project->image = $name;
        }
        $project->save();
        return redirect()->route('project.create')->with('message', '新規案件を作成しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //以下追加
        return view('project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //以下追加
        return view('project.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //以下追加
        $inputs=$request->validate([
            'title'=>'required|max:255',
            'content'=>'required|max:1000',
            'image'=>'image|max:1024'
        ]);

        $project->title=$request->title;
        $project->content=$request->content;
                
        if(request('image')){
            $original=request()->file('image')->getClientOriginalName();
            $name=date('Ymd_His').'_'.$original;
            $file=request()->file('image')->move('storage/images', $name);
            $project->image=$name;
        }

        $project->save();

        return redirect()->route('project.show', $project)->with('message', '案件を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //以下追加
        $project->delete();
        return redirect()->route('project.index')->with('message', '投稿を削除しました');
    }
}
