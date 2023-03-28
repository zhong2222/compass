<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
         //icon用
        'icon'=>['image', 'max:1024'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],            
        ]);

        // userテーブルのデータ
        $attr =[
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        //iconの保存
        if(request()->hasFile('icon')) {
            $name = request()->file('icon')->getClientOriginalName();
            $icon = date('Ymd_His').'_'.$name;
            request()->file('icon')->storeAs('public/icon', $icon);
            //iconファイル名をデータに追加
            $attr['icon']=$icon;
        }

        $user=User::create($attr);

        event(new Registered($user));

        // 役割付与 一般ユーザー＝２
        $user->roles()->attach(2);

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

}

