<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            新規投稿の作成
        </h2>
            {{-- バリエーションエラー表示 --}}
            {{-- <x-input-error class="mb-4" :messages="$errors->all()"/> --}}
        <x-validation-errors class="mb-4" :messages="$errors->all()"/>

            {{-- 投稿後のメッセージ 装飾無 --}}
            {{-- @if(session('message'))
            {{session('message')}}
            @endif --}}
    
            {{-- 投稿後のメッセージ 装飾有り message.php message.blade.php --}}
        <x-message :message="session('message')" />
    
            {{-- 匿名コンポーネントバージョン --}}
            {{-- <x-amessage :message="session('message')" /> --}}

    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <form method="post" action="{{route('post.store')}}" enctype="multipart/form-data">
            @csrf
                <div class="md:flex items-center mt-8">
                    <div class="w-full flex flex-col">
                    <label for="title" class="font-semibold leading-none mt-4">件名</label>
                    <input type="text" name="title" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="title" placeholder="Enter Title">
                    </div>
                </div>

                <div class="w-full flex flex-col">
                    <label for="body" class="font-semibold leading-none mt-4">本文</label>
                    <textarea name="body" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="body" cols="30" rows="10"></textarea>
                </div>

                <div class="w-full flex flex-col">
                    <label for="pic" class="font-semibold leading-none mt-4">画像 (1MBまで) </label>
                    <div>
                        <input id="pic" type="file" name="pic">
                    </div>
                </div>

                <x-primary-button class="mt-4">
                    送信する
                </x-primary-button>
                
            </form>
        </div>
    </div>
    
</x-app-layout>
