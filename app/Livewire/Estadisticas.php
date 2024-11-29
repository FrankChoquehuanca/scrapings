<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\EstadisticaScraping;
use App\Models\Noticia;

class Estadisticas extends Component
{
    public $datosGrafica = [];
    public $labels;
    public $labelsDiarios;
    public $dataDiarios;
    public $wordCloudData = [];
    public $data;

    public function mount()
    {
        // Cargar los datos de las estadísticas
        $estadisticas = EstadisticaScraping::all();
        $this->labels = $estadisticas->pluck('categoria')->toArray();
        $this->data = $estadisticas->pluck('veces_scrapeado')->toArray();

        // Cargar los datos de la gráfica de torta
        $this->cargarDatosGrafica();
        $this->cargarDatosGraficaDiarios();

        // Cargar los datos de la nube de palabras
        $this->cargarDatosNubePalabras();
    }


    public function cargarDatosGrafica()
    {
        // Obtener los datos de las estadísticas
        $estadisticas = EstadisticaScraping::select('categoria', 'veces_scrapeado')
            ->get();

        // Formatear los datos para la gráfica
        $this->datosGrafica = $estadisticas->map(function ($item) {
            return [
                'label' => ucfirst(str_replace('-', ' ', $item->categoria)),
                'value' => $item->veces_scrapeado,
            ];
        });
    }

    public function cargarDatosGraficaDiarios()
    {
        // Obtener los datos de noticias por diario (categoría)
        $estadisticasDiarios = Noticia::select('category', DB::raw('COUNT(*) as total_noticias'))
            ->groupBy('category') // Agrupar por categoría (diario)
            ->get();

        // Formatear los datos para la gráfica de torta
        $this->labelsDiarios = $estadisticasDiarios->pluck('category')->toArray();  // Obtener los nombres de los diarios (categorías)
        $this->dataDiarios = $estadisticasDiarios->pluck('total_noticias')->toArray();  // Obtener la cantidad total de noticias por cada diario
    }

    public function generarColores($cantidad, $esBorde = false)
    {
        $colores = [
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            // Agrega más colores si es necesario
        ];

        $coloresDeBorde = [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            // Agrega más colores si es necesario
        ];

        // Ajusta el tamaño del arreglo si la cantidad de datos supera el número de colores
        $colores = array_pad($colores, $cantidad, $colores[0]);
        $coloresDeBorde = array_pad($coloresDeBorde, $cantidad, $coloresDeBorde[0]);

        return $esBorde ? $coloresDeBorde : $colores;
    }
    public function cargarDatosNubePalabras()
    {
        // Obtener los títulos de las noticias
        $titulos = Noticia::pluck('titulo')->toArray();

        // Unir todos los títulos en un solo texto
        $texto = implode(" ", $titulos);

        // Procesar las palabras y contar su frecuencia
        $wordFrequency = $this->getWordFrequency($texto);

        // Convertir las frecuencias en el formato que WordCloud.js necesita
        $this->wordCloudData = array_map(function ($word, $count) {
            return ['text' => $word, 'weight' => $count];
        }, array_keys($wordFrequency), $wordFrequency);

        // Verifica si los datos están correctos
        // dd($this->wordCloudData);
    }


    private function getWordFrequency($texto)
    {
        // Eliminar caracteres especiales y convertir el texto a minúsculas
        $texto = mb_strtolower($texto); // Convertir a minúsculas para hacer la comparación insensible al caso
        $texto = preg_replace('/[^a-zA-Z0-9áéíóúüñ\s]/', '', $texto); // Mantener letras, números y acentos

        // Dividir el texto en palabras
        $palabras = preg_split('/\s+/', $texto);

        // Contar la frecuencia de cada palabra
        $wordFrequency = array_count_values($palabras);

        // Filtrar palabras comunes, como artículos o preposiciones
        $palabrasComunes = ['el', 'la', 'de', 'y', 'a', 'en', 'que', 'los', 'las', 'un', 'una', 'del', 'con']; // Personaliza esta lista si es necesario
        $wordFrequency = array_diff_key($wordFrequency, array_flip($palabrasComunes));

        // Ordenar las palabras por frecuencia
        arsort($wordFrequency);

        return $wordFrequency;
    }

    public function render()
    {
        return view('livewire.estadisticas', [
            'wordCloudData' => $this->wordCloudData
        ]);
    }
}
