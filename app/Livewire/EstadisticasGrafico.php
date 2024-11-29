<?php

namespace App\Livewire;

use App\Models\EstadisticaScraping;
use Livewire\Component;

class EstadisticasGrafico extends Component
{
    public $labels;
    public $data;

    public function mount()
    {
        // Obtener las categorías y sus conteos de scraping
        $estadisticas = EstadisticaScraping::all();

        $this->labels = $estadisticas->pluck('categoria')->toArray();
        $this->data = $estadisticas->pluck('veces_scrapeado')->toArray();
    }

    public function render()
    {
        return view('livewire.estadisticas-grafico');
    }
}
