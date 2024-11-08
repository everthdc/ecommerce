<?php

namespace App\Livewire\Forms\Admin\Options;

use App\Models\Option;
use Livewire\Attributes\Validate;
use Livewire\Form;

class NewOptionForm extends Form
{
    public $name;
    public $type = 1;
    public $features = [
        [
            'value' => '',
            'description' => '',
        ],
    ];

    public $openModal = false;

    public function rules()
    {
        //Establecer las reglas de validacion
        $rules = [
            'name' => 'required',
            'type' => 'required|in:1,2',
            'features' => 'required|array|min:1',
        ];

        //Agregar nuevas reglas de validacion para cada campo del array de los features
        foreach ($this->features as $index => $feature) {

            if ($this->type == 1) {

                //El tipo es texto
                $rules['features.' . $index . '.value'] = 'required';
            } else {

                //El tipo es color
                $rules['features.' . $index . '.value'] = 'required|regex:/^#[a-f0-9]{6}$/i';
            };

            $rules['features.' . $index . '.description'] = 'required|max:255';
        };

        return $rules;
    }

    public function validationAttributes(){

        $attributes = [
            'name' => 'nombre',
            'type' => 'tipo',
            'features' => 'valores',
            'features.*.value' => 'valor',
            'features.*.description' => 'description',
        ];

        foreach($this->features as $index => $feature){
            $attributes['features.'.$index.'.value'] = 'valor '. ($index + 1);
            $attributes['features.'.$index.'.description'] = 'descripcion '. ($index + 1);
        }

        return $attributes;

    }

    public function addFeature(){

        //Añadir un nuevo array en el array features
        $this->features[] = [
            'value' => '',
            'description' => '',
        ];
    }

    public function removeFeature($index){

        //eliminar el array de acuerdo al indice recibido
        unset($this->features[$index]);

        //Restablecer los indices creando un nuevo array con los valores restantes y lo establece como valor en el campo features
        $this->features = array_values($this->features);

    }

    public function save(){
        
        //Validar las reglas de la funcion rules()
        $this->validate();

        //Crear la opcion
        $option = Option::create([
            'name' => $this->name,
            'type' => $this->type,
        ]);

        //Crear los valores (features)
        foreach($this->features as $feature){
            $option->features()->create([
                'value' => $feature['value'],
                'description' => $feature['description'],
            ]);
        }

        //resetear las variables
        $this->reset();
    }
}
