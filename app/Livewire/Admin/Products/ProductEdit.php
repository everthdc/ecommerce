<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Family;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

use function Livewire\store;

class ProductEdit extends Component
{
    use WithFileUploads;

    public $product;
    public $productEdit;
    
    public $image;

    public $families;
    public $family_id = "";
    public $category_id = "";

    public function mount($product){

        //Cargar solo los campos definidos en el metodo only
        $this->productEdit = $product->only('sku', 'name', 'description', 'image_path', 'price', 'subcategory_id');
        
        $this->families = Family::all();

        $this->category_id = $product->subcategory->category->id;

        $this->family_id = $product->subcategory->category->family_id;

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

    //Cuando se actualiza el id de la familia...
    public function updatedFamilyId(){

        //1. Actualizar el id de la categoria
        $this->category_id = '';

        //2. Actualizar la subcategoria del producto al ir editando
        $this->productEdit['subcategory_id'] = '';
    }

    //Cuando se actualiza el id de la categoria...
    public function updatedCategoryId(){
        //1. Resetear la subcategoria del producto al ir editando
        $this->productEdit['subcategory_id'] = '';
    }

    #[Computed()]
    public function categories(){
        //Retorna las categorias dependiendo de la variable family_id
        return Category::where('family_id', $this->family_id)->get();
    }

    #[Computed()]
    public function subcategories(){
        //Retorna las categorias dependiendo de la variable category_id
        return Subcategory::where('category_id', $this->category_id)->get();
    }

    public function store(){
        $this->validate([
            'image' => 'nullable|image|max:1024',
            'productEdit.sku' => 'required|unique:products,sku,'.$this->product->id,
            'productEdit.name' => 'required|max:255',
            'productEdit.description' => 'nullable',
            'productEdit.price' => 'required|numeric|min:0',
            'productEdit.subcategory_id' => 'required|exists:subcategories,id',
        ],[],[
            'image' => 'imagen',
            'product.sku' => 'sku',
            'product.name' => 'nombre',
            'product.description' => 'descripción',
            'product.price' => 'precio',
            'product.subcategory_id' => 'subcategoría',
        ]);

        //Si se está cargando una imagen
        if ($this->image) {
            //1. eliminar la imagen de acuerdo a la ruta
            Storage::delete([$this->productEdit['image_path']]);

            //2. Actualizar el valor de la ruta de la imagen y almacenar la imagen en la carpeta indicada
            $this->productEdit['image_path'] = $this->image->store('products');
        }

        $this->product->update($this->productEdit);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Producto actualizado correctamente.'
        ]);
        
        return redirect()->route('admin.products.edit', $this->product);

    }

    public function render()
    {
        return view('livewire.admin.products.product-edit');
    }
}
