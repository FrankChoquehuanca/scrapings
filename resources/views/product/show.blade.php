<x-index-layout>

<div>
    <div class="border-y-2 border-indigo-600 py-3 font-bold">
         <h3> {{$post->category->name}}</h3>
    </div>
    <div>
        <h1 class="text-2xl font-bold py-6"> {{$post->name}}</h1>
   </div>
   <div class="grid grid-cols-3 gap-6 ">
    <div class="col-span-2">
        <div>
            <img src="@if ($post->image) {{Storage::url($post->image->url)}}
                @endif" alt="">
        </div>
        <div>
            <p class="border-y-2 border-indigo-600 border-dotted font-bold py-3 my-4">Publicado el:
                {{$post->created_at}}
            </p>
            <p class="text-sm">
                {{$post->body}}
            </p>
        </div>
   </div>


   <div>
        <h3 class="bg-indigo-600 text-white p-2">Ultimas Noticias</h3>
        @foreach ( $ultimas as $item)
        <a href="{{route('posts.show',$item)}}">
            <div class="grid grid-cols-2 my-4 border-b-2 border-indigo-600 pb-4">
                <div>
                    <img src="@if ($item->image) {{Storage::url($item->image->url)}}
                    @endif" alt="">
                </div>
                <div class="ml-4">
                    <h4>{{$item->name}}</h4>
                </div>
            </div>
        </a>
        @endforeach

   </div>
    </div>

</div>

</x-index-layout>
