<div>

    <section class="rounded-lg bg-white shadow-lg">

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

            <div class="space-y-6">

                {{-- Listar las opciones --}}
                @foreach ($options as $option)
                    <div class="p-6 rounded-lg border border-gray-300 relative">

                        {{-- Nombre de la opción que se pone por encima del div --}}
                        <div class="absolute -top-3 px-3 bg-white">
                            <span>
                                {{ $option->name }}
                            </span>
                        </div>

                        {{-- Listar los Features --}}
                        <div class="flex flex-wrap gap-3">

                            @foreach ($option->features as $feature)
                                {{-- Mostrar el detalle del feature de acuerdo a su tipo --}}
                                @switch($option->type)
                                    @case(1)
                                        {{-- Texto --}}
                                        <span
                                            class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">
                                            {{ $feature->description }}
                                        </span>
                                    @break

                                    @case(2)
                                        {{-- Color --}}
                                        <span class="inline-block h-6 w-6 shadow-lg rounded-full border-2 border-gray-300"
                                            style="background-color: {{ $feature->value }}">
                                        </span>
                                    @break

                                    @default
                                @endswitch
                            @endforeach

                        </div>

                    </div>
                @endforeach

            </div>

        </div>

    </section>

    <x-dialog-modal wire:model="openModal">

        <x-slot name="title">
            Crear nueva opción
        </x-slot>

        <x-slot name="content">

            <x-validation-errors class="mb-4 p-4 border border-red-500 rounded-lg">
            </x-validation-errors>

            {{-- Datos de la opción --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-4">

                <div>
                    <x-label class="mb-1">
                        Nombre
                    </x-label>
                    <x-input class="w-full" wire:model="newOption.name" placeholder="Por ejemplo: Tamaño, Color" />
                </div>

                <div>
                    <x-label class="mb-1">
                        Tipo
                    </x-label>

                    <x-select class="w-full" wire:model.live="newOption.type">

                        <option value="1">Texto</option>
                        <option value="2">Color</option>

                    </x-select>
                </div>

            </div>

            {{-- Features (valores de la opción) --}}
            <div>

                {{-- Titulo --}}
                <div class="flex items-center mb-4">
                    <hr class="h-full flex-1">

                    <span class="mx-4 text-base">
                        Valores
                    </span>

                    <hr class="h-full flex-1">
                </div>

                {{-- Listado del array --}}
                <div class="mb-4 space-y-7">

                    @foreach ($newOption['features'] as $index => $feature)

                        <div class="p-6 rounded-lg border border-gray-300 relative"
                            wire:key="features-{{ $index }}">

                            {{-- Boton eliminar feature añadido --}}
                            <div class="absolute -top-4 right-4 px-2 bg-white">

                                <button wire:click="removeFeature({{ $index }})"
                                    class="size-8 bg-red-500 flex items-center justify-center rounded-full text-white hover:bg-red-600">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>

                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">

                                <div>
                                    <x-label class="mb-1">
                                        Valor
                                    </x-label>

                                    @switch($newOption['type'])

                                        @case(1)

                                            <x-input class="w-full" 
                                            wire:model="newOption.features.{{ $index }}.value"
                                            placeholder="Ingrese el valor de la opción" />
                                            
                                            @break
                                        @case(2)
                                            
                                            <div class="flex items-center justify-between border border-gray-300 rounded-md h-[42px] px-3">
                                                
                                                {{ $newOption['features'][$index]['value'] ?: 'Seleccione un color' }}

                                                <input type="color"
                                                wire:model.live="newOption.features.{{ $index }}.value">

                                            </div>

                                            @break

                                        @default
                                            
                                    @endswitch
                                </div>

                                <div>
                                    <x-label class="mb-1">
                                        Descripción
                                    </x-label>
                                    <x-input class="w-full"
                                        wire:model="newOption.features.{{ $index }}.description"
                                        placeholder="Ingrese una descripción" />
                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

                <div class="flex justify-end">
                    <x-button wire:click="addFeature">
                        Agregar valor
                    </x-button>
                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <button class="btn btn-blue" wire:click="addOption">
                Guardar opción
            </button>

        </x-slot>

    </x-dialog-modal>

</div>
