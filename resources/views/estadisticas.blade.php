<div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold">Estadísticas de clics por categoría</h2>
    <table class="min-w-full table-auto">
        <thead>
            <tr>
                <th class="border px-4 py-2">Categoría</th>
                <th class="border px-4 py-2">Número de Clics</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estadisticas as $estadistica)
                <tr>
                    <td class="border px-4 py-2">{{ $estadistica->categoria }}</td>
                    <td class="border px-4 py-2">{{ $estadistica->clicks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
