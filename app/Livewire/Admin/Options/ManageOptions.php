<?php

namespace App\Livewire\Admin\Options;

use App\Livewire\Forms\Admin\Options\NewOptionForm;
use App\Models\Option;
use Livewire\Component;

class ManageOptions extends Component
{

    public $options;

    //Variable para la nueva opción a crear
    public NewOptionForm $newOption;

    public function mount(){
        
        $this->options = Option::with('features')->get();

    }

    

    public function addFeature(){
        
        $this->newOption->addFeature();

    }

    public function removeFeature($index){

        $this->newOption->removeFeature($index);

    }

    public function addOption(){

        //ejecutar el metodo save definido en el formOption
        $this->newOption->save();

        $this->options = Option::with('features')->get();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Bien Hecho',
            'text' => 'Opción agregada correctamente'
        ]);

    }

    public function render()
    {
        return view('livewire.admin.options.manage-options');
    }
}
