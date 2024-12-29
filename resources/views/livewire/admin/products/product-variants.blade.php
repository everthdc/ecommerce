<div>


    {{-- Lista de opciones --}}
    <section class="rounded-lg border border-gray-200 bg-white shadow-lg">

        <header class="border-b border-gray-200 px-6 py-2">
            <div class="flex justify-between">
                <h1 class="text-lg font-semibold text-gray-700">
                    Opciones
                </h1>

                <x-button wire:click="$set('openModal', true)">
                    Nuevo
                </x-button>
            </div>
        </header>

        <div class="p-6">

            <div class="space-y-7">

                @if ($product->options->count())

                    @foreach ($product->options as $option)

                        <div wire:key="product-option{{ $option->id }}"
                            class="p-6 border border-gray-300 rounded-md relative">

                            {{-- Boton flotante eliminar opcion --}}
                            <div class="absolute -top-3 px-3 bg-neutral-100 font-bold border rounded-md">

                                <button class="mr-1" onclick="confirmDeleteOption( {{ $option->id }} )">
                                    <i class="fa-solid fa-trash-can text-red-500 hover:text-red-600"></i>
                                </button>

                                <span>
                                    {{ $option->name }}
                                </span>
                            </div>

                            {{-- Listar los Features (Valores) --}}
                            <div class="flex flex-wrap gap-3 mt-2 mb-4">

                                @foreach ($option->pivot->features as $feature)
                                    <div wire:key="option-{{ $option->id }}-feature-{{ $feature['id'] }}">
                                        {{-- Mostrar el detalle del feature de acuerdo a su tipo --}}
                                        @switch($option->type)
                                            @case(1)
                                                {{-- Texto --}}
                                                <span
                                                    class="bg-gray-100 text-gray-800 text-xs font-medium pl-2.5 pr-1.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300 border border-gray-500">
                                                    {{ $feature['description'] }}

                                                    <button class="ml-0.5" {{-- wire:click="deleteFeature({{ $feature->id }})" --}}
                                                        onclick="confirmDeleteFeature( {{ $option->id }}, {{ $feature['id'] }} )">

                                                        <i class="fa-solid fa-xmark hover:text-red-500"></i>

                                                    </button>

                                                </span>
                                            @break

                                            @case(2)
                                                {{-- Color --}}
                                                <div class="relative">
                                                    <span
                                                        class="inline-block h-6 w-6 shadow-lg rounded-full border-2 border-gray-300"
                                                        style="background-color: {{ $feature['value'] }}">
                                                    </span>

                                                    <button
                                                        class="absolute -top-2 left-3 bg-red-500 hover:bg-red-600 size-4 flex justify-center rounded-full z-10"
                                                        {{-- wire:click="deleteFeature({{ $feature->id }})" --}}
                                                        onclick="confirmDeleteFeature( {{ $option->id }}, {{ $feature['id'] }} )">
                                                        <i class="fa-solid fa-xmark text-white text-xs"></i>
                                                    </button>
                                                </div>
                                            @break

                                            @default
                                        @endswitch
                                    </div>
                                @endforeach

                            </div>

                            {{-- Agregar feature a la opcion del producto --}}
                            <div>
                                <livewire:admin.products.add-feature-to-option :option="$option" :product="$product" :key="'add-feature-to-option-' . $option->id" />
                            </div>

                        </div>
                    @endforeach
                @else
                    <div class="p-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
                        role="alert">
                        <span class="font-medium">Info alert!</span> No hay opciones registradas en este producto.
                    </div>

                @endif

            </div>

        </div>

    </section>

    {{-- Lista de variantes --}}
    @if ($product->variants->count())
        <section class="rounded-lg border border-gray-200 bg-white shadow-lg mt-12">

            <header class="border-b border-gray-200 px-6 py-2">
                <div class="flex justify-between">

                    <h1 class="text-lg font-semibold text-gray-700">
                        Variantes
                    </h1>

                </div>
            </header>

            <div class="p-6">

                <ul class="divide-y -my-4">

                    {{-- Accedemos a la relacion que tiene el producto con las variantes --}}
                    @foreach ($product->variants as $item)

                        <li class="py-4 flex items-center">

                            <img src="{{ $item->image }}" 
                                class="size-12 object-cover object-center">


                            {{-- Acceder a los features de la variante --}}
                            <p class="divide-x">

                                @foreach ($item->features as $feature)
                                    
                                    <span class="px-3">
                                        {{ $feature->description }}
                                    </span>

                                @endforeach

                            </p>

                            <a href="{{ route('admin.products.variants', [$product, $item]) }}" class="ml-auto btn btn-blue">
                                Editar
                            </a>

                        </li>

                    @endforeach
                </ul>

            </div>

        </section>
    @endif

    {{-- Ventana modal --}}
    <x-dialog-modal wire:model="openModal">

        <x-slot name="title">
            Agregar nueva opción
        </x-slot>

        <x-slot name="content">

            <x-validation-errors class="mb-4 p-4 border border-red-500 rounded-lg">
            </x-validation-errors>

            <div class="mb-4">

                <x-label class="mb-1">
                    Opción
                </x-label>

                <x-select class="w-full" wire:model.live="variant.option_id">

                    <option value="" disabled>
                        Selecciona una opción
                    </option>

                    @foreach ($options as $option)
                        <option value="{{ $option->id }}">
                            {{ $option->name }}
                        </option>
                    @endforeach

                </x-select>

            </div>

            <div class="flex items-center mb-6">

                <hr class="flex-1">

                <span class="mx-4 text-base">Valores</span>

                <hr class="flex-1">

            </div>

            <ul class="mb-4 space-y-7">

                @foreach ($variant['features'] as $index => $feature)
                    <li wire:key="variant-feature-{{ $index }}"
                        class="border border-gray-300 rounded-lg p-6 relative">

                        {{-- Boton flotante eliminar feature añadido --}}
                        <div class="absolute -top-4 right-4 px-2 bg-white">

                            <button wire:click="removeFeature({{ $index }})"
                                class="size-8 bg-red-500 flex items-center justify-center rounded-full text-white hover:bg-red-600">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>

                        </div>

                        <div>

                            <x-label class="mb-1">
                                Valores
                            </x-label>

                            <x-select class="w-full" wire:model="variant.features.{{ $index }}.id"
                                wire:change="feature_change({{ $index }})">

                                <option value="">Selecciona un valor</option>

                                @foreach ($this->features as $feature)
                                    <option value="{{ $feature->id }}">
                                        {{ $feature->description }}
                                    </option>
                                @endforeach

                            </x-select>

                        </div>

                    </li>
                @endforeach

            </ul>

            <div class="flex">

                <button class="w-full p-3.5 bg-blue-500 hover:bg-blue-600 text-white text-base rounded-md"
                    wire:click="addFeature">
                    <i class="fa-solid fa-plus mr-1"></i> Agregar valor
                </button>

            </div>

        </x-slot>

        <x-slot name="footer">

            <x-danger-button wire:click="$set('openModal', false)" class="mr-2">
                Cancelar
            </x-danger-button>

            <x-button wire:click="save">
                Guardar
            </x-button>

        </x-slot>

    </x-dialog-modal>

    @push('js')
        <script>
            function confirmDeleteFeature(option_id, feature_id) {

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

                        @this.call('deleteFeature', option_id, feature_id);

                    }

                });

            }

            function confirmDeleteOption(option_id) {

                Swal.fire({
                    title: "¿Quieres eliminar la opción?",
                    text: "¡No podrás revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "¡Sí, borralo!",
                    cancelButtonText: "Cancelar"
                }).then((result) => {

                    if (result.isConfirmed) {

                        @this.call('deleteOption', option_id);

                    }

                });

            }
        </script>
    @endpush

</div>
