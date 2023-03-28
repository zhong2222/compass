<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            案件編集
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
                {{-- <form enctype="multipart/form-data"> --}}
                <form method="post" action="{{route('project.update',$project)}}"
                    enctype="multipart/form-data">
                    @csrf 
                    @method('patch')
                
                    <div class="md:flex items-center mt-8">
                        <div class="w-full flex flex-col">
                        <label for="title" class="font-semibold leading-none mt-4">案件名</label>
                        <input type="text" name="title" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="title" value="{{old('title', $project->title)}}" placeholder="Enter Title">
                        </div>
                    </div>

                    <div class="w-full flex flex-col">
                        <label for="content" class="font-semibold leading-none mt-4">案件概要</label>
                        <textarea name="content" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="content" cols="30" rows="10"> {{old('body', $project->content)}} </textarea>
                    </div>

                    {{-- カテゴリを候補から選択 --}}
                    {{-- <div class="w-full flex flex-col">
                        <label for="category" class="font-semibold leading-none mt-4">カテゴリ</label>
                        <input type="text" name="category" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="title" placeholder="Enter Title">
                    </div> --}}

                    @if($project->image)
                    <img src="{{ asset('storage/images/'.$project->image)}}" class="mx-auto" style="height:300px;">
                    @endif

                    <label for="image" class="font-semibold leading-none mt-4">画像(1MBまで) </label>
                    <div>
                        <input id="image" type="file" name="image">
                    </div>
                
                    <x-primary-button class="mt-4">
                        更新する
                    </x-primary-button>
                    
                </form>
            </div>
        </div>
        
</x-app-layout>