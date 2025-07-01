@extends('layouts/layoutMaster')

@section('title', 'Verificar Autenticidad de Holograma')


@section('page-style')
    <!-- Page -->
    @vite(['resources/css/hologramas.css'])
@endsection

<style>
        //estios para el pie
    .panel-footer {
        background: url('{{ asset('assets/img/illustrations/organismo_certificador_cidam2024.png') }}')no-repeat 50% !important;
    
    }

    .panel-footer {
        background: url('{{ asset('assets/img/illustrations/organismo_certificador_cidam2024.png') }}')no-repeat 50% !important;
       
    }

    @media only screen and (max-width: 900px) {
        .panel-footer {
            background: url('{{ asset('assets/img/illustrations/organismo_certificador_cidam2024.png') }}')no-repeat 50% !important;
           
        }
    }
</style>

@section('content')

    <div class="nav_bar">
        <div id="texto1">VALIDACIÓN DE HOLOGRAMAS</div>
        <div id="texto2">ORGANISMO CERTIFICADOR CIDAM</div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-8" style="float:none;margin:auto;">
                <div style=" border-radius: 40px !important; background-color: #062e6163  !important;"
                    class="panel panel-default">

                    @if($ya_activado == true)
                    <div id="trazabilidad" class="panel-heading">Trazabilidad</div>
                   

                    <div style=" border: 1px solid #fff;text-align: center; background-color: #062e61; color: white;font-size: 18px;" class="alert">
                        <strong>FOLIO DE HOLOGRAMA: {{ $folio }}</strong>
                    </div>

                    <div
                        style=" border: 1px solid #fff;text-align: center; background-color: #062e61; color: white; font-size: 30px">
                        <strong>PRODUCTO
                            CERTIFICADO</strong>
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="td"><b>CERTIFICADO DE LOTE A GRANEL</b></td>
                                <td class="td">{{ $datosHolograma->certificado_granel }}</td>
                            </tr>
                            
                            <tr>
                                <td class="td"><b>TIPO DE AGAVE</b></td>
                                <td class="td">
                                    {!! optional($datosHolograma->tipos)->map(function($tipo) {
                                        return $tipo->nombre . ($tipo->cientifico ? ' (<i>' . $tipo->cientifico . '</i>)' : '');
                                    })->implode(', ') !!}
                                </td>

                                
                            </tr>
                           <!-- <tr>
                                <td class="td"><b>TIPO DE AGAVE</b></td>
                                <td class="td">
                                  
                                        {{ optional($datosHolograma->tipos)->pluck('nombre')->implode(', ') }} 
                                        (<i>{{ optional($datosHolograma->tipos)->pluck('cientifico')->implode(', ') }}</i>)
                                      
                                </td>
                            </tr>-->
                            <tr>
                                <td class="td"><b>CATEGORÍA</b></td>
                                <td class="td">{{ $datosHolograma->categorias->categoria }}</td>
                            </tr>
                            <tr>
                                <td class="td"><b>CLASE</b></td>
                                <td class="td">{{ $datosHolograma->clases->clase }}</td>
                            </tr>
                            @if($datosHolograma->edad)
                                <tr>
                                    <td class="td"><b>EDAD</b></td>
                                    <td class="td">{{ $datosHolograma->edad }}</td>
                                </tr>
                            @endif
                            <!--<tr>
                                <td class="td"><b>MARCA</b></td>
                                <td class="td">{{ $marca->marca }}</td>
                            </tr>-->
                            <tr>
                                <td class="td"><b>LOTE A GRANEL</b></td>
                                <td class="td">{{ $datosHolograma->no_lote_agranel }}</td>
                            </tr>
                            <tr>
                                <td class="td"><b>LOTE ENVASADO</b></td>
                                <td class="td">{{ $datosHolograma->no_lote_envasado }}</td>
                            </tr>
                            <tr>
                                <td class="td"><b>PRODUCIDO EN</b></td>
                                <td class="td">{{ $datosHolograma->lugar_produccion }}</td>
                            </tr>
                            <tr>
                                <td class="td"><b>ENVASADO EN</b></td>
                                <td class="td">{{ $datosHolograma->lugar_envasado}}</td>
                            </tr>
                            <tr>
                                <td class="td"><b>CONTENIDO ALCOHÓLICO</b></td>
                                <td class="td">{{ $datosHolograma->contenido}} % Alc. Vol</td>
                            </tr>
                        </tbody>
                    </table>
                   <!-- <div style=" border: 1px solid #fff;text-align: center; background-color: #062e61; color: white;font-size: 18px;"class="alert">
                        <strong>CERTIFICADO
                            VENTA
                            NACIONAL Y/O EXPORTACIÓN: <br>
                            CIDAM C-EXP-497/2024</strong>
                    </div>-->
                    @else
                    <div class="alert alert-danger text-center fw-bold fs-4">
                        HOLOGRAMA NO ACTIVADO
                    </div>
                    
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="font-size: 23px;font-weight: bold;color: #FFF;text-align: center;background-color: #243868 !important; padding: 8px; border-color: #ebccd1; border-top: 0; text-transform: none;"
                                    colspan="2">Comercializador o Licenciatario de Marca
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="tdd"><b>NOMBRE / EMPRESA </b></td>
                                <td class="tdd">{{ $cliente->empresa->razon_social }}</td>
                            </tr>
                            <tr>
                                <td class="tdd"><b>Marca</b></td>
                                <td class="tdd">{{ $marca->marca }}</td>
                            </tr>
                            <tr>
                                <td class="tdd"><b>RFC</b></td>
                                <td class="tdd">{{ $cliente->empresa->rfc }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


               <div class="row">
                    <div class="col-sm-12" style="text-align: center"></div>
                </div>
                <!--<div class="row">
                    <div class="col-sm-12 contenedor-imagenes">
                        <img src="{{ asset('assets/img/illustrations/holograma_cidam.png') }}"
                            alt="Holograma de organismo certificador de cidam" id="holograma" class="imagen-holograma" />
                        <div class="centrado"> {{ $folio }} </div>

                    </div>
                </div>-->
            </div>
        </div>

        <div class="panel panel-footer"></div>
        <div id="footer">
            <div>2024 © Todos los derechos reservados a <a style="color:#2adc9f;" href="https://cidam.org/sitio/">CIDAM</a>
            </div>

        </div>
    </div>

@endsection
