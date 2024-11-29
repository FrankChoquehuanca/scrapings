<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;

class CrudPapeleta extends Component
{
    public $pais="ar", $ciudad;
        #[Url()]
    public $companies = [];


    public function save()
    {
        dump($this->pais);
        dump($this->companies);
    }


    public function render()
    {
        return view('livewire.crud-papeleta');
    }
}
