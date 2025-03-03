<div x-data="{

    open: false,

}">

    {{-- Navbar --}}
    <header class="bg-slate-200">

        <x-container class="px-4 py-3 md:py-4">

            <div class="flex justify-between items-center space-x-8">

                {{-- Boton menu --}}
                <button x-on:click="open = true">

                    <i class="fa fa-solid fa-bars text-xl md:text-3xl"></i>

                    <p class="text-xs font-bold">Menú</p>

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
                    
                    <x-dropdown>

                        <x-slot name="trigger">
                            {{-- Mostrar la foto de perfil del usuario si está logeado --}}
                            @auth
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <button class="text-xl md:text-3xl">
                                    <i class="fa fa-solid fa-user"></i>
                                </button>
                            @endauth

                        </x-slot>

                        <x-slot name="content">

                            @guest

                                {{-- Se muestra si no se ha iniciado sesión --}}
                                <div class="px-4 py-3">

                                    <div class="flex justify-center">
                                        <a href="{{ route('login') }}" class="btn btn-new-blue">
                                            Iniciar sesión
                                        </a>
                                    </div>

                                    <p class="text-sm text-center mt-2">

                                        ¿No tienes cuenta?

                                        <a href="{{ route('register') }}"
                                            class="text-[#1481BA] hover:underline">
                                            Regístrate
                                        </a>

                                    </p>

                                </div>

                            @else
                            
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Administrar cuenta
                                </div>

                                <x-dropdown-link href="{{  route('profile.show') }}">
                                    Mi perfil
                                </x-dropdown-link>

                                <div class="border-t border-gray-200">
                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf

                                        <x-dropdown-link href="{{ route('logout') }}"
                                                @click.prevent="$root.submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </div>

                            @endguest

                        </x-slot>

                    </x-dropdown>
                    
                    

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
    <div x-show="open" x-on:click="open = false"
        style="display:none" class="fixed top-0 left-0 inset-0 bg-black bg-opacity-25 z-10">
    </div>

    {{-- Menu --}}
    <div x-show="open" 
        style="display:none"  class="fixed top-0 left-0 z-20">

        <div class="flex">

            {{-- Menu que contendrá las familias --}}
            <div class="w-screen md:w-80 h-screen bg-white">

                <div class="bg-slate-200 px-4 py-3 font-semibold">
                    <div class="flex justify-between items-center">
                        <span class="text-lg">
                            Hola
                        </span>
    
                        <button x-on:click="open = false" class="hover:text-red-500">
                            <i class="fa fa-solid fa-times"></i>
                        </button>
                    </div>
                </div>

                {{-- Lista de Familias --}}
                <div class="h-[calc(100vh-52px)] overflow-auto">

                    <ul>
                        @foreach ($families as $family)

                            <li wire:mouseover="$set('family_id', {{ $family->id }})">
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

            {{-- Seccion que tendrá las categorias de la familia --}}
            <div class="w-80 xl:w-[57rem] mt-[52px] hidden md:block">
                
                <div class="bg-white h-[calc(100vh-52px)] px-6 py-8 overflow-auto">
                    
                    {{-- Nombre de la familia --}}
                    <div class="mb-8 flex justify-between items-center">

                        <p class="border-b-[3px] border-lime-400 pb-1 uppercase text-xl font-semibold">
                            {{ $this->familyName }}
                        </p>

                        <a href="" class="btn btn-new-blue">
                            Ver todo
                        </a>
                        
                    </div>

                    {{-- Lista de categorias --}}
                    <ul class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                        @foreach ($this->categories as $category)

                            <li>
                                <a href="" class="text-[#1481BA] font-semibold text-lg">
                                    {{ $category->name }}
                                </a>

                                <ul class="mt-4 space-y-2">

                                    @foreach ($category->subcategories as $subcategory)
                                        
                                        <li>
                                            <a href="" class="text-sm text-gray-700 hover:text-[#1481BA]">
                                                {{ $subcategory->name }}
                                            </a>
                                        </li>

                                    @endforeach

                                </ul>
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    </div>
</div>
