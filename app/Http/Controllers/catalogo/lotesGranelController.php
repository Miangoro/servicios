<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LotesGranel;
use App\Models\empresa;
use App\Models\categorias;
use App\Models\clases;
use App\Models\Documentacion;
use App\Models\Documentacion_url;
use App\Models\tipos;
use App\Models\organismos;
use App\Models\Guias;
use App\Models\LotesGranelGuia;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;//Permiso empresa


class lotesGranelController extends Controller
{
    public function UserManagement(Request $request)
    {// Encuentra el lote a granel por ID
        $empresas = empresa::with('empresaNumClientes')->where('tipo', 2)->get();
        $categorias = categorias::all();
        $clases = clases::all();
        $tipos = tipos::all(); // Obtén todos los tipos de agave
        $organismos = organismos::all(); // Obtén todos los organismos, aquí usa 'organismos' en minúscula
        $guias = Guias::all(); // Obtén todas las guías
        $lotes = LotesGranel::with('empresa', 'categoria', 'clase', 'tipos', 'organismo', 'guias','certificadoGranel')->get();
        $documentos = Documentacion::where('id_documento', '=', '58')->get();
        return view('catalogo.lotes_granel', compact('lotes', 'empresas', 'categorias', 'clases', 'tipos', 'organismos', 'guias', 'documentos'));
    }


    public function index(Request $request)
    {
        try {
            $columns = [
                1 => 'id_lote_granel',
                2 => 'nombre_lote',
                3 => 'tipo_lote',
                4 => 'folio_fq',
                5 => 'volumen',
                6 => 'cont_alc',
                7 => 'id_categoria',
                8 => 'id_clase',
                9 => 'id_tipo',
                10 => 'ingredientes',
                11 => 'edad',
                12 => 'folio_certificado',
                13 => 'id_organismo',
                14 => 'fecha_emision',
                15 => 'fecha_vigencia',
                16 => 'estatus',
            ];

            //Permiso de empresa
            $empresaId = null;
            if (Auth::check() && Auth::user()->tipo == 3) {
                $empresaId = Auth::user()->empresa?->id_empresa;
            }

            $search = $request->input('search.value');
            $totalData = LotesGranel::count();
            $totalFiltered = $totalData;
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
          $LotesGranel = LotesGranel::with(['empresa', 'categoria', 'clase', 'tipos', 'Organismo','certificadoGranel','fqs'])
              ->when($empresaId, function ($query) use ($empresaId) {
                  $query->where('id_empresa', $empresaId);
              })
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
            $q->where('id_lote_granel', 'LIKE', "%{$search}%")
            ->orWhere('nombre_lote', 'LIKE', "%{$search}%")
            ->orWhere('folio_fq', 'LIKE', "%{$search}%")
            ->orWhere('volumen', 'LIKE', "%{$search}%")
            ->orWhere('cont_alc', 'LIKE', "%{$search}%")
            ->orWhere('folio_certificado', 'LIKE', "%{$search}%")
            ->orWhereHas('empresa', function ($subQuery) use ($search) {
                $subQuery->where('razon_social', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('empresa.empresaNumClientes', function ($subQuery) use ($search) {
                $subQuery->where('numero_cliente', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('Organismo', function ($subQuery) use ($search) {
                $subQuery->where('organismo', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('categoria', function ($subQuery) use ($search) {
                $subQuery->where('categoria', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('clase', function ($subQuery) use ($search) {
                $subQuery->where('clase', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('tipos', function ($subQuery) use ($search) {
                $subQuery->where('nombre', 'LIKE', "%{$search}%");
            })
            ->orWhere('ingredientes', 'LIKE', "%{$search}%")
            ->orWhereRaw("CASE
                WHEN tipo_lote = 1 THEN 'Certificado por OC CIDAM'
                WHEN tipo_lote = 2 THEN 'Certificado por otro organismo'
            END LIKE ?", ["%{$search}%"]);
             });
    })
    ->offset($start)
    ->limit($limit)
    ->orderBy($order, $dir)
    ->get();


            $totalFiltered = LotesGranel::when($empresaId, function ($query) use ($empresaId) {
        return $query->where('id_empresa', $empresaId);
    })
    ->when($search, function ($query, $search) {
                return $query->where('id_lote_granel', 'LIKE', "%{$search}%")
                    ->orWhere('nombre_lote', 'LIKE', "%{$search}%")
                    ->orWhere('folio_fq', 'LIKE', "%{$search}%")
                    ->orWhere('volumen', 'LIKE', "%{$search}%")
                    ->orWhere('cont_alc', 'LIKE', "%{$search}%")
                    ->orWhere('folio_certificado', 'LIKE', "%{$search}%")
                    ->orWhereHas('empresa.empresaNumClientes', function ($subQuery) use ($search) {
                        $subQuery->where('numero_cliente', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('Organismo', function ($subQuery) use ($search) {
                        $subQuery->where('organismo', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('categoria', function ($subQuery) use ($search) {
                        $subQuery->where('categoria', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('clase', function ($subQuery) use ($search) {
                        $subQuery->where('clase', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('tipos', function ($subQuery) use ($search) {
                        $subQuery->where('nombre', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('ingredientes', 'LIKE', "%{$search}%")
                    ->orWhereRaw("CASE
                    WHEN tipo_lote = 1 THEN 'Certificado por OC CIDAM'
                    WHEN tipo_lote = 2 THEN 'Certificado por otro organismo'
                END LIKE ?", ["%{$search}%"]);

            })->count();



            $data = [];
            if (!empty($LotesGranel)) {
                $ids = $start;
                $tipos = tipos::all();
                $tiposNombres = $tipos->pluck('nombre', 'id_tipo')->toArray();

                foreach ($LotesGranel as $lote) {
                    $nestedData['id_lote_granel'] = $lote->id_lote_granel ?? 'N/A';
                    $nestedData['fake_id'] = ++$ids ?? 'N/A'; // Incremental ID

                    $razonSocial = $lote->empresa ? $lote->empresa->razon_social : '';
                    $numeroCliente =
                    $lote->empresa->empresaNumClientes[0]->numero_cliente ??
                    $lote->empresa->empresaNumClientes[1]->numero_cliente ??
                    $lote->empresa->empresaNumClientes[2]->numero_cliente;

                    $nestedData['id_empresa'] = '<b>'.$numeroCliente . '</b><br>' . $razonSocial;
                    $nestedData['nombre_lote'] = '<span class="fw-bold text-dark h5">'.$lote->nombre_lote.'</span>' ?? 'N/A';
                    $nestedData['tipo_lote'] = $lote->tipo_lote ?? 'N/A';
                    $nestedData['folio_fq'] = $lote->folio_fq ?? 'N/A';
                    $nestedData['volumen'] = $lote->volumen ?? 'N/A';
                    $nestedData['volumen_restante'] = $lote->volumen_restante ?? 'N/A';
                    $nestedData['cont_alc'] = $lote->cont_alc.'% Alc. Vol.' ?? 'N/A';
                    $nestedData['id_categoria'] = $lote->categoria->categoria ?? 'N/A';
                    $nestedData['id_clase'] = $lote->clase->clase ?? 'N/A';

                    if ($lote->id_tipo && $lote->id_tipo !== 'N/A') {
                      $idTipo = json_decode($lote->id_tipo, true);
                      if (is_array($idTipo)) {
                          $nombresTipos = array_map(function($tipoId) use ($tiposNombres) {
                              return $tiposNombres[$tipoId] ?? 'Desconocido';
                          }, $idTipo);
                          $nestedData['id_tipo'] = implode(', ', $nombresTipos);
                      } else {
                          $nestedData['id_tipo'] = 'Desconocido';
                      }
                  } else {
                      $nestedData['id_tipo'] = 'N/A';
                  }
                    $nestedData['ingredientes'] = $lote->ingredientes ?? 'N/A';
                    $nestedData['edad'] = $lote->edad ?? 'N/A';
                    $nestedData['folio_certificado'] = $lote->folio_certificado ?? 'N/A';
                    $nestedData['id_organismo'] = $lote->organismo->organismo ?? '';
                    $nestedData['fecha_emision'] = Helpers::formatearFecha($lote->fecha_emision) ?? 'N/A';
                    $nestedData['fecha_vigencia'] = Helpers::formatearFecha($lote->fecha_vigencia) ?? 'N/A';
                    $nestedData['estatus'] = $lote->estatus;
                    $nestedData['folio_certificado_oc'] = $lote->certificadoGranel->num_certificado ?? 'N/A';
                    $folios = explode(',', $lote->folio_fq); // Divide los folios en un array
                    $documentoCompleto = $lote->fqs->firstWhere('id_documento', 58);
                    $documentoAjuste = $lote->fqs->firstWhere('id_documento', 134);
                    $nestedData['folio_fq_completo'] = $folios[0] ?? 'N/A';
                    $nestedData['folio_fq_ajuste'] = $folios[1] ?? 'N/A';

                    $nestedData['url_fq_completo'] = $documentoCompleto
                        ? '/files/' . $numeroCliente . '/fqs/' . $documentoCompleto->url
                        : '';

                    $nestedData['url_fq_ajuste'] = $documentoAjuste
                        ? '/files/' . $numeroCliente . '/fqs/' . $documentoAjuste->url
                        : '';



              if ($lote->lote_original_id) {
                  $lotesOriginales = json_decode($lote->lote_original_id, true);

                  if (isset($lotesOriginales['lotes'])) {
                      $idsLotes = $lotesOriginales['lotes'];

                      // Obtener todos los lotes involucrados
                      $lotes = LotesGranel::whereIn('id_lote_granel', $idsLotes)->get();

                      // Obtener todos los documentos (completo o ajuste) en un solo query
                      $documentos = Documentacion_url::whereIn('id_relacion', $idsLotes)
                          ->whereIn('id_documento', [58, 134])
                          ->get()
                          ->groupBy(function ($doc) {
                              return "{$doc->id_relacion}_{$doc->id_documento}";
                          });

                      // Obtener el número de cliente para la ruta
                      $empresa = Empresa::with("empresaNumClientes")->where("id_empresa", $lote->id_empresa)->first();
                      $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($n) {
                          return !empty($n);
                      });
                        $detallesLotes = $lotes->map(function ($loteItem) use ($documentos) {
                            $folioFq = $loteItem->folio_fq;
                            $folioPartes = explode(',', $folioFq);

                            // Obtener empresa y número de cliente del lote de procedencia
                            $empresa = Empresa::with("empresaNumClientes")->where("id_empresa", $loteItem->id_empresa)->first();
                            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($n) {
                                return !empty($n);
                            });

                            $urlCompleto = $documentos->get("{$loteItem->id_lote_granel}_58")?->first()?->url;
                            $urlAjuste = $documentos->get("{$loteItem->id_lote_granel}_134")?->first()?->url;

                            $folioCompleto = '';
                            $folioAjuste = '';

                            if (count($folioPartes) === 1) {
                                $folio = trim($folioPartes[0]);
                                $folioCompleto = $urlCompleto
                                    ? "<a href='/files/{$numeroCliente}/fqs/" . rawurlencode($urlCompleto) . "' class='text-info text-decoration-underline' target='_blank' title='Ver documento'>{$folio}</a>"
                                    : $folio;
                            } elseif (count($folioPartes) === 2) {
                                $parte1 = trim($folioPartes[0]);
                                $parte2 = trim($folioPartes[1]);

                                if (!empty($parte1)) {
                                    $folioCompleto = $urlCompleto
                                        ? "<a href='/files/{$numeroCliente}/fqs/" . rawurlencode($urlCompleto) . "' class='text-info text-decoration-underline' target='_blank' title='Ver documento'>{$parte1}</a>"
                                        : $parte1;
                                }

                                if (!empty($parte2)) {
                                    $folioAjuste = $urlAjuste
                                        ? "<a href='/files/{$numeroCliente}/fqs/" . rawurlencode($urlAjuste) . "' class='text-info text-decoration-underline' target='_blank' title='Ver documento'>{$parte2}</a>"
                                        : $parte2;
                                }
                            }

                            $foliosTexto = trim(implode(', ', array_filter([$folioCompleto, $folioAjuste])));

                            return "{$loteItem->nombre_lote} ({$loteItem->cont_alc} %) {$foliosTexto}";
                        });



                      $nestedData['lote_procedencia'] = implode('<br>', $detallesLotes->toArray());

                  } else {
                      $nestedData['lote_procedencia'] = 'Lote de procedencia: No tiene lotes disponibles en el JSON.';
                  }
              } else {
                  $nestedData['lote_procedencia'] = 'No tiene procedencia de otros lotes.';
              }

                    /*  */
                        // Consulta la URL en la tabla Documentacion_url
                    // Obtén la URL del certificado desde la tabla Documentacion_url
                    $documentacion = Documentacion_url::where('id_relacion', $lote->id_lote_granel)->where('id_documento',59)->first();
                      // Obtener el número de cliente
                      $empresa = Empresa::with("empresaNumClientes")->where("id_empresa", $lote->id_empresa)->first();

                      $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                        return !empty($numero);
                    });

                      // Ahora puedes usar el número de cliente en la URL
                      if ($documentacion) {
                          $nestedData['url_certificado'] = '/files/' . $numeroCliente . '/certificados_granel/' . rawurlencode($documentacion->url);
                      } else {
                          $nestedData['url_certificado'] = null;
                      }

                    /*  */
                    $nestedData['actions'] = '<button class="btn btn-danger btn-sm delete-record" data-id="' . $lote->id_lote_granel . '">Eliminar</button>';

                    $data[] = $nestedData;
                }

            }

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'code' => 200,
                'data' => $data,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Error al procesar la solicitud.'
            ]);
        }
    }


    public function getLotesList(Request $request)
    {
        $columns = ['id_lote', 'num_clientes', 'nombre_cliente', 'tipo', 'no_lote', 'categoria', 'clase', 'no_analisis', 'tipo_maguey', 'volumen', 'cont_alc'];

        //$query = Lote::query();
        $query = LotesGranel::query();

        // Filtrar y ordenar
        if ($request->has('search') && $request->input('search')['value']) {
            $search = $request->input('search')['value'];
            $query->where(function ($q) use ($search, $columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%$search%");
                }
            });
        }

        $totalData = $query->count();
        $totalFiltered = $totalData;

        $query->skip($request->input('start', 0))
            ->take($request->input('length', 10));

        $data = $query->get();

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }




    public function destroy($id_lote_granel)
    {
        try {
            $lote = LotesGranel::findOrFail($id_lote_granel);
            $lote->delete();

            return response()->json(['success' => 'Lote eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el lote'], 500);
        }
    }



    public function store(Request $request)
    {
      /* dd($request->all(), $request->file('documentos')); */

        $validatedData = $request->validate([
            'id_empresa' => 'required|exists:empresa,id_empresa',
            'nombre_lote' => 'required|string|max:70',
            'id_tanque' => 'nullable|string|max:100',
            'tipo_lote' => 'required|integer',
            'volumen' => 'required|numeric',
            'cont_alc' => 'required|numeric',
            'id_categoria' => 'required|integer|exists:catalogo_categorias,id_categoria',
            'id_clase' => 'required|integer|exists:catalogo_clases,id_clase',
            'id_tipo' => 'required|array',
            'id_tipo.*' => 'integer|exists:catalogo_tipo_agave,id_tipo',
            'ingredientes' => 'nullable|string|max:100',
            'edad' => 'nullable|string|max:30',
            'folio_certificado' => 'nullable|string|max:50',
            'id_organismo' => 'nullable|integer|exists:catalogo_organismos,id_organismo',
            'fecha_emision' => 'nullable|date',
            'fecha_vigencia' => 'nullable|date',
            'url.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'folio_fq_completo' => 'nullable|string|max:50',
            'folio_fq_ajuste' => 'nullable|string|max:50',
            'folio_fq' => 'nullable|string|max:70',
            'es_creado_a_partir' => 'required|string',
            'lote_original_id' => 'nullable',
            'id_lote_granel.*' => 'nullable|integer',
            'volumen_parcial.*' => 'nullable|numeric',
            ] + ($request->input('tipo_lote') == 1 ? [
              'id_guia' => 'nullable|array',
              'id_guia.*' => 'integer|exists:guias,id_guia',
          ] : [
              'id_guia' => 'nullable|array',
              'id_guia.*' => 'integer|exists:guias,id_guia',
          ]));

        // Crear una nueva instancia del modelo LotesGranel
        $lote = new LotesGranel();
        $lote->id_empresa = $validatedData['id_empresa'];
        $lote->id_tanque = $validatedData['id_tanque'];
        $lote->nombre_lote = $validatedData['nombre_lote'];
        $lote->tipo_lote = $validatedData['tipo_lote'];
        $lote->volumen = $validatedData['volumen'];
        $lote->volumen_restante = $validatedData['volumen'];
        $lote->cont_alc = $validatedData['cont_alc'];
        $lote->id_categoria = $validatedData['id_categoria'];
        $lote->id_clase = $validatedData['id_clase'];
        $lote->id_tipo = json_encode($validatedData['id_tipo']);

        $lote->ingredientes = $validatedData['ingredientes'] ?? null;
        $lote->edad = $validatedData['edad'] ?? null;
        $lote->folio_certificado = $validatedData['folio_certificado'] ?? 'Sin certificado';
        $lote->id_organismo = $validatedData['id_organismo'] ?? null;
        $lote->fecha_emision = $validatedData['fecha_emision'] ?? null;
        $lote->fecha_vigencia = $validatedData['fecha_vigencia'] ?? null;

        $folio_fq_Completo = $validatedData['folio_fq_completo'] ?? ' ';
        $folio_fq_ajuste = $validatedData['folio_fq_ajuste'] ?? ' ';

    // Validar si es creado a partir de otro lote
    if ($validatedData['es_creado_a_partir'] === 'si') {
      $idLotes = [];
      $volumenesParciales = [];

      // Recoger los lotes y volúmenes del request
        // Recoger los lotes y volúmenes del request
        foreach ($request->input('lote', []) as $index => $loteData) {
        $idLotes[] = $loteData['id'] ?? null;
        $volumenesParciales[] = $request->input("volumenes.{$index}.volumen_parcial") ?? null;

        }
      // Validar que no haya lotes o volúmenes nulos
      if (in_array(null, $idLotes)) {
          return response()->json([
              'success' => false,
              'message' => 'Los lotes deben ser válidos.',
              'debug' => [
                  'idLotes' => $idLotes,
                  'volumenesParciales' => $volumenesParciales
              ]
          ], 400);
      }

      // Guardar los lotes y volúmenes en JSON para el registro
      $lote->lote_original_id = json_encode([
          'lotes' => $idLotes,
          'volumenes' => $volumenesParciales,
      ]);

      // Procesar cada lote original y restar el volumen parcial
      foreach ($idLotes as $index => $loteId) {
          $volumenParcial = $volumenesParciales[$index];
          $loteOriginal = LotesGranel::find($loteId);

          if ($loteOriginal) {
              if ($volumenParcial !== null) {
                  // Restar volumen parcial si es válido
                  $loteOriginal->volumen_restante -= $volumenParcial;

                  // Verificar que el volumen no sea negativo
                  if ($loteOriginal->volumen_restante < 0) {
                      return response()->json([
                          'success' => false,
                          'message' => 'El volumen del lote original no puede ser negativo.'
                      ], 400);
                  }
              }

              // Guardar el lote original actualizado
              $loteOriginal->save();
          }
      }
  }

        // Verificar si ambos campos son espacios o vacíos
        if (trim($folio_fq_Completo) === '' && trim($folio_fq_ajuste) === '') {
            $lote->folio_fq = 'Sin FQ'; // Asignar 'Sin FQ' si ambos están vacíos
        } else {
            // Concatenar los valores si alguno tiene contenido
            if (!empty($folio_fq_ajuste)) {
                $folio_fq_Completo .= ',' . $folio_fq_ajuste;
            }
            $lote->folio_fq = $folio_fq_Completo;
        }


        // Guardar el nuevo lote en la base de datos
        $lote->save();


        // Almacenar las guías en la tabla intermedia usando el modelo LotesGranelGuia
        if (isset($validatedData['id_guia'])) {
            foreach ($validatedData['id_guia'] as $idGuia) {
                LotesGranelGuia::create([
                    'id_lote_granel' => $lote->id_lote_granel,
                    'id_guia' => $idGuia
                ]);
            }
        }

        // Obtener el número de cliente
        $empresa = Empresa::with("empresaNumClientes")->where("id_empresa", $lote->id_empresa)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });

if ($request->has('documentos')) {
    foreach ($request->documentos as $index => $documento) {
        if (
            isset($documento['url']) &&
            $documento['url'] instanceof \Illuminate\Http\UploadedFile &&
            $documento['url']->isValid()
        ) {
            $file = $documento['url'];
           $idDoc = (int) $documento['id_documento']; // 🔥 fuerza a entero
            $nombreDocumento = $documento['nombre_documento'] ?? null;

            // Decide carpeta y nombre según id_documento
            $carpeta = match($idDoc) {
                58, 134 => 'fqs',
                59 => 'certificados_granel',
                default => 'otros',
            };

            $nombre_documento = match($idDoc) {
                58 => 'Análisis fisicoquímicos',
                59 => 'Certificado de lote a granel',
                134 => 'Fisicoquímicos de ajuste de grado',
                default => $nombreDocumento ?? 'Desconocido',
            };

            $uniqueId = uniqid();
            $prefix = match($idDoc) {
                58 => 'analisis_fisicoquimicos',
                59 => 'certificado_granel',
                134 => 'fisicoquimicos_ajuste_grado',
                default => 'documento',
            };

            $filename = $prefix . '_' . $uniqueId . '.' . $file->getClientOriginalExtension();
            $numeroCliente = Empresa::with("empresaNumClientes")
                ->where("id_empresa", $lote->id_empresa)
                ->first()
                ->empresaNumClientes
                ->pluck('numero_cliente')
                ->first(fn($num) => !empty($num));

            $filePath = $file->storeAs("uploads/{$numeroCliente}/{$carpeta}", $filename, 'public');

            $documentacion_url = new Documentacion_url();
            $documentacion_url->id_relacion = $lote->id_lote_granel;
            $documentacion_url->id_documento = $idDoc;
            $documentacion_url->nombre_documento = $nombre_documento;
            $documentacion_url->url = $filename;
            $documentacion_url->id_empresa = $lote->id_empresa;
            $documentacion_url->save();
        }
    }
}


        // Retornar una respuesta
        return response()->json([
            'success' => true,
            'message' => 'Lote registrado exitosamente',
        ]);

    }



      public function getVolumen($id_lote_granel){
          // Encuentra el lote por su ID
          $lote = LotesGranel::find($id_lote_granel);

          // Verifica si el lote existe
          if ($lote) {
              // Devuelve el volumen_restante en formato JSON
              return response()->json(['volumen_restante' => $lote->volumen_restante]);
          } else {
              // Si no se encuentra el lote, devuelve un error 404
              return response()->json(['error' => 'Lote no encontrado'], 404);
          }
      }

    public function edit($id_lote_granel)
    {
        try {
            // Cargar el lote y las guías asociadas
            $lote = LotesGranel::with('lotesGuias.guia')->findOrFail($id_lote_granel);

            $organismo = null; // Inicializar como null
            if ($lote->id_organismo) {
              $organismo = organismos::find($lote->id_organismo);
            }

            // Obtener los documentos asociados
            $documentos = Documentacion_url::where('id_relacion', $id_lote_granel)
            ->where(function ($query) {
                $query->where('id_documento', 58)
                      ->orWhere('id_documento', 134)->orWhere('id_documento', 59);
            })
            ->get();


            // Extraer la URL de los documentos
            $documentosConUrl = $documentos->map(function ($documento) {
                return [
                    'id' => $documento->id,
                    'id_documento' => $documento->id_documento,
                    'nombre' => $documento->nombre_documento,
                    'url' => $documento->url,
                    'tipo' => $documento->nombre_documento
                ];
            });

            $empresa = Empresa::with("empresaNumClientes")->where("id_empresa", $lote->id_empresa)->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();

             // Obtener las guías asociadas con su ID y folio
             $guias = $lote->lotesGuias->map(function ($loteGuia) {
                if ($loteGuia->guia) {
                    return [
                        'id' => $loteGuia->guia->id_guia,
                        'folio' => $loteGuia->guia->folio,
                    ];
                }
                return null; // Si no hay una guía, devuelves null.
            })->filter(); // Filtras los valores null para que no aparezcan en la colección final.


            // Obtener la URL del archivo para "otro organismo"
            $archivoUrlOtroOrganismo = $lote->tipo_lote == '2' ? $lote->url_certificado : '';


          // Decodificar el campo JSON solo si no es nulo o vacío
          $lote_original_data = $lote->lote_original_id ? json_decode($lote->lote_original_id, true) : null;



          if ($lote_original_data && isset($lote_original_data['lotes']) && is_array($lote_original_data['lotes'])) {
              $lotes = $lote_original_data['lotes'];
              $volumenes = $lote_original_data['volumenes'];

              // Obtener los nombres de los lotes basados en los IDs
              $nombreLotes = [];
              foreach ($lotes as $idLote) {
                  $nombreLote = LotesGranel::find($idLote);
                  $nombreLotes[$idLote] = $nombreLote ? $nombreLote->nombre_lote : 'Lote no encontrado';
              }
          } else {
              // Si no hay datos en lote_original_id o no es un formato válido
              $lotes = [];
              $volumenes = [];
              $nombreLotes = [];
          }
            // Decodificar `id_tipo` si es JSON válido, o inicializarlo como array vacío
            $idTipoArray = $lote->id_tipo ? json_decode($lote->id_tipo, true) : [];
            $tipos = tipos::all();


            return response()->json([
                'success' => true,
                'lote' => $lote,
                'guias' => $guias, // Devuelve tanto los IDs como los folios
                'documentos' => $documentosConUrl,
                'numeroCliente' => $numeroCliente,
                'archivo_url_otro_organismo' => $archivoUrlOtroOrganismo,
                'organismo' => $organismo->id_organismo ?? null,
                'lotes' => $lotes,
                'volumenes' => $volumenes,
                'nombreLotes' => $nombreLotes,
                'id_tipo' => $idTipoArray, // Aquí tienes los ID
                'tipos' => $tipos, // Todos los tipos de agave
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false], 404);
        }
    }

    public function update(Request $request, $id_lote_granel)
  {
        try {
            // Validar los datos del formulario
            $validated = $request->validate([
                'nombre_lote' => 'required|string|max:255',
                'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                'id_tanque' => 'nullable|string|max:100',
                'tipo_lote' => 'required|integer',
                'id_guia' => 'nullable|array',
                'id_guia.*' => 'integer|exists:guias,id_guia',
                'volumen' => 'required|numeric',
                'cont_alc' => 'required|numeric',
                'id_categoria' => 'required|integer|exists:catalogo_categorias,id_categoria',
                'id_clase' => 'required|integer|exists:catalogo_clases,id_clase',
                'id_tipo' => 'required|array', // Acepta un array de `id_tipo`
                'id_tipo.*' => 'integer|exists:catalogo_tipo_agave,id_tipo',
                'ingredientes' => 'nullable|string',
                'edad' => 'nullable|string',
                'folio_certificado' => 'nullable|string',
                'id_organismo' => 'nullable|integer|exists:catalogo_organismos,id_organismo',
                'fecha_emision' => 'nullable|date',
                'fecha_vigencia' => 'nullable|date',
                'url.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
                'folio_fq_completo' => 'nullable|string|max:50',
                'folio_fq_ajuste' => 'nullable|string|max:50',
                'folio_fq' => 'nullable|string|max:50'
            ]);

            $lote = LotesGranel::findOrFail($id_lote_granel);
        // Si `lote_original_id` es nulo, inicializar `$lote_original_data` como un arreglo vacío
        $lote_original_data = $lote->lote_original_id ? json_decode($lote->lote_original_id, true) : ['lotes' => [], 'volumenes' => []];
        $lotesPrevios = $lote_original_data['lotes'];
        $volumenesPrevios = $lote_original_data['volumenes'];

      // Actualizar el lote principal
          $updateData = [
              'id_empresa' => $validated['id_empresa'],
              'id_tanque' => $validated['id_tanque'],
              'nombre_lote' => $validated['nombre_lote'],
              'tipo_lote' => $validated['tipo_lote'],
              'cont_alc' => $validated['cont_alc'],
              'id_categoria' => $validated['id_categoria'],
              'id_clase' => $validated['id_clase'],
              'id_tipo' => json_encode($validated['id_tipo']),
              'ingredientes' => $validated['ingredientes'],
              'edad' => $validated['edad'],
              'id_organismo' => $validated['id_organismo'] ?? null,
              'volumen' => $validated['volumen'],
              'volumen_restante' => $validated['volumen'],
          ];

          // Solo agregamos estos campos si **no** vienen nulos (o están presentes con valor)
          if (!is_null($validated['folio_certificado'])) {
              $updateData['folio_certificado'] = $validated['folio_certificado'];
          }
          if (!is_null($validated['fecha_emision'])) {
              $updateData['fecha_emision'] = $validated['fecha_emision'];
          }
          if (!is_null($validated['fecha_vigencia'])) {
              $updateData['fecha_vigencia'] = $validated['fecha_vigencia'];
          }

          // Actualizar
          $lote->update($updateData);



      // Obtener el número de cliente
      $empresa = Empresa::with("empresaNumClientes")->where("id_empresa", $lote->id_empresa)->first();
      $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
        return !empty($numero);
    });

 if ($request->has('documentos')) {
    foreach ($request->documentos as $index => $documento) {
        if (
            isset($documento['url']) &&
            $documento['url'] instanceof \Illuminate\Http\UploadedFile &&
            $documento['url']->isValid()
        ) {
            $file = $documento['url'];
            $idDoc = (int) $documento['id_documento'];
            $nombreDocumento = $documento['nombre_documento'] ?? null;

            // Eliminar archivo anterior
            $documentacionUrl = Documentacion_url::where('id_relacion', $lote->id_lote_granel)
                ->where('id_documento', $idDoc)
                ->first();

            if ($documentacionUrl) {
                $carpeta = ($idDoc === 59) ? 'certificados_granel' : 'fqs';
                $filePath = "uploads/{$numeroCliente}/{$carpeta}/{$documentacionUrl->url}";
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                $documentacionUrl->delete();
            }

            // Guardar nuevo archivo
            $carpeta = match($idDoc) {
                58, 134 => 'fqs',
                59 => 'certificados_granel',
                default => 'otros',
            };

            $nombre_base = match($idDoc) {
                58 => 'Análisis fisicoquímicos',
                134 => 'Fisicoquímicos de ajuste de grado',
                59 => 'Certificado de lote a granel',
                default => $nombreDocumento ?? 'Desconocido',
            };

            $prefix = match($idDoc) {
                58 => 'analisis_fisicoquimicos',
                134 => 'fisicoquimicos_ajuste_grado',
                59 => 'certificado_granel',
                default => 'documento',
            };

            $filename = $prefix . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            try {
                $filePath = $file->storeAs("uploads/{$numeroCliente}/{$carpeta}", $filename, 'public');
                Log::info('Archivo guardado', ['file' => $filename]);
            } catch (\Exception $e) {
                Log::error('Error al guardar archivo', ['error' => $e->getMessage()]);
                continue;
            }

            $doc = new Documentacion_url();
            $doc->id_relacion = $lote->id_lote_granel;
            $doc->id_documento = $idDoc;
            $doc->nombre_documento = $nombre_base;
            $doc->url = $filename;
            $doc->id_empresa = $lote->id_empresa;
            $doc->save();
        }
    }
}


      // Actualizar el campo folio_fq
            $folio_fq_Completo = $validated['folio_fq_completo'] ?? '';
            $folio_fq_ajuste = $validated['folio_fq_ajuste'] ?? '';

            if (!empty($folio_fq_Completo) || !empty($folio_fq_ajuste)) {
                $fqFinal = trim($folio_fq_Completo);
                if (!empty($folio_fq_ajuste)) {
                    $fqFinal .= ',' . trim($folio_fq_ajuste);
                }
                $lote->folio_fq = substr($fqFinal, 0, 50);
            }
      $lote->save();

        // Actualizar lotes relacionados solo si hay datos de 'edit_lotes' y 'edit_volumenes'
        if ($request->has('edit_lotes') && $request->has('edit_volumenes')) {
          $nuevosLotes = [];
          $nuevosVolumenes = [];

          foreach ($request->input('edit_lotes') as $index => $loteData) {
              $idLote = $loteData['id'];
              $volumenParcial = $request->input("edit_volumenes.$index.volumen_parcial");

              $loteRelacionado = LotesGranel::find($idLote);

              if (!is_null($volumenParcial) && $loteRelacionado)
 {
                  $keyAnterior = array_search($idLote, $lotesPrevios);

                  // Restaurar el volumen previo si estaba en el JSON anterior
                  if ($keyAnterior !== false) {
                      $volumenAnterior = $volumenesPrevios[$keyAnterior];
                      $loteRelacionado->volumen_restante += $volumenAnterior;

                      // Elimina lote de los lotes previos para detectar no seleccionados
                      unset($lotesPrevios[$keyAnterior], $volumenesPrevios[$keyAnterior]);
                  }

                  // Verificar que el nuevo volumen restante sea suficiente
                  if ($loteRelacionado->volumen_restante - $volumenParcial < 0) {
                      return response()->json(['success' => false, 'message' => 'No hay suficiente volumen restante en el lote relacionado']);
                  }

                  // Reducir el volumen restante con el nuevo valor
                  $loteRelacionado->volumen_restante -= $volumenParcial;
                  $loteRelacionado->save();

                  $nuevosLotes[] = $idLote;
                  $nuevosVolumenes[] = $volumenParcial;
              } else {
                  dd([
                      'id_lote' => $idLote,
                      'volumenParcial' => $volumenParcial,
                      'loteRelacionado' => $loteRelacionado
                  ]);
                  return response()->json(['success' => false, 'message' => 'Error al actualizar el lote relacionado']);
              }
          }

          // Restaurar el volumen de lotes no seleccionados en esta actualización
          foreach ($lotesPrevios as $index => $idLoteAnterior) {
              $loteAnterior = LotesGranel::find($idLoteAnterior);
              if ($loteAnterior) {
                  $loteAnterior->volumen_restante += $volumenesPrevios[$index];
                  $loteAnterior->save();
              }
          }

          // Actualizar el JSON con los nuevos lotes seleccionados
          $lote->lote_original_id = json_encode([
              'lotes' => $nuevosLotes,
              'volumenes' => $nuevosVolumenes
          ]);
          $lote->save();
      }

            // Almacenar las guías en la tabla intermedia usando el modelo LotesGranelGuia
            LotesGranelGuia::where('id_lote_granel', $id_lote_granel)->delete();
            if (isset($validated['id_guia'])) {
                foreach ($validated['id_guia'] as $idGuia) {
                    LotesGranelGuia::create([
                        'id_lote_granel' => $lote->id_lote_granel,
                        'id_guia' => $idGuia
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Lote actualizado exitosamente',
            ]);

        } catch (\Exception $e) {
            Log::error('Error al actualizar el lote:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el lote: ' . $e->getMessage(),
            ], 500);
        }
  }


        public function eliminar_documento(Request $request)
      {
          try {
              $documento = Documentacion_url::findOrFail($request->id);

              // Obtener id_empresa
              $idEmpresa = $documento->id_empresa;

              // Buscar el número de cliente desde Empresa
              $empresa = Empresa::with('empresaNumClientes')
                  ->where('id_empresa', $idEmpresa)
                  ->first();

              $numeroCliente = optional($empresa->empresaNumClientes)->pluck('numero_cliente')->first(function ($numero) {
                  return !empty($numero);
              });

              if (!$numeroCliente) {
                  return response()->json([
                      'success' => false,
                      'message' => 'No se encontró el número de cliente relacionado con la empresa.'
                  ]);
              }

              // Determinar carpeta por tipo de documento
              $idDoc = $documento->id_documento;
              $carpeta = ($idDoc === 59) ? 'certificados_granel' : 'fqs';

              // Ruta del archivo
              $filePath = 'uploads/' . $numeroCliente . '/' . $carpeta . '/' . $documento->url;

              // Eliminar archivo físico si existe
              if (Storage::disk('public')->exists($filePath)) {
                  Storage::disk('public')->delete($filePath);
              }

              // Eliminar registro de base de datos
              $documento->delete();

              return response()->json(['success' => true]);

          } catch (\Exception $e) {
              return response()->json([
                  'success' => false,
                  'message' => 'Error al eliminar documento: ' . $e->getMessage()
              ]);
          }
      }


}
