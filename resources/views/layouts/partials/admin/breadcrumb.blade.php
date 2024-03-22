@if (count($breadcrumbs))
    <nav class="mb-4">
        <ol class="flex flex-wrap">
            @foreach ($breadcrumbs as $item)
                {{-- Todos empiezan con las primeras clases --}}
                {{-- Si no es el primer elemento, se aplican los estilos, que es agregar un slash antes del nombre --}}
                <li class="text-sm leading-normal text-slate-700 {{ !$loop->first ? "pl-2 before:float-left before:pr-2 before:content-['/']" : ''}}">
                    
                    {{-- Si el item tiene route definida se imprime como enlace --}}
                    @isset($item['route'])
                        <a href="" class="opacity-60">
                            {{ $item['name'] }}
                        </a>
                    @else
                        {{-- Si no tiene route definido solo se imprime como texto plano --}}
                        {{ $item['name'] }}
                    @endisset

                </li>
            @endforeach
            

        </ol>

        {{-- Te indica en que vista estas --}}
        {{-- Si la cantidad de enlaces recibidos es mayor a 1 se muestra, sino se oculta, ya que estas en una ruta tipo principal y es redundante mostrar lo mismo 2 veces --}}
        @if (count($breadcrumbs) > 1)
            <h6 class="font-bold">
                {{ end($breadcrumbs)['name'] }}
            </h6>
        @endif
        
    </nav>
@endif
    