<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Categorías',
        'route' => route('admin.categories.index'),
    ],
    [
        'name' => 'Crear Nuevo',
    ],
]">

    <div class="card">
        <form action="{{route('admin.categories.store')}}" method="POST">
            @csrf
            
            {{-- Esto lista los errores de validacion --}}
            <x-validation-errors class="mb-4"/>

            <div class="mb-4">
                <x-label class="mb-1">
                    Familia:
                </x-label>

                <x-select name="family_id" id="" class="w-full">
                    @foreach ($families as $family)
                        <option value="{{ $family->id }}" @selected(old('family_id') == $family->id)>
                            {{ $family->name }}
                        </option>
                    @endforeach
                </x-select>
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre:
                </x-label>

                <x-input class="w-full" 
                    placeholder="Ingrese el nombre de la categoría"
                    name="name"
                    value="{{old('name')}}" />
            </div>

            <div class="flex justify-end">
                <x-button>
                    Guardar
                </x-button>
            </div>
        </form>
    </div>


</x-admin-layout>
