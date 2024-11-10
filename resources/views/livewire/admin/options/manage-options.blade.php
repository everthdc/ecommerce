<div>

    <section class="rounded-lg bg-white shadow-lg">

        <header class="border-b border-gray-200 px-6 py-2">
            <div class="flex justify-between">
                <h1 class="text-lg font-semibold text-gray-700">
                    Opciones
                </h1>

                <x-button wire:click="$set('newOption.openModal', true)">
                    Nuevo
                </x-button>
            </div>
        </header>

        <div class="p-6">

            <div class="space-y-7">

                {{-- Listar las opciones de la BD --}}
                @foreach ($options as $option)

                    <div class="p-6 rounded-lg border border-gray-300 relative" 
                        wire:key="option-{{ $option->id }}">

                        {{-- Nombre de la opción que se pone por encima del div --}}
                        <div class="absolute -top-3 px-3 bg-neutral-100 font-bold border rounded-md">
                            <span>
                                {{ $option->name }}
                            </span>
                        </div>

                        {{-- Listar los Features (Valores) --}}
                        <div class="flex flex-wrap gap-3 mt-1 mb-4">

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

                        {{-- Formulario para agregar nuevo valor en la opción --}}
                        <div>
                            <livewire:admin.options.add-new-feature :option="$option" :key="'add-new-feature-' . $option->id" />
                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </section>

    <x-dialog-modal wire:model="newOption.openModal">

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

                    @foreach ($newOption->features as $index => $feature)

                        <div class="p-6 rounded-lg border border-gray-300 relative"
                            wire:key="features-{{ $index }}">

                            {{-- Boton flotante eliminar feature añadido --}}
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

                                    @switch($newOption->type)

                                        @case(1)

                                            <x-input class="w-full" 
                                            wire:model="newOption.features.{{ $index }}.value"
                                            placeholder="Ingrese el valor de la opción" />
                                            
                                            @break

                                        @case(2)
                                            
                                            <div class="flex items-center justify-between border border-gray-300 rounded-md h-[42px] px-3">
                                                
                                                {{ $newOption->features[$index]['value'] ?: 'Seleccione un color' }}

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

                <div class="flex">

                    <button class="w-full p-3.5 bg-blue-500 hover:bg-blue-600 text-white text-base rounded-md" wire:click="addFeature">
                        <i class="fa-solid fa-plus mr-1"></i> Agregar valor
                    </button>

                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <x-button wire:click="addOption">
                Guardar opción
            </x-button>

        </x-slot>

    </x-dialog-modal>

</div>
