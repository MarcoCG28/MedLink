<?php

function noIterar($arreglo) {
    $texto = $arreglo[0]; // Cadena principal (N)
    $objetivo = $arreglo[1]; // Caracteres que deben estar incluidos en la subcadena (K)

    // Contar los caracteres requeridos
    $necesario = [];
    foreach (str_split($objetivo) as $letra) {
        if (!isset($necesario[$letra])) $necesario[$letra] = 0;
        $necesario[$letra]++;
    }

    $enVentana = [];               // Contador de letras actuales dentro de la ventana
    $totalRequerido = count($necesario); // Número total de letras únicas requeridas
    $formado = 0;                  // Cuántos caracteres requeridos ya se cumplen

    $inicio = 0;
    $fin = 0;

    $longitudMinima = PHP_INT_MAX;
    $ventanaMinima = "";

    while ($fin < strlen($texto)) {
        $letra = $texto[$fin];

        // Si la letra está en la lista de necesarias, la contamos
        if (isset($necesario[$letra])) {
            if (!isset($enVentana[$letra])) $enVentana[$letra] = 0;
            $enVentana[$letra]++;

            // Si ya cumplimos con la cantidad necesaria de esa letra
            if ($enVentana[$letra] == $necesario[$letra]) {
                $formado++;
            }
        }

        // Si la ventana actual contiene todos los caracteres requeridos
        while ($formado === $totalRequerido && $inicio <= $fin) {
            // Guardamos la ventana si es más corta que la mínima anterior
            if (($fin - $inicio + 1) < $longitudMinima) {
                $longitudMinima = $fin - $inicio + 1;
                $ventanaMinima = substr($texto, $inicio, $longitudMinima);
            }

            // Intentamos reducir la ventana desde la izquierda
            $letraInicio = $texto[$inicio];
            if (isset($necesario[$letraInicio])) {
                $enVentana[$letraInicio]--;
                if ($enVentana[$letraInicio] < $necesario[$letraInicio]) {
                    $formado--;
                }
            }

            $inicio++;
        }

        $fin++;
    }

    return $ventanaMinima;
}

// Pruebas
echo noIterar(["ahffaksfajeeubsne", "jefaa"])."\n";
echo noIterar(["aaffhkksemckelloe", "fhea"]);

?>
