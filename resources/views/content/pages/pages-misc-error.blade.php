@php
    $customizerHidden = 'customizer-hide';
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Error - Pages')

@section('page-style')
    <!-- Page -->
    @vite(['resources/assets/vendor/scss/pages/page-misc.scss'])
@endsection
<style>
    .glow {
        color: #ffffff;
        font-size: 6rem;
        line-height: 6rem;
        text-align: center;
        text-transform: uppercase;
    }

    @keyframes glow {
        from {
            text-shadow: 0 0 10px #ffffff,
                0 0 20px #ffffff,
                0 0 30px #f33119,
                0 0 40px #f33119,
                0 0 50px #f33119,
                0 0 60px #f33119,
                0 0 70px #f33119;
        }

        to {
            text-shadow: 0 0 20px #ffffff,
                0 0 30px #fc1406,
                0 0 40px #fc1406,
                0 0 50px #fc1406,
                0 0 60px #fc1406,
                0 0 70px #fc1406,
                0 0 80px #fc1406;
        }
    }

    .misc-wrapper {
        position: relative;
        background-image: url('{{ asset('assets/img/illustrations/campo_fondo_error.jpg') }}');
        background-size: cover;
        background-position: center;
        width: 100vw;
        /* 100% del ancho de la ventana */
        height: 100vh;
        /* 100% de la altura de la ventana */
        margin: 0;
        padding: 0;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    .misc-wrapper::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.3);
        /* Slightly opaque white */
        backdrop-filter: blur(10px);
        /* Blur effect */
        z-index: 1;
        /* Ensure it's above the background but below the content */
        border-radius: 0;
        /* Optional: for rounded corners */
    }

    .content-wrapper {
        z-index: 2;
        /* Ensure content is above the glass effect */
    }

    /* Para pantallas pequeñas de 576px en adelante */
@media (min-width: 576px) {
    .col-sm-12 {
        flex: 0 0 auto;
        width: 100%;
    }
}

/* Para pantallas de 900px o menos */
@media only screen and (max-width: 900px) {
    .contenedor-imagenes {
        display: flex;
        margin-bottom: 200px; /* Ajuste de margen para pantallas más pequeñas */
        position: relative;
    }
    
    .contenedor-imagenes #holograma {
        width: 100%;
        height: 100%; /* Imagen dentro del contenedor se adapta al 100% */
    }
}

/* Estilo general del contenedor para pantallas más grandes */
.contenedor-imagenes {
    display: flex;
    margin-bottom: 300px;
    position: relative;
    justify-content: center; /* Centra las imágenes dentro del contenedor */
}

/* Para pantallas de 768px o menos */
@media (max-width: 768px) {
    .imagen-holograma {
        width: 100%; /* Ajusta el ancho de la imagen al ancho de la pantalla */
        height: auto; /* Ajusta el alto automáticamente para mantener la proporción */
    }
}

</style>

@section('content')
    <!-- Error -->
    <div class="misc-wrapper">
        <div class="content-wrapper">
            <h1 class="mb-4 mt-7 mx-2 glow text-center">ERROR 404</h1>
            <h4 class="mb-1 text-center">Momento Página no encontrada ⚠️</h4>
            <p class="mb-1 mx-2 text-center">No se puedo encontrar la página que estas buscando, intenta con otra...</p>
            <div class="d-flex justify-content-center">
                <img src="{{ asset('assets/img/illustrations/logo_cidam_texto.png') }}" alt="misc-error"
                    class="img-fluid misc-object" width="160">
                <div class="d-flex flex-column align-items-center">
                    <img src="{{ asset('assets/img/illustrations/logo_error.png') }}" alt="misc-error"
                        class="img-fluid z-1" width="500">
                    <div>
                        <a href="{{ url('/') }}" class="btn btn-primary text-center my-10"><i
                                class="ri-arrow-left-fill"></i>Regresar al inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Error -->
@endsection
