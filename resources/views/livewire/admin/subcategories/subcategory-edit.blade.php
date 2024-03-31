<div>
    <form wire:submit="save">
        <div class="card">
            <div class="mb-4">
    
                <x-label class="mb-1">
                    Familias:
                </x-label>
    
                <x-select class="w-full" wire:model.live="subcategoryEdit.family_id">
                    <option value="" disabled>
                        Seleccione una familia...
                    </option>
                    @foreach ($families as $family)
                        <option value="{{ $family->id }}">
                            {{ $family->name }}
                        </option>
                    @endforeach
                </x-select>
                <x-input-error for="subcategoryEdit.family_id"/>
    
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Categorias:
                </x-label>
    
                <x-select id="" class="w-full" wire:model.live="subcategoryEdit.category_id">
                    <option value="" disabled>
                        Seleccione una categoria...
                    </option>
                    @foreach ($this->categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                        
                    @endforeach
                </x-select>
                <x-input-error for="subcategoryEdit.category_id"/>
            </div>
    
            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre:
                </x-label>
    
                <x-input class="w-full" placeholder="Ingrese el nombre de la subcategoría" wire:model="subcategoryEdit.name"/>
                <x-input-error for="subcategoryEdit.name"/>
            </div>
    
            <div class="flex justify-end">
                {{-- Eliminar --}}
                <x-danger-button onclick="confirmDelete()">
                    Eliminar
                </x-danger-button>

                <x-button class="ml-2">
                    Actualizar
                </x-button>
            </div>
    
        </div>
    </form>


    {{-- Formulario que será enviado al presionar "Eliminar" --}}
    <form id="delete-form" action="{{ route('admin.subcategories.destroy', $subcategory) }}" method="POST">
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