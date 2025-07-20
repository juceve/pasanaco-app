<?php

use Illuminate\Support\Carbon;

function fechaLiteralEsp($fecha)
{
    // Ejemplo: '2025-07-16' => 'Miércoles, 16 de Julio de 2025'
    setlocale(LC_TIME, 'es_ES.UTF-8', 'Spanish_Spain.1252');
    $carbon = \Carbon\Carbon::createFromFormat('Y-m-d', $fecha);
    // Si no tienes Carbon, puedes usar DateTime en vez de $carbon
    return ucfirst($carbon->translatedFormat('l, d \d\e F \d\e Y'));
}


function fechaCarbon($fecha)
{
    try {
        // Si la fecha ya es una instancia de Carbon, devolverla con locale
        if ($fecha instanceof Carbon) {
            return $fecha->locale('es');
        }
        
        // Si es null o vacío, devolver Carbon actual
        if (empty($fecha)) {
            return Carbon::now()->locale('es');
        }
        
        // Intentar diferentes formatos comunes
        $formatos = [
            'Y-m-d',        // 2025-07-19
            'd/m/Y',        // 19/07/2025
            'm/d/Y',        // 07/19/2025
            'Y-m-d H:i:s',  // 2025-07-19 10:30:00
            'd-m-Y',        // 19-07-2025
        ];
        
        foreach ($formatos as $formato) {
            try {
                $carbon = Carbon::createFromFormat($formato, $fecha);
                if ($carbon !== false) {
                    return $carbon->locale('es');
                }
            } catch (\Exception $e) {
                // Continuar con el siguiente formato
                continue;
            }
        }
        
        // Como último recurso, usar parse (puede lanzar excepción)
        return Carbon::parse($fecha)->locale('es');
        
    } catch (\Exception $e) {
        // Si todo falla, devolver fecha actual con log del error
        logger("Error parsing date: {$fecha} - " . $e->getMessage());
        return Carbon::now()->locale('es');
    }
}