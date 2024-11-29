<div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">Estadísticas de clics por categoría</h2>

    <!-- Si no hay datos, mostrar un mensaje -->
    @if(empty($datosGrafica))
        <p class="text-center text-gray-500">No se han registrado clics aún.</p>
    @else
        <!-- Tabla que muestra las estadísticas -->
        <table class="min-w-full table-auto border-collapse mb-6">
            <thead>
                <tr>
                    <th class="border px-4 py-2 text-left">Categoría</th>
                    <th class="border px-4 py-2 text-left">Número de Clics</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datosGrafica as $dato)
                    <tr>
                        <td class="border px-4 py-2">{{ $dato['label'] }}</td>
                        <td class="border px-4 py-2">{{ $dato['value'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Gráfica de barras -->
        <div class="mb-8">
            <canvas id="myChart"></canvas>
        </div>

        <!-- Gráfica de torta -->
        <div>
            <h3 class="text-xl font-semibold mb-4">Distribución de Noticias por Diario</h3>
            <canvas id="graficaTorta"></canvas>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/wordcloud@1.1.1/wordcloud.min.js"></script>

        <script>
            // Gráfico de barras
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar', // Tipo de gráfico
                data: {
                    labels: @json($labels), // Etiquetas (categorías)
                    datasets: [{
                        label: 'Número de Scrapes por Categoría',
                        data: @json($data), // Los datos (conteo de scrapes)
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Color de fondo
                        borderColor: 'rgba(75, 192, 192, 1)', // Color de borde
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Gráfico de torta
            var tortaCtx = document.getElementById('graficaTorta').getContext('2d');
            var graficaTorta = new Chart(tortaCtx, {
                type: 'pie',
                data: {
                    labels: @json($labelsDiarios),  // Etiquetas de las categorías (diarios)
                    datasets: [{
                        label: 'Noticias por Diario',
                        data: @json($dataDiarios), // Número total de noticias por diario
                        backgroundColor: @json($this->generarColores(count($dataDiarios))), // Colores dinámicos para cada categoría
                        borderColor: @json($this->generarColores(count($dataDiarios), true)), // Colores de borde
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let label = context.label || '';
                                    let value = context.raw || 0;
                                    return `${label}: ${value} noticias`; // Mostrar el número de noticias en el tooltip
                                }
                            }
                        }
                    }
                }
            });

        </script>
<div id="wordCloudCanvas"></div>

<script>
    var wordCloudData = @json($wordCloudData ?: []); // Si está vacío, pasar un array vacío

    console.log(wordCloudData); // Verificar que los datos estén bien formateados

    if (wordCloudData.length > 0) {
        WordCloud(document.getElementById('wordCloudCanvas'), {
            list: wordCloudData.map(function (item) {
                return [item.text, item.weight]; // La estructura que requiere la librería
            }),
            gridSize: 18,
            weightFactor: 10,
            fontFamily: 'Arial',
            color: 'random-light',
            rotateRatio: 0.5,
            rotationSteps: 4
        });
    } else {
        console.log('No hay datos para mostrar en la nube de palabras');
    }
</script>




    @endif
</div>
