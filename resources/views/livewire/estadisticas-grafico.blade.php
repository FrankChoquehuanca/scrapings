<div>
    <canvas id="myChart"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',  // Tipo de gráfico
            data: {
                labels: @json($labels),  // Etiquetas (categorías)
                datasets: [{
                    label: 'Número de Scrapes por Categoría',
                    data: @json($data),  // Los datos (conteo de scrapes)
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',  // Color de fondo
                    borderColor: 'rgba(75, 192, 192, 1)',  // Color de borde
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
    </script>
</div>
