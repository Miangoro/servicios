@php
    $customizerHidden = 'customizer-hide';
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Server Error - Pages')

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
</style>

@section('content')
    <!-- Server Error -->
    <div class="misc-wrapper">
        <div class="content-wrapper">
            <h1 class="mb-2 mx-2 text-center glow" style="font-size: 6rem;line-height: 6rem;">ERROR 500</h1>
            <h4 class="mb-2 text-center">Error Interno del Servidor 🔐</h4>
            <p class="mb-3 mx-2 text-center">Oops algo a salido mal.</p>
            <div class="d-flex justify-content-center">
                <img src="{{ asset('assets/img/illustrations/logo_cidam_texto.png') }}" alt="misc-error"
                    class="img-fluid misc-object d-none d-lg-inline-block" width="160">
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
    <!-- /Server Error -->
@endsection
