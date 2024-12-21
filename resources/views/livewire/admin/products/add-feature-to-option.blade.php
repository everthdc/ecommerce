<div>

    <div class="mt-3 mb-1.5">

        <span class="text-gray-900 font-medium">Añade más valores</span>

    </div>

    <form wire:submit="save" class="flex flex-col xl:flex-row gap-2 xl:gap-4">

        <div class="flex-1">
            <x-label class="mb-1">
                Valores
            </x-label>

            <x-select class="w-full" wire:model="featureToAdd.id" wire:change="updateFeatureToAdd">

                <option value="" disabled>Selecciona un valor</option>

                @foreach ($this->features() as $feature)

                    @if (!in_array($feature->id, $this->existingFeatureIds))
                        <option value="{{ $feature->id }}">

                            {{ $feature->description }}
                        </option>
                    @endif

                @endforeach

            </x-select>
        </div>

        <div class="flex justify-end items-center mt-2 xl:mt-6">

            <x-button>
                Añadir
            </x-button>

        </div>

    </form>

</div>
