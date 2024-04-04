<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Family;
use App\Models\Product;
use App\Models\Subcategory;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductCreate extends Component
{

    use WithFileUploads;

    public $families;
    
    public $family_id = "";

    public $category_id = "";

    public $image;

    public $product = [
        'sku' => '',
        'name' => '',
        'description' => '',
        'image_path' => '',
        'price' => '',
        'subcategory_id' => '',
    ];

    public function mount(){
        $this->families = Family::all();
    }

    //Funcion para alerta de error en el formulario
    public function boot(){
        $this->withValidator(function ($validator){
            if($validator->fails()){
                $this->dispatch('swal', [
                    'icon' => 'error',
                    'title' => '¡Error!',
                    'text' => 'El formulario contiene errores. Por favor revisa los campos.'
                ]);
            }
        });
    }

    public function updatedFamilyId(){
        $this->category_id = '';
        $this->product['subcategory_id'] = '';
    }

    public function updatedCategoryId(){
        $this->product['subcategory_id'] = '';
    }

    #[Computed()]
    public function categories(){
        return Category::where('family_id', $this->family_id)->get();
    }

    #[Computed()]
    public function subcategories(){
        return Subcategory::where('category_id', $this->category_id)->get();
    }

    public function store(){
        $this->validate([
            'image' => 'required|image|max:1024',
            'product.sku' => 'required|unique:products,sku',
            'product.name' => 'required|max:255',
            'product.description' => 'nullable',
            'product.price' => 'required|numeric|min:0',
            'product.subcategory_id' => 'required|exists:subcategories,id',
        ],[],[
            'image' => 'imagen',
            'product.sku' => 'sku',
            'product.name' => 'nombre',
            'product.description' => 'descripción',
            'product.price' => 'precio',
            'product.subcategory_id' => 'subcategoría',
        ]);

        $this->product['image_path'] = $this->image->store('products');

        $product = Product::create($this->product);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Producto creado correctamente.'
        ]);
        
        return redirect()->route('admin.products.edit', $product);
    }

    public function render()
    {
        return view('livewire.admin.products.product-create');
    }
}
