@inject('carbon', 'Carbon\Carbon')
<x-index-layout>
<div class="flex gap-4 justify-center mb-8">
    @foreach ($categories as $category)
        <div class="border-b-4 hover:border-b-yellow-400 font-bold">
            <a href="{{route('posts.search',$category)}}">{{$category->name}}</a>
        </div>
    @endforeach
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
    @foreach ($posts as $post)
    <a href="{{route('posts.show',$post)}}" class="relative p-6 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
        <div class="absolute left-0 top-0 bg-indigo-600 text-white rounded-tl-lg py-1 px-2 text-sm">
            {{$post->category->name}}
        </div>
        <div class="flex">
            <div class="bg-slate-50 flex items-center justify-center">
                <img src="@if ($post->image) {{Storage::url($post->image->url)}}
                @endif" alt="">
            </div>
            <div class="w-80 ml-4">
                <h2 class="mt-6 text-xl font-semibold text-gray-900">{{$post->name}}</h2>
                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                    {{$post->extract}}
                </p>
            </div>
        </div>
        <div class="text-right">
            <p class="text-xs text-gray-400">Publicado: {{ $carbon::parse($post->updated_at)->diffForHumans() }}</p>
        </div>
    </a>
    @endforeach
</div>
</x-index-layout>
