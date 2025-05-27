<?php

function findPoint($strArr) {
    
    //convertir las cadenas de entrada en arreglos de enteros y elimnamos espacios
    $array1 = array_map('intval', explode(',', str_replace(' ', '', $strArr[0])));
    $array2 = array_map('intval', explode(',', str_replace(' ', '', $strArr[1])));
    
    //Encontrar la intersección de los dos arreglos
    $interseccion = array_intersect($array1, $array2);
    
    //Si hay intersección, devolverla como string
    if (!empty($interseccion)) {
        return implode(',', $interseccion);
    } else {
        return 'false';
    }
}

// Pruebas
echo findPoint(array("1, 3, 4, 7, 13", "1, 2, 4, 13, 15"));
?>
