<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\Role;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //プロフィール一覧
    public function index() {
        $users = User::all();
        return view('profile.index', compact('users'));
    }

    //プロフィール編集
    public function edit(User $user) {
        // police適用
        $this->authorize('update', $user);
        // 役割
        $roles=Role::all();
        return view('profile.edit', compact('user', 'roles'));

        return view('profile.edit', compact('user'));
    }

    public function update(User $user, Request $request){
        $this->authorize('update', $user);

    // バリデーション
    $inputs=request()->validate([
        'name'=>'required|max:255',
        'email'=>['required','email','max:255', Rule::unique('users')->ignore($user->id)],
        'icon'=>'image|max:1024',
        'password'=>'nullable|max:255|min:8',
        'password_confirmation'=>'nullable|same:password'
    ]);

    //パスワードの設定
    if(!isset($inputs['password'])) {
        unset($inputs['password']);
    }else{
        $inputs['password'] = Hash::make($inputs['password']);
    }

    // iconの保存
    // 古いicon画像を削除
    if(isset($inputs['icon'])) {
        if ($user->icon!=='user_default.jpg') {
            $oldicon='public/icon/'.$user->icon;
            Storage::delete($oldicon);
        }
        $name=request()->file( 'icon')->getClientOriginalName();
        $icon=date('Ymd_His').'_'.$name;
        request()->file( 'icon')->storeAs('public/icon', $icon);
        $inputs['icon'] = $icon;
    }
    $user->update($inputs);
    return back()->with('message', '情報を更新しました');
    }

    public function delete(User $user) {
        $user->roles()->detach();
        if($user->icon!=='user_default.jpg') {
            $oldicon='public/icon/'.$user->icon;
            Storage::delete($oldicon);
        }
        $user->delete();
        return back()->with('message', 'ユーザーを削除しました');
    }
}
