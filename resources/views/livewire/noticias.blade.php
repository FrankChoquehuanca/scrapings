<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans leading-tight">

    <!-- Contenedor principal -->
    <div class="container mx-auto p-6">

        <!-- Título de la página -->
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Noticias Recientes</h1>

        <!-- Filtros de noticias -->
        <div class="mb-8 flex justify-center gap-4">
            <button wire:click="scrapeAndShow('sin-fronteras')" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">Sin Fronteras</button>
            <button wire:click="scrapeAndShow('exitosa')" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">Exitosa Noticias</button>
            <button wire:click="scrapeAndShow('la-republica')" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">La República</button>
            <button wire:click="scrapeAndShow('correo')" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">Correo</button>
            <button wire:click="scrapeAndShow('ojo')" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">Ojo</button>
            <button wire:click="scrapeAndShow('latina')" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">Latina Noticias</button>
        </div>

        <!-- Mensaje si no hay noticias -->
        @if($noticias->isEmpty())
            <p class="text-center text-gray-500 text-xl">No hay noticias disponibles en este momento.</p>
        @else
            <!-- Grid de noticias responsivo -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($noticias as $noticia)
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out">

                        <!-- Imagen de la noticia -->
                        @if($noticia->imagen)
                            <img src="{{ $noticia->imagen }}" alt="{{ $noticia->titulo }}" class="w-full h-48 object-cover rounded-t-lg">
                        @else
                            <div class="w-full h-48 flex justify-center items-center bg-gray-200 rounded-t-lg">
                                <p class="text-center text-gray-500">Sin imagen disponible</p>
                            </div>
                        @endif

                        <!-- Contenido de la noticia -->
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3">
                                <a href="{{ $noticia->enlace }}" target="_blank" class="text-blue-600 hover:underline">{{ $noticia->titulo }}</a>
                            </h3>

                            <!-- Autor de la noticia -->
                            @if($noticia->autor)
                                <p class="text-gray-500 text-sm">Por: {{ $noticia->autor }}</p>
                            @else
                                <p class="text-gray-500 text-sm">Autor: Desconocido</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</body>
</html>
