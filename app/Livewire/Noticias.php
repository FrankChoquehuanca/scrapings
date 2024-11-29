<?php

namespace App\Livewire;

use App\Models\EstadisticaScraping;
use Livewire\Component;
use App\Models\Noticia;
use Illuminate\Support\Facades\Artisan;

class Noticias extends Component
{
    public $noticias;
    public $categoriaSeleccionada = null; // Almacena la categoría seleccionada

    public function mount()
    {
        $this->loadNoticias();
    }

    // Método para cargar las últimas noticias
    public function loadNoticias($categoria = null)
    {
        if ($categoria) {
            // Si se pasa una categoría, muestra todas las noticias de esa categoría
            $this->noticias = Noticia::where('category', $categoria)->latest()->get();
        } else {
            // Si no se pasa una categoría, muestra todas las noticias sin filtro
            $this->noticias = Noticia::latest()->get();
        }
    }


    // Método para scraping y mostrar noticias por categoría
    public function scrapeAndShow($categoria)
    {
        $categorias = [
            'sin-fronteras' => 'scrape:noticias --sin-fronteras',
            'exitosa' => 'scrape:noticias --exitosa-noticias',
            'la-republica' => 'scrape:noticias --la-republica',
            'correo' => 'scrape:noticias --correo',
            'ojo' => 'scrape:noticias --ojo',
            'latina' => 'scrape:noticias --latina',
        ];

        // Ejecutar el comando de scraping según la categoría
        if (array_key_exists($categoria, $categorias)) {
            Artisan::call($categorias[$categoria]);
        }

        // Actualizar la estadística de la categoría
        $estadistica = EstadisticaScraping::firstOrCreate(['categoria' => $categoria]);
        $estadistica->increment('veces_scrapeado', 1);

        // Cargar las noticias filtradas por la categoría
        $this->categoriaSeleccionada = $categoria;
        $this->loadNoticias($categoria);

        session()->flash('message', "Scraping de {$categoria} completado.");
    }

    protected function registrarClick($categoria)
    {
        // Buscar el registro de la categoría
        $categoriaPreferida = \App\Models\CategoriaPreferida::where('categoria', $categoria)->first();

        if ($categoriaPreferida) {
            // Si el registro existe, incrementar los clics
            $categoriaPreferida->increment('clicks');
        } else {
            // Si no existe, crear un nuevo registro con 1 clic
            \App\Models\CategoriaPreferida::create([
                'categoria' => $categoria,
                'clicks' => 1,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.noticias', [
            'noticias' => $this->noticias,
            'categoriaSeleccionada' => $this->categoriaSeleccionada,
        ]);
    }
}
