<div>
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

        <x-validation-errors class="mb-4" />

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

                <x-input type="number" step="0.01" wire:model="productEdit.price" class="w-full"
                    placeholder="Ingrese el precio del producto" />
            </div>

            {{-- El stock se muestra en esta vista solo si el producto no tiene variantes --}}
            @empty($product->variants->count() > 0)
                
                <div class="mb-4">
                    <x-label class="mb-1">
                        Stock
                    </x-label>

                    <x-input type="number" wire:model="productEdit.stock" class="w-full"
                        placeholder="Ingrese el stock del producto" />
                </div>

            @endempty

            <div class="flex justify-end">
                {{-- Eliminar --}}
                <x-danger-button onclick="confirmDelete()">
                    Eliminar
                </x-danger-button>

                <x-button class="ml-2">
                    Actualizar producto
                </x-button>
            </div>
        </div>

    </form>


    {{-- Formulario que será enviado al presionar "Eliminar" --}}
    <form id="delete-form" action="{{ route('admin.products.destroy', $product) }}" method="POST">
        @csrf
        @method('DELETE')
    </form>


    @push('js')
        <script>
            function confirmDelete() {
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "¡No podrás revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "¡Sí, borralo!",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form').submit();
                    }

                });

            }
        </script>
    @endpush
</div>
