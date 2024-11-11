<?php

namespace App\Livewire\Admin\Options;

use App\Livewire\Forms\Admin\Options\NewOptionForm;
use App\Models\Feature;
use App\Models\Option;
use Livewire\Attributes\On;
use Livewire\Component;

class ManageOptions extends Component
{

    public $options;

    //Variable para la nueva opción a crear
    public NewOptionForm $newOption;

    public function mount(){
        
        $this->options = Option::with('features')->get();

    }

    #[On('featureAdded')]
    public function updateOptionList(){

        //Cargar las opciones nuevamente, para que se actualice cuando se agrega un feature
        $this->options = Option::with('features')->get();

    }

    //Añadir un nuevo array en el array features
    public function addFeature(){
        
        $this->newOption->addFeature();

    }



    //Funcion que va en el modal al estar creando una opcion
    public function removeFeature($index){

        $this->newOption->removeFeature($index);
        $this->options = Option::with('features')->get();

    }

    public function deleteFeature(Feature $feature){

        $feature->delete();

    }

    public function deleteOption(Option $option){

        $option->delete();
        $this->options = Option::with('features')->get();

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
