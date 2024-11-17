<?php

namespace App\Livewire\Admin\Products;

use App\Models\Feature;
use App\Models\Option;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ProductVariants extends Component
{

    public $product;

    public $variant = [
        'option_id' => '',
        'features' => [
            [
                'id' => '',
                'value' => '',
                'description' => '',
            ]
        ],
    ];

    public $options;

    public $openModal = false;

    public function mount(){

        $this->options = Option::all();

    }

    //Resetear los campos cada que se cambia de opcion en el select
    public function updatedVariantOptionId(){

        $this->variant['features'] = [
            [
                'id' => '',
                'value' => '',
                'description' => '',
            ]
        ];

    }

    #[Computed()]
    public function features(){

        return Feature::where('option_id', $this->variant['option_id'])->get();

    }

    public function addFeature(){
        $this->variant['features'][] = [
            'id' => '',
            'value' => '',
            'description' => '',
        ];
    }

    //Eliminar feature en el modal de crear
    public function removeFeature($index){

        //Sacar el elemento del array de acuerdo a su indice
        unset($this->variant['features'][$index]);

        //Refrescar los indices de los elementos restantes del array
        $this->variant['features'] = array_values($this->variant['features']);

    }

    public function deleteOption($option_id){

        //Eliminar el registro de la tabla intermedia, ya que accedemos al metodo options del producto, que implica las opciones creadas sobre el producto
        $this->product->options()->detach($option_id);

        //Refrescamos
        $this->product = $this->product->fresh();

    }

    //Eliminar feature de una opción creada
    public function deleteFeature($option_id, $feature_id){
        
        $this->product->options()->updateExistingPivot($option_id, [
            'features' => array_filter($this->product->options->find($option_id)->pivot->features, function ($feature) use ($feature_id){
                return $feature['id'] != $feature_id;
            })
        ]);

        $this->product =  $this->product->fresh();

    }
    

    public function feature_change($index){

        $feature = Feature::find($this->variant['features'][$index]['id']);

        //Si el feature existe se reemplazan
        if($feature){
            $this->variant['features'][$index]['value'] = $feature->value;
            $this->variant['features'][$index]['description'] = $feature->description;
        }
    }

    public function save(){

        $this->validate([
            'variant.option_id' => 'required',
            'variant.features' => 'required|array|min:1',
            'variant.features.*.id' => 'required',
            'variant.features.*.value' => 'required',
            'variant.features.*.description' => 'required',
        ]);

        $this->product->options()->attach($this->variant['option_id'], [
            'features' => $this->variant['features']
        ]);

        $this->product =  $this->product->fresh();

        $this->reset(['variant', 'openModal']);
        
    }


    public function render()
    {
        return view('livewire.admin.products.product-variants');
    }
}
