<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Subcategorias',
        'route' => route('admin.subcategories.index'),
    ],
    [
        'name' => 'Crear Nuevo',
    ],
]">

    {{-- <div class="card">
        <form action="{{route('admin.subcategories.store')}}" method="POST">
            @csrf
            
            <x-validation-errors class="mb-4"/>

            <div class="mb-4">
                <x-label class="mb-1">
                    Categorias:
                </x-label>

                <x-select name="category_id" id="" class="w-full">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $->id)>
                            {{ $->name }}
                        </option>
                    @endforeach
                </x-select>
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre:
                </x-label>

                <x-input class="w-full" 
                    placeholder="Ingrese el nombre de la subcategoría"
                    name="name"
                    value="{{old('name')}}" />
            </div>

            <div class="flex justify-end">
                <x-button>
                    Guardar
                </x-button>
            </div>
        </form>
    </div> --}}

    @livewire('admin.subcategories.subcategory-create')

</x-admin-layout>
