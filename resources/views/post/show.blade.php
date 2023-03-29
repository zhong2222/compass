<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            投稿内容
        </h2>
        
        <x-validation-errors class="mb-4" :messages="$errors->all()"/>
        <x-message :message="session('message')" />

    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <div class="px-10 mt-4">
                {{-- OLD --}}
                {{-- <div class="bg-white w-full  rounded-2xl px-10 py-8 shadow-lg hover:shadow-2xl transition duration-500">
                    <div class="mt-4">
                        <h1 class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer">
                        <a href="{{route('post.show', $post)}}">{{ $post->title }}</a>
                        </h1> --}}
                {{-- OLD --}}

                {{-- 修正部分 --}}
                <div class="bg-white w-full  rounded-2xl px-10 pt-2 pb-8 shadow-lg hover:shadow-2xl transition duration-500">
                    <div class="mt-4">
                        <div class="flex">
                            <div class="rounded-full w-12 h-12">
                                {{-- icon表示 --}}
                                <img src="{{asset('storage/icon/'.($post->user->icon??'user_default.jpg'))}}">
                            </div>
                            <h1 class="text-lg text-gray-700 font-semibold float-left pt-4">
                                {{ $post->title }}
                            </h1>
                        </div>
                        {{-- 修正部分ここまで --}}

                        <hr class="w-full">
                    </div>
                    <div class="flex justify-end mt-4">

                        @can('update', $post)
                        <a href="{{route('post.edit', $post)}}"><x-primary-button class="bg-blue-600 float-right">編集</x-primary-button></a>
                        @endcan

                        @can('delete',$post)
                        <form method="post" action="{{route('post.destroy', $post)}}">
                            @csrf
                            @method('delete')
                            <x-primary-button class="bg-red-400 float-right ml-4" onClick="return confirm('本当に削除しますか？');">削除</x-primary-button>
                        </form>
                        @endcan
                    
                    </div>
                    {{-- div 追加部分 --}}
                    <div>
                        <p class="mt-4 text-gray-600 py-4">{{$post->body}}</p>
                        @if($post->pic)
                            <div>
                                (画像ファイル：{{$post->pic}})
                            </div>
                            <img src="{{ asset('storage/pics/'.$post->pic)}}" class="mx-auto" style="height:300px;">
                        @endif
                        <div class="text-sm font-semibold flex flex-row-reverse">
                            <p> {{ $post->user->name??'削除されたユーザー'}} ☆ {{$post->created_at->format('Y/m/d')}}</p>
                        </div>
                    </div>
                    {{-- /div 追加部分 --}}

                    {{-- コメント表示 --}}
                    @foreach ($post->comments as $comment)
                    <div class="bg-white w-full  rounded-2xl px-10 py-8 shadow-lg hover:shadow-2xl transition duration-500 mt-8">
                        {{$comment->body}}
                        <div class="text-sm font-semibold flex flex-row-reverse">
                            {{-- <p> {{ $comment->user->name }} • {{$comment->created_at->format('Y/m/d')}}</p> --}}
                            {{-- クラスを変更 --}}
                            <p class="float-left pt-4"> {{ $comment->user->name??'削除されたユーザー' }} ☆ {{$comment->created_at->format('Y/m/d')}}</p>
                            {{-- icon追加 --}}
                            <span class="rounded-full w-12 h-12">
                                <img src="{{asset('storage/icon/'.($comment->user->icon??'user_default.jpg'))}}">
                            </span>
                                                                        
                        </div>
                    </div>
                    @endforeach

                    {{-- コメント欄追加 --}}
                    <div class="mt-4 mb-12">
                        <form method="post" action="{{route('comment.store')}}">
                        @csrf
                            <input type="hidden" name='post_id' value="{{$post->id}}">
                            <textarea name="body" class="bg-white w-full  rounded-2xl px-4 mt-4 py-4 shadow-lg hover:shadow-2xl transition duration-500" id="body" cols="30" rows="3" placeholder="コメントを入力してください">{{old('body')}}</textarea>
                            <x-primary-button class="float-right mr-4 mb-12">コメントする</x-primary-button>
                        </form>
                    </div>
                    {{-- コメント欄追加 終わり --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
