<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            案件一覧
        </h2>

        <x-message :message="session('message')" />

    </x-slot>

    {{-- 案件一覧表示 --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{$user->name}}さん、こんにちは！
        @foreach ($projects as $project)
            <div class="mx-4 sm:p-8">
                <div class="mt-4">
                    <div class="bg-white w-full  rounded-2xl px-10 py-8 shadow-lg hover:shadow-2xl transition duration-500">
                        <div class="mt-4">
                            <h1 class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer  float-left pt-4">
                                <a href="{{route('project.show', $project)}}">{{ $project->title }}</a>
                            </h1>
                            <hr class="w-full">
                            <p class="mt-4 text-gray-600 py-4">{{Str::limit($project->content, 200, '...')}}</p>
                            <div class="text-sm font-semibold flex flex-row-reverse">
                                {{-- <p>{{ $project->company_id }} ☆ {{$project->created_at->format('Y/m/d')}}</p> --}}
                                <p>{{$project->created_at->format('Y/m/d')}}</p>
                            </div>
                        </div>
                    </div>
                    {{-- いいね数表示 --}}
                    @if ($project->likes->count())
                    <div class="float-right">
                        <div class="flex">
                            <img src="{{asset('img/like.png')}}" width="30px">
                            {{-- <span class="badge" > --}}
                                {{ $project->likes->count() }}
                            {{-- </span> --}}
                        </div>                               
                    </div>
                    @else
                    <div class="float-right"><img src="{{asset('img/unlike.png')}}" width="30px"> </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>