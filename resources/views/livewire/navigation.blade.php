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

    {{-- Fondo oscuro transparente --}}
    <div class="fixed top-0 left-0 inset-0 bg-black bg-opacity-25 z-10">
    </div>

    <div class="fixed top-0 left-0 z-20">

        <div class="flex">

            <div class="w-80 h-screen bg-white">

                <div class="bg-slate-200 px-4 py-3 font-semibold">
                    <div class="flex justify-between items-center">
                        <span class="text-lg">
                            Hola
                        </span>
    
                        <button>
                            <i class="fa fa-solid fa-times"></i>
                        </button>
                    </div>
                </div>

                {{-- Lista de Familias --}}
                <div class="h-[calc(100vh-52px)] overflow-auto">

                    <ul>
                        @foreach ($families as $family)
                            <li>
                                <a href=""
                                    class="flex items-center justify-between px-4 py-4 text-gray-700 hover:bg-slate-100">

                                    {{ $family->name }}

                                    <i class="fa fa-solid fa-angle-right"></i>

                                </a>
                            </li>
                        @endforeach
                    </ul>

                </div>

            </div>

            <div>

            </div>

        </div>

    </div>
</div>
