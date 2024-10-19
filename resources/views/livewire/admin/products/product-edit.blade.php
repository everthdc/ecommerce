<form wire:submit="store">

    <figure class="mb-4 relative">
        <div class="absolute top-8 right-8">
            <label class="flex items-center px-4 py-2 rounded-lg btn-blue cursor-pointer">
                <i class="fas fa-camera mr-2"></i>
                Actualizar imagen
                <input type="file" class="hidden" accept="image/*" wire:model="image">
            </label>
        </div>
        <img class="aspect-[16/9] object-cover object-center w-full"
            src="{{ $image ? $image->temporaryUrl() : Storage::url($productEdit['image_path']) }}" alt="">
    </figure>

    <x-validation-errors class="mb-4"/>

    <div class="card">
        {{-- Success is as dangerous as failure. --}}
        <div class="mb-4">
            <x-label class="mb-1 font-black">
                Información del producto:
            </x-label>
        </div>
        <div class="mb-4">
            <x-label class="mb-1">
                Código
            </x-label>
            <x-input wire:model="productEdit.sku" class="w-full" placeholder="Ingrese el código del producto" />
        </div>

        <div class="mb-4">
            <x-label class="mb-1">
                Nombre
            </x-label>
            <x-input wire:model="productEdit.name" class="w-full" placeholder="Ingrese el nombre del producto" />
        </div>

        <div class="mb-4">
            <x-label class="mb-1">
                Descripción
            </x-label>
            <x-textarea wire:model="productEdit.description" class="w-full"
                placeholder="Ingrese la descripción del producto">
            </x-textarea>
        </div>

        <div class="mb-4">
            <x-label class="mb-1">
                Familia
            </x-label>
            <x-select class="w-full" wire:model.live="family_id">
                <option value="" disabled>
                    Seleccione una familia
                </option>
                @foreach ($families as $family)
                    <option value="{{ $family->id }}">
                        {{ $family->name }}
                    </option>
                @endforeach
            </x-select>
            <x-input-error for="" />
        </div>

        <div class="mb-4">
            <x-label class="mb-1">
                Categoría
            </x-label>
            <x-select class="w-full" wire:model.live="category_id">
                <option value="" disabled>
                    Seleccione una categoria
                </option>
                @foreach ($this->categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </x-select>
            <x-input-error for="" />
        </div>

        <div class="mb-4">
            <x-label class="mb-1">
                Subcategoría
            </x-label>
            <x-select class="w-full" wire:model.live="productEdit.subcategory_id">
                <option value="" disabled>
                    Seleccione una subcategoria
                </option>
                @foreach ($this->subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}">
                        {{ $subcategory->name }}
                    </option>
                @endforeach
            </x-select>
            <x-input-error for="" />
        </div>
        
        <div class="mb-4">
            <x-label class="mb-1">
                Precio
            </x-label>

            <x-input
                type="number"
                step="0.01"
                wire:model="productEdit.price"
                class="w-full"
                placeholder="Ingrese el precio del producto"/>
        </div>

        <div class="flex justify-end">
            <x-button>
                Actualizar producto
            </x-button>
        </div>
    </div>
</form>