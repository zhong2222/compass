<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            案件概要
        </h2>
        
        <x-validation-errors class="mb-4" :messages="$errors->all()"/>
        <x-message :message="session('message')" />

    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <div class="px-10 mt-4">

                <div class="bg-white w-full  rounded-2xl px-10 py-8 shadow-lg hover:shadow-2xl transition duration-500">
                    <div class="mt-4">
                        <h1 class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer">
                            <a href="{{route('project.show', $project)}}">{{ $project->title }}</a>
                        </h1>
                        <hr class="w-full">
                    </div>

                    @can('admin')
                    <div class="flex justify-end mt-4">
                        <a href="{{route('project.edit', $project)}}"><x-primary-button class="bg-teal-700 float-right">編集</x-primary-button></a>
                        <form method="post" action="{{route('project.destroy', $project)}}">
                            @csrf
                            @method('delete')
                            <x-primary-button class="bg-red-700 float-right ml-4" onClick="return confirm('本当に削除しますか？');">削除</x-primary-button>
                        </form>
                    </div>
                    @endcan

                    {{-- レイアウト調整 --}}
                    <div>
                        <p class="mt-4 text-gray-600 py-4">{{$project->content}}</p>
                        @if($project->image)
                            {{-- <div>
                                (画像ファイル：{{$project->image}})
                            </div> --}}
                            <img src="{{ asset('storage/images/'.$project->image)}}" class="mx-auto" style="height:300px;">
                        @endif
                        <div class="text-sm font-semibold flex flex-row-reverse">
                            <p> {{ $project->company_id}} ★ {{$project->created_at->format('Y/m/d')}}</p>
                        </div>
                    </div>
                    {{-- レイアウト調整 --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>