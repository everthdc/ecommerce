<div>
    <form wire:submit="save">
        <div class="card">
            <div class="mb-4">
    
                <x-label class="mb-1">
                    Familias:
                </x-label>
    
                <x-select class="w-full" wire:model.live="subcategory.family_id">
                    <option value="" disabled>
                        Seleccione una familia...
                    </option>
                    @foreach ($families as $family)
                        <option value="{{ $family->id }}">
                            {{ $family->name }}
                        </option>
                    @endforeach
                </x-select>
                <x-input-error for="subcategory.family_id"/>
    
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Categorias:
                </x-label>
    
                <x-select id="" class="w-full" wire:model.live="subcategory.category_id">
                    <option value="" disabled>
                        Seleccione una categoria...
                    </option>
                    @foreach ($this->categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                        
                    @endforeach
                </x-select>
                <x-input-error for="subcategory.category_id"/>
            </div>
    
            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre:
                </x-label>
    
                <x-input class="w-full" placeholder="Ingrese el nombre de la subcategoría" wire:model="subcategory.name"/>
                <x-input-error for="subcategory.name"/>
            </div>
    
            <div class="flex justify-end">
                <x-button>
                    Guardar
                </x-button>
            </div>
    
        </div>
    </form>

</div>
