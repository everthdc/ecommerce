<?php

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('prueba', function(){

    $product = Product::find(48);

    //Cargar las opciones del producto y acceder a la tabla pivote(option_product) y luego acceder al campo features
    //Con el pluck se crea un array con los campos que se le indique, así la funcion lo recibe en un formato con el que puede generar las combinaciones
    $features = $product->options->pluck('pivot.features');

    $combinaciones = generarCombinaciones($features);

    //Primero borrar todas las variantes para poder generar las combinaciones, esto en caso de que se borre un feature de la opcion
    $product->variants()->delete();

    //Por cada grupo de features hay que generar una variante
    foreach($combinaciones as $combinacion){

        $variant = Variant::create([
            'product_id' => $product->id,
        ]);

        $variant->features()->attach($combinacion);

    };

    return "Variantes creadas";

    return $combinaciones;

});

function generarCombinaciones($arrays, $indice = 0, $combinacion = []){

    if ($indice == count($arrays)){
        return [$combinacion];
    }

    $resultado = [];

    //Accedemos a la variable que contiene todos los arrays
    //Con el foreach recorremos cada elemento del array correspondiente al indice
    //Ej: $arrays[0] = primer array, $arrays[1] = segundo array, y asi...
    foreach($arrays[$indice] as $item){

        $combinacionTemporal = $combinacion; //Inicializarlo con lo que se tenga en $combinacion

        $combinacionTemporal[] = $item['id']; //Se almacena el elemento del array


        //Volver a llamar a la misma funcion
        $resultado = array_merge($resultado, generarCombinaciones($arrays, $indice + 1, $combinacionTemporal));

    }

    return $resultado;

}
