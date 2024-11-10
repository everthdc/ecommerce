<?php

namespace App\Livewire\Admin\Options;

use Livewire\Component;

class AddNewFeature extends Component
{

    public $option;

    public $newFeature = [
        'value' => '',
        'description' => '',
    ];

    public function addFeature(){

        //Hacer la validacion
        $this->validate([

            'newFeature.value' => 'required',
            'newFeature.description' => 'required',

        ]);

        //Acceder a la relacion de la opcion y crear el feature
        $this->option->features()->create($this->newFeature);

        //Lanzar el evento para el componente padre, el cual actualizará la lista de opciones
        $this->dispatch('featureAdded');

        //Resetear la variable
        $this->reset('newFeature');

    }

    public function render()
    {
        return view('livewire.admin.options.add-new-feature');
    }
}
