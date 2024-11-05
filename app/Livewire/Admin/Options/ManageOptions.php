<?php

namespace App\Livewire\Admin\Options;

use App\Models\Option;
use Livewire\Component;

class ManageOptions extends Component
{

    public $options;

    //Variable para la nueva opción a crear
    public $newOption = [
        'name' => '',
        'type' => 1,
        'features' => [
            [
                'value' => '',
                'descpription' => ''
            ]
        ]
    ];

    public $openModal = false;

    public function mount(){
        
        $this->options = Option::with('features')->get();

    }

    

    public function addFeature(){
        $this->newOption['features'][] = [
            'value' => '',
            'description' => '',
        ];
    }

    public function removeFeature($index){

        //eliminar el array de acuerdo al indice recibido
        unset($this->newOption['features'][$index]);

        //Restablecer los indices creando un nuevo array con los valores restantes y lo establece como valor en el campo features
        $this->newOption['features'] = array_values($this->newOption['features']);

    }

    public function addOption(){
        $rules = [
            'newOption.name' => 'required',
            'newOption.type' => 'required|in:1,2',
            'newOption.features' => 'required|array|min:1',
        ];

        foreach($this->newOption['features'] as $index => $feature){

            if($this->newOption['type'] == 1){

                //El tipo es texto
                $rules['newOption.features.'.$index.'.value'] = 'required';

            }else{

                //El tipo es color
                $rules['newOption.features.'.$index.'.value'] = 'required|regex:/^#[a-f0-9]{6}$/i';

            };

            $rules['newOption.features.'.$index.'.description'] = 'required|max:255';
        };

        $this->validate($rules);

        //Crear la opcion
        $option = Option::create([
            'name' => $this->newOption['name'],
            'type' => $this->newOption['type'],
        ]);

        //Crear los valores (features)
        foreach($this->newOption['features'] as $feature){
            $option->features()->create([
                'value' => $feature['value'],
                'description' => $feature['description'],
            ]);
        }

        $this->options = Option::with('features')->get();

        $this->reset('openModal', 'newOption');

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
