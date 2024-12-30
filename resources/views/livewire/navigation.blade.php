<div>
    <header class="bg-slate-200">

        <x-container class="px-4 py-3 md:py-4">

            <div class="flex justify-between items-center space-x-8">

                {{-- Boton menu --}}
                <button class="text-xl md:text-3xl">
                    <i class="fa fa-solid fa-bars"></i>
                </button>

                {{-- Logo --}}
                <h1>
                    <a href="/" class="inline-flex flex-col items-end">
    
                        <span class="text-xl md:text-3xl leading-6 font-semibold">
                            Ecommerce
                        </span>
                        <span class="text-xs">
                            Tienda online
                        </span>
    
                    </a>
                </h1>

                {{-- Barra de busqueda --}}
                <div class="flex-1 hidden md:block">
                    <x-input class="w-full" placeholder="Buscar por producto, tienda o marca" />
                </div>

                {{-- Botones usuario --}}
                <div class="flex items-center space-x-6 md:space-x-8">
                    <button class="text-xl md:text-3xl">
                        <i class="fa fa-solid fa-user"></i>
                    </button>

                    <button class="text-xl md:text-3xl">
                        <i class="fa fa-solid fa-shopping-cart"></i>
                    </button>
                </div>
            </div>

            {{-- Barra de busqueda que aparece en vista movil --}}
            <div class="mt-4 md:hidden">
                <x-input class="w-full" placeholder="Buscar por producto, tienda o marca" />
            </div>

        </x-container>

    </header>
</div>
