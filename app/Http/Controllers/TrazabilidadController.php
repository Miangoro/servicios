<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\empresa;
use App\Models\inspecciones;
use App\Models\instalaciones;
use App\Models\solicitudTipo;
use App\Models\User;
use App\Models\Certificado_Exportacion;
use App\Models\Certificados;
use App\Models\CertificadosGranel;
use App\Models\Dictamen_Exportacion;
use App\Models\Revisor;


use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class TrazabilidadController extends Controller
{
    public function mostrarLogs($id)
    {   
        $inspeccionId = inspecciones::where('id_solicitud', $id)->pluck('id_inspeccion')->first();

        $logs = Activity::where(function($query) use ($id) {
            // Filtrar los registros del modelo inspecciones con el id_solicitud en las properties
            $query->where('subject_type', 'App\Models\inspecciones')
                ->where('properties->attributes->id_solicitud', $id);
        })
        ->orWhere(function($query) use ($id) {
            // Filtrar los registros del modelo solicitudesModel con el causer_id igual al id_solicitud
            $query->where('subject_type', 'App\Models\solicitudesModel')
                ->where('subject_id', $id);
        })
        ->orWhere(function($query) use ($id, $inspeccionId) {
            // Filtrar los registros del modelo Dictamen_instalaciones con id_inspeccion
            $query->where('subject_type', 'App\Models\Dictamen_instalaciones')
                ->where('properties->attributes->id_inspeccion', $id);
        })
        ->orWhere(function($query) use ($inspeccionId) {
            // Filtrar registros cuya id_inspección pertenezca a la inspección de la solicitud
            $query->where('subject_type', 'App\Models\Dictamen_instalaciones')
                ->where('properties->attributes->id_inspeccion', $inspeccionId);
        })
        ->orWhere(function($query) use ($id) {
           
            $query->where('subject_type', 'App\Models\Documentacion_url')
                ->where('properties->attributes->id_relacion', $id);
        })
        ->orWhere(function($query) use ($id) {
           
            $query->where('subject_type', 'App\Models\solicitudesValidacionesModel')
                ->where('properties->attributes->id_solicitud', $id);
        })
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function($log) {
            
        // Inicializar variables
            $folio = $log->properties['attributes']['folio'] ?? null;

            // Buscar los objetos solo si los IDs están presentes
            $tipo_solicitud = isset($log->properties['attributes']['id_tipo']) 
                ? solicitudTipo::find($log->properties['attributes']['id_tipo'])->tipo ?? null 
                : null;
            
            $num_dictamen = isset($log->properties['attributes']['num_dictamen']) 
                ? $log->properties['attributes']['num_dictamen'] ?? null 
                : null;

            $instalacion = isset($log->properties['attributes']['id_instalacion']) 
                ? instalaciones::find($log->properties['attributes']['id_instalacion'])->direccion_completa ?? null 
                : null;

            $nombre_documento = isset($log->properties['attributes']['nombre_documento']) 
                ? $log->properties['attributes']['nombre_documento']?? null 
                : null;

            $empresa = isset($log->properties['attributes']['id_empresa']) 
                ? empresa::find($log->properties['attributes']['id_empresa'])->razon_social ?? null 
                : null;

            $inspector = isset($log->properties['attributes']['id_inspector']) 
                ? User::find($log->properties['attributes']['id_inspector'])->name ?? null 
                : null;

            $num_servicio = isset($log->properties['attributes']['num_servicio']) 
                ? $log->properties['attributes']['num_servicio']?? null 
                : null;

            $pdf_validacion = ($log->subject_type == 'App\Models\solicitudesValidacionesModel') 
                ? $log->subject_id ?? null 
                : null;
            

            // Construcción del contenido condicionalmente
            $contenido = '';  // Inicializar vacío

            if ($folio) {
                $contenido .= "<b>Folio:</b> <span class='badge bg-secondary'>$folio</span> ";
            }

            if ($tipo_solicitud) {
                $contenido .= "<b>Solicitud:</b> $tipo_solicitud ";
            }

            if ($nombre_documento) {
                $contenido .= "<b>Nombre del documento:</b> $nombre_documento ";
            }

            if ($empresa) {
                $contenido .= "<b>Cliente:</b> $empresa ";
            }

            if ($num_dictamen) {
                $contenido .= "<b>Número de dictamen:</b> <span class='badge bg-secondary'>$num_dictamen</span> ";
            }

            if ($instalacion) {
                $contenido .= "<b>Instalación:</b> $instalacion ";
            }

            if ($inspector) {
                $contenido .= "<b>Se asignó al inspector:</b> $inspector ";
            }

            if ($num_servicio) {
                $contenido .= "<b>Número de servicio:</b> <span class='badge bg-secondary'>$num_servicio</span> ";
            }

            
            if ($pdf_validacion) {
                $contenido .= "<a class='btn btn-primary btn-sm' target='_blank' href='/pdf_validar_solicitud/$pdf_validacion '><i class='ri-file-pdf-2-fill ri-30px'></i></a>";
            }


            // Retornar los datos con el contenido construido
            return [
                'description' => $log->description,
                'properties' => $log->properties, 
                'created_at' => $log->created_at->toDateTimeString(),
                'contenido' => trim($contenido),  // Eliminar posibles espacios extra
            ];
        });
    
    return response()->json(['success' => true, 'logs' => $logs]);
    
    }



    

private function determinarTipoBloque($log, $attributes)
{
    $attributes = $log->properties['attributes'] ?? [];

    if ($log->subject_type === 'App\Models\Certificado_Exportacion') {
        if ( $attributes['estatus'] === 1) {
            return 'cancelado';
        }

        return 'registro'; // Azul
    }

    if ($log->subject_type === 'App\Models\Revisor') {
        if ($attributes['decision'] === 'Pendiente') {
            return 'asignacion'; // Morado
        }

        // Definimos resultado positivo/negativo
        if ($attributes['decision'] === 'positiva') {
            return 'resultado_positivo'; // Verde
        }

        return 'resultado_negativo'; // Rojo
    }

    return 'otro'; // sin color específico
}
///TRAZABILIDAD CERTIFICADOS
public function TrackingCertificados($id)
{   
    $logs = Activity::where(function($query) use ($id) {
        $query->where('subject_type', 'App\Models\Certificado_Exportacion')
            ->where('properties->attributes->id_certificado', $id);
    })
    ->orWhere(function($query) use ($id) {
        $query->where('subject_type', 'App\Models\Revisor')
            ->where('properties->attributes->id_certificado', $id);
    })
    ->orderBy('created_at', 'asc')
    ->get()
    ->map(function($log) {

        $attributes = $log->properties['attributes'] ?? [];
        $evento = $log->event ?? '';

    //Variables generales
        $tipo_certificado = $attributes['tipo_certificado'] ?? null;
        $num_certificado = $attributes['num_certificado'] ?? null;
        $obs = $attributes['observaciones'] ?? null;
        $num_revision = $attributes['numero_revision'] ?? null;
        $es_correccion = ($attributes['es_correccion'] ?? null) === 'si';//si, siempre se activa
        $tipo_revision = $attributes['tipo_revision'] ?? null;
        $decision = $attributes['decision'] ?? null;


        $num_cer = null;
        if ($tipo_certificado == 1) {
            $certAux = Certificados::find($attributes['id_certificado']);
        }else if ($tipo_certificado == 2) {
            $certAux = CertificadosGranel::find($attributes['id_certificado']);
        }else{
            $certAux = Certificado_Exportacion::find($attributes['id_certificado']);
        }
        if ($certAux) {
            $num_cer = $certAux->num_certificado;
        }


    // Preparar variables para contenido
        $num_dictamen = isset($attributes['id_dictamen']) 
            ? Dictamen_Exportacion::find($attributes['id_dictamen'])->num_dictamen ?? 'No encontrado' 
            : null;

        $empresa = null;
        if (isset($attributes['id_dictamen'])) {
            $dictamen = Dictamen_Exportacion::find($attributes['id_dictamen']);
            if ($dictamen && $dictamen->inspeccione && $dictamen->inspeccione->solicitud && $dictamen->inspeccione->solicitud->empresa) {
                $empresa = $dictamen->inspeccione->solicitud->empresa->razon_social;
            }
        }

        $observaciones = null;
        if ($obs) {
            $parsed = json_decode($obs, true);
            if (json_last_error() === JSON_ERROR_NONE && isset($parsed['id_sustituye'])) {
                $cert_sust = Certificado_Exportacion::find($parsed['id_sustituye']);
                $num_sustituido = optional($cert_sust)->num_certificado ?? 'Desconocido';
                $observaciones = "Sustituye al certificado: <span class='badge bg-secondary'>$num_sustituido</span>";
            } else {
                $observaciones = $obs;
            }
        }

        $revisor = isset($attributes['id_revisor']) 
            ? User::find($attributes['id_revisor'])->name ?? null 
            : null;

        $certificadoRevision = null;
        $id_revision = null;
        if (isset($attributes['id_certificado'], $attributes['id_revisor'])) {
            $certificadoRevision = Revisor::where([
                ['id_certificado', $attributes['id_certificado']],
                ['id_revisor', $attributes['id_revisor']]
            ])->first();
            $id_revision = $certificadoRevision->id_revision ?? null;
        }

        
    //VO.BO.
        $voboPersonalHtml = '';
        $voboClienteHtml = '';
        $personalMostrado = false;
        $clienteMostrado = false;
        $motivoCancelado='';

        if ($log->subject_type === 'App\Models\Certificado_Exportacion') {
            $certificado = Certificado_Exportacion::find($attributes['id_certificado'] ?? null);

            if ($certificado && $certificado->vobo) {
                $voboData = json_decode($certificado->vobo, true);

                foreach ($voboData as $item) {
                    if (!$personalMostrado && isset($item['id_personal'])) {
                        $usuario = User::find($item['id_personal']);
                        $voboPersonalHtml = "<p><b>Personal:</b> {$usuario->name} solicitó revisión.<br><b>Descripción:</b> {$item['descripcion']}</p>";
                        $personalMostrado = true;
                    }

                    if (!$clienteMostrado && isset($item['id_cliente'])) {
                        $usuario = User::find($item['id_cliente']);
                        $estado = $item['respuesta'] == 1 ? 'Aprobado' : 'No aprobado';
                        $voboClienteHtml = "<p><b>Cliente:</b> {$usuario->name} dio Vo.Bo.<br><b>Respuesta:</b> $estado<br><b>Descripción:</b> {$item['descripcion']}</p>";
                        $clienteMostrado = true;
                    }
                }
            }
            $obsCancelado = json_decode($certificado->observaciones, true);
            $motivoCancelado = $obsCancelado['observaciones'] ?? null;
        }



    // Construcción del contenido para mostrar
        
        $contenido = '';
        if ( $log->subject_type === 'App\Models\Certificado_Exportacion' && $attributes['estatus'] == 1 ) {
            $contenido .= "<span class='badge bg-danger'>CANCELADO</span>, <b>Motivo de la cancelación:</b> $motivoCancelado ";
        }
        
        if ($num_certificado) {
            $contenido .= "<b>Número del certificado:</b> <span class='badge bg-secondary'>$num_certificado</span>";
        }
        if ($empresa) {
            $contenido .= ", <b>Cliente:</b> $empresa ";
        }

        if ($evento === 'created') {
            if ($num_revision) {
                $contenido .= "<b>Revisión:</b> $num_revision";
            }
            if ($revisor) {
                $contenido .= ", <b>Persona asignada:</b> $revisor";
            }
            if ($observaciones) {
                $contenido .= ", <b>Observaciones para el revisor:</b> $observaciones";
            }
        }

        $bitacora = '';
        if ($evento === 'updated' && $num_revision == 1) {
            if ($num_revision) {
                $contenido .= "<b>Revisión:</b> $num_revision realizada";
            }
            if ($decision) {
                $contenido .= ", <b>Resultado:</b> $decision";
            }
            if ($obs) {
                $contenido .= ", <b>Observaciones:</b> $obs";
            }
            if ( $decision != 'Pendiente') {
            $bitacora .= "
                <i class='ri-file-pdf-2-fill text-danger ri-40px cursor-pointer pdf'
                   data-bs-target='#mostrarPdf'
                   data-bs-toggle='modal'
                   data-bs-dismiss='modal'
                   data-num-certificado='$num_cer'
                   data-id='$id_revision'
                   data-tipo_revision='$tipo_revision'>
                </i>";
            }
        }

        if ($num_revision && $num_revision == 2 && $decision == 'Pendiente') {
            if ($num_revision) {
                $contenido .= "<b>Revisión:</b> $num_revision";
            }
            if ($revisor) {
                $contenido .= ", <b>Persona asignada:</b> $revisor";
            }
            if ($observaciones) {
                $contenido .= ", <b>Observaciones para el revisor:</b> $observaciones";
            }
        }

        $bitacora2 = '';
        if ($num_revision && $num_revision == 2 && $decision == 'positiva') {
            if ($num_revision) {
                $contenido .= "<b>Revisión:</b> $num_revision realizada";
            }
            if ($decision) {
                $contenido .= ", <b>Resultado:</b> $decision";
            }
            if ($obs) {
                $contenido .= ", <b>Observaciones:</b> $obs";
            }
            if ( $decision != 'Pendiente') {
            $bitacora2 .= "
                <i class='ri-file-pdf-2-fill text-danger ri-40px cursor-pointer pdf'
                   data-bs-target='#mostrarPdf'
                   data-bs-toggle='modal'
                   data-bs-dismiss='modal'
                   data-num-certificado='$num_certificado'
                   data-id='$id_revision'
                   data-tipo_revision='$tipo_revision'>
                </i>";
            }
        }


    // Orden personalizado
    $orden_personalizado = 99;
        if ($log->subject_type === 'App\Models\Certificado_Exportacion' && $evento === 'created') {
            $orden_personalizado = 1;
        }

        if ($log->subject_type === 'App\Models\Revisor') {
            //1era revision OC
            if ($tipo_revision == 1 && $num_revision == 1 && $decision == 'Pendiente') $orden_personalizado = 2;
            if ($tipo_revision == 1 && $num_revision == 1 && $decision != 'Pendiente') $orden_personalizado = 3;
            //1era revision CONSEJO
            if ($tipo_revision == 2 && $num_revision == 1 && $decision == 'Pendiente') $orden_personalizado = 13;//CODIGO AJUSTADO para 3 correcciones 
            if ($tipo_revision == 2 && $num_revision == 1 && $decision != 'Pendiente') $orden_personalizado = 14;
            //2da revision OC
            if ($tipo_revision == 1 && $num_revision == 2 && $decision == 'Pendiente') $orden_personalizado = 24;
            if ($tipo_revision == 1 && $num_revision == 2 && $decision != 'Pendiente') $orden_personalizado = 25;
            //2da revision CONSEJO
            if ($tipo_revision == 2 && $num_revision == 2 && $decision == 'Pendiente') $orden_personalizado = 35;
            if ($tipo_revision == 2 && $num_revision == 2 && $decision != 'Pendiente') $orden_personalizado = 36;
        }

    //si hay correcciones en 1er Revision OC
    if ($es_correccion == 'si' && $tipo_revision == 1 && $num_revision == 1) {
        $respuestas = json_decode($log->properties['attributes']['respuestas'] ?? '[]', true);
        $decision = $attributes['decision'] ?? null;
        $num = is_array($respuestas) ? count($respuestas) : 0;//Esto cuenta cuántas correcciones hay.
        //si { "Revision 1": ..., "Revision 2": ... } - Entonces $num vale 2.
    /* Ejemplos: Asignación (Pendiente)
    Si hay 0 respuestas aún (es la 1ra corrección):
        4 + (0 * 2) = 4
    Si hay 1 respuesta ya registrada (vas por la 2da corrección):
        4 + (1 * 2) = 6

    Ejemplos: Resultado (negativa o positiva)
    Si estás cerrando la 1ra corrección (hay 1 respuesta ya hecha):
        5 + ((1-1) * 2) = 5
    Si estás cerrando la 2da corrección (hay 2 respuestas):
        5 + ((2-1) * 2) = 7
    Si estás cerrando la 3ra corrección:
        5 + ((3-1) * 2) = 9

    Los números pares (4, 6, 8, ...) son asignaciones.
    Los números impares (5, 7, 9, ...) son resultados.
    Esto asegura que el orden sea consistente y que siempre estén agrupadas correctamente. */
        if ($decision == 'Pendiente') $orden_personalizado = 4 + ($num * 2);
        if ($decision == 'negativa') $orden_personalizado = 5 + (($num - 1) * 2);
        if ($decision == 'positiva') $orden_personalizado = 5 + (($num - 1) * 2);
    }

    //si hay correcciones en 1er Revision CONSEJO
    if ($es_correccion == 'si' && $tipo_revision == 2 && $num_revision == 1) {
        $respuestas = json_decode($log->properties['attributes']['respuestas'] ?? '[]', true);
        $decision = $attributes['decision'] ?? null;
        $num = is_array($respuestas) ? count($respuestas) : 0;
        if ($decision == 'Pendiente') $orden_personalizado = 15 + ($num * 2);
        if ($decision == 'negativa') $orden_personalizado = 16 + (($num - 1) * 2);
        if ($decision == 'positiva') $orden_personalizado = 16 + (($num - 1) * 2);
    }


        return [
            'description' => $log->description,
            'properties' => $log->properties,
            'created_at' => $log->created_at->toDateTimeString(),
            'contenido' => trim($contenido),
            'bitacora' => $bitacora,
            'bitacora2' => $bitacora2,
            'vobo_personal' => $voboPersonalHtml,
            'vobo_cliente' => $voboClienteHtml,
            'orden_personalizado' => $orden_personalizado,
            'tipo_bloque' => $this->determinarTipoBloque($log, $attributes), // NUEVO
        ];
    });


// Insertar log dinámico "creado" AL PRINCIPIO si tipo_certificado es 1 o 2 
$primerLog = $logs->first();
$tipoCertificado = $primerLog['properties']['attributes']['tipo_certificado'] ?? null;
$esAsignacionInicial = $primerLog['tipo_bloque'] === 'asignacion';
// Obtenemos el certificado para mostrar su número (si existe)
$idCertificado = $primerLog['properties']['attributes']['id_certificado'] ?? null;

// Según el tipo de certificado, buscamos en el modelo correspondiente
$certificado2 = null;
if ($tipoCertificado == 1) {
    $certificado2 = Certificados::find($idCertificado);
} elseif ($tipoCertificado == 2) {
    $certificado2 = CertificadosGranel::find($idCertificado);
}

$numCertificado = $certificado2->num_certificado ?? '';
$empresa = $certificado2->dictamen->inspeccione->solicitud->empresa->razon_social ?? '';


if ($esAsignacionInicial && in_array($tipoCertificado, [1, 2])) {
    
    $descripcion = $tipoCertificado == 1
        ? 'Generación del certificado INSTALACIONES '.$numCertificado
        : 'Generación del certificado GRANEL '.$numCertificado;

/*if ($certificado2 && $certificado2->estatus==1) {
    $obsCancelado2 = json_decode($certificado2->observaciones, true);
    $motivoCancelado2 = $obsCancelado['observaciones'] ?? null;
    $descripcion = 'Cancelacion del certificado '.$numCertificado;
    $contenido = "<span class='badge bg-danger'>CANCELADO</span>, <b>Motivo de la cancelación:</b> $motivoCancelado2";
}*/

    $logs->prepend([
        'description' => $descripcion,
        'properties' => ['attributes' => ['tipo_certificado' => $tipoCertificado]],
        'created_at' => $primerLog['created_at'],
        'contenido' => '<b>Número del certificado:</b> <span class="badge bg-secondary">'.$numCertificado. '</span>, <b>Cliente:</b> '.$empresa,
        'bitacora' => '',
        'bitacora2' => '',
        'vobo_personal' => '',
        'vobo_cliente' => '',
        'orden_personalizado' => 1,
        'tipo_bloque' => 'registro',
    ]);
}


//Insertar log dinámico "cancelado" AL FINAL si tipo_certificado es 1 o 2 
$ultimoLog = $logs->last();
$tipoCertificado = $ultimoLog['properties']['attributes']['tipo_certificado'] ?? null;
$idCertificado = $ultimoLog['properties']['attributes']['id_certificado'] ?? null;

$certificadoCancelado = null;
if ($tipoCertificado == 1) {
    $certificadoCancelado = Certificados::find($idCertificado);
} elseif ($tipoCertificado == 2) {
    $certificadoCancelado = CertificadosGranel::find($idCertificado);
} 

if ($certificadoCancelado && $certificadoCancelado->estatus == 1) {
    $numCertificado = $certificadoCancelado->num_certificado ?? '';
    $empresa = $certificadoCancelado->dictamen->inspeccione->solicitud->empresa->razon_social ?? '';
    $obsCancelado = json_decode($certificadoCancelado->observaciones, true);
    $motivo = $obsCancelado['observaciones'] ?? 'Sin motivo registrado';

    $logs->push([
        'description' => 'Cancelación del certificado ' . $numCertificado,
        'properties' => ['attributes' => ['tipo_certificado' => $tipoCertificado]],
        'created_at' => $ultimoLog['created_at'],
        'contenido' => "<span class='badge bg-danger'>CANCELADO</span>, <b>Motivo de la cancelación:</b> $motivo, <b>Número del certificado:</b> <span class='badge bg-secondary'>$numCertificado</span>, <b>Cliente:</b> $empresa",
        'bitacora' => '',
        'bitacora2' => '',
        'vobo_personal' => '',
        'vobo_cliente' => '',
        'orden_personalizado' => 999,
        'tipo_bloque' => 'cancelado',
    ]);
}



    $logs = $logs->sortBy('orden_personalizado')->values();

    return response()->json(['success' => true, 'logs' => $logs]);
}






}
