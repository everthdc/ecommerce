<div>

    <form wire:submit="addFeature" class="flex flex-col xl:flex-row gap-4">

        {{-- Valor --}}
        <div class="flex-1">

            <x-label class="mb-1">
                Valor
            </x-label>

            @switch($option->type)

                @case(1)

                    <x-input class="w-full" wire:model="newFeature.value"
                        placeholder="Ingrese el valor de la opción" />

                    @break

                @case(2)

                    <div class="flex items-center justify-between border border-gray-300 rounded-md h-[42px] px-3">

                        {{ $newFeature['value'] ?: 'Seleccione un color' }}

                        <input type="color" wire:model.live="newFeature.value">

                    </div>

                    @break

                @default

            @endswitch

        </div>

        {{-- Descripcion --}}
        <div class="flex-1">

            <x-label class="mb-1">
                Descripción
            </x-label>
            <x-input class="w-full"
                wire:model="newFeature.description"
                placeholder="Ingrese una descripción" />

        </div>

        <div class="mt-7">

            <x-button>
                Agregar nuevo
            </x-button>

        </div>

    </form>

</div>
