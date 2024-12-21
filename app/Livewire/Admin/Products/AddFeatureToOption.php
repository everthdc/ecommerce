<?php

namespace App\Livewire\Admin\Products;

use App\Models\Feature;
use Livewire\Component;

class AddFeatureToOption extends Component
{

    public $option;

    public $product;

    public $currentFeatures;

    public $featureToAdd = [
        'id' => '',
        'value' => '',
        'description' => '',
    ];

    public $existingFeatureIds = [];

    public function features()
    {

        return Feature::where('option_id', $this->option->id)->get();
    }

    public function mount()
    {

        $this->currentFeatures = $this->option->pivot->features;

        $this->existingFeatureIds = collect($this->option->pivot->features)->pluck('id')->toArray();
    }

    public function updateFeatureToAdd()
    {

        $feature = Feature::find($this->featureToAdd['id']);

        //Si el feature existe se reemplazan
        if ($feature) {
            $this->featureToAdd['value'] = $feature->value;
            $this->featureToAdd['description'] = $feature->description;
        }
    }

    public function save()
    {

        // dd($this->currentFeatures);

        // Asegúrate de usar la propiedad correcta
        $currentFeatures = $this->currentFeatures;

        // Verifica si el nuevo feature ya está en el arreglo
        if (!collect($currentFeatures)->pluck('id')->contains($this->featureToAdd['id'])) {
            $currentFeatures[] = $this->featureToAdd; // Agrega el nuevo feature
        }

        // Actualiza la tabla pivote con los nuevos features
        $this->product->options()->updateExistingPivot($this->option->id, [
            'features' => $currentFeatures, // Laravel codifica automáticamente como JSON
        ]);

        // Actualiza la propiedad para reflejar los cambios en el componente
        $this->currentFeatures = $currentFeatures;

        // Resetea el formulario de adición
        $this->reset(['featureToAdd']);

        // Lanza el evento para el componente padre
        $this->dispatch('featureAddedToOption');
    }


    public function render()
    {
        return view('livewire.admin.products.add-feature-to-option');
    }
}
