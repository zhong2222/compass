<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// 以下追加
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LikeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Auth::routes(['verify' => true]);
Route::get('/', function () {
    return view('welcome');
})->name('top');

// お問い合わせ
Route::get('contact/create', [ContactController::class, 'create'])->name('contact.create');
Route::post('contact/store', [ContactController::class, 'store'])->name('contact.store');
// お問い合わせ 同じコントローラーを使う場合、次のように、コントローラーごとにまとめてルートを記述
// Route::controller(ContactController::class)->group(function(){
//     Route::get('contact/create', 'create')->name('contact.create');
//     Route::post('contact/store', 'store')->name('contact.store');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// laravelのprofile機能を無効する
// Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// ログイン後の通常のユーザー画面
    // Route::middleware(['auth'])->group(function(){
    //     // 参考用：ログイン済みのユーザーのみがアクセス可能 グループで一括ルート設定
    // });

// 以下、メール認証済みのユーザーのみがアクセス可能 グループで一括ルート設定
Route::middleware(['verified'])->group(function(){
    // 以下ルート追加 resourceコントローラールートの順番は最後に
    Route::post('post/comment/store', [CommentController::class, 'store'])->name('comment.store');
    Route::get('mypost', [PostController::class, 'mypost'])->name('post.mypost');
    Route::get('mycomment', [PostController::class, 'mycomment'])->name('post.mycomment');
    Route::resource('post', PostController::class);

    Route::get('project/like', [ProjectController::class, 'like'])->name('project.like');
    Route::resource('project', ProjectController::class);

    //プロフィール編集用ルート設定を追加
    Route::get('profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile/{user}', [ProfileController::class, 'update'])->name('profile.update');

    // 気になるボタン
    Route::get('project/like/{project}', [LikeController::class, 'like'])->name('like');
    Route::get('project/unlike/{project}', [LikeController::class, 'unlike'])->name('unlike');

    // 管理者用画面
    Route::middleware(['can:admin'])->group(function(){
        //ユーザ一覧
        Route::get('profile/index', [ProfileController::class, 'index'])->name('profile.index');
        Route::delete('profile/{user}', [ProfileController::class, 'delete'])->name('profile.delete');

        // 追加
        Route::patch('roles/{user}/attach', [RoleController::class, 'attach'])->name('role.attach');
        Route::patch('roles/{user}/detach', [RoleController::class, 'detach'])->name('role.detach');

    });
});

require __DIR__.'/auth.php';