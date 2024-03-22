<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
    ],
]">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Tarjeta 1 --}}
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                {{-- Foto de perfil del usuario --}}
                <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                {{--Nombre de usuario--}}
                <div class="ml-4 flex-1">
                    <h2 class="text-lg font-semibold">
                        Bienvenido, {{ auth()->user()->name }}
                    </h2>
                    {{-- Cerrar sesion --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="text-base hover:text-blue-500">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tarjeta 2 --}}
        <div class="bg-white rounded-lg shadow-lg p-6 flex items-center justify-center">
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 me-2" alt="FlowBite Logo">
            <h2 class="text-xl font-semibold">
                Ecommerce
            </h2>
        </div>

    </div>
</x-admin-layout>