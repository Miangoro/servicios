@php
use Illuminate\Support\Facades\Route;
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Autentificación de dos pasos')

@section('page-style')
{{-- Page Css files --}}
@vite('resources/assets/vendor/scss/pages/page-auth.scss')
<style>
   video {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            transform: translateX(calc((100% - 100vw) / 2));
            z-index: -2;
        }
</style>
@endsection

@section('content')
<div class="authentication-wrapper authentication-cover">
  <!-- Logo -->
  <a href="{{ url('/') }}" class="auth-cover-brand d-flex align-items-center gap-2">
    <span class="app-brand-logo demo img-logo"><img height="135px"
            src="{{ asset('assets/img/branding/logo_oc.png') }}" alt=""></span>
</a>
  <!-- /Logo -->
  <div class="authentication-inner row m-0">

    <!-- /Left Section -->
    <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center">
      <video autoplay muted loop style="max-width: 100%; height: 100%;">
          <source src="{{ asset('video/fondo.mp4') }}" type="video/mp4">
          Tu navegador no soporta el formato de video
      </video>
  </div>
    <!-- /Left Section -->

    <!-- Two Steps Verification -->
    <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-12 px-12 py-6">
      <div class="w-px-400 mx-auto pt-5 pt-lg-0">

        <h4 class="mb-1">Verificación de dos pasos 💬</h4>
        <div x-data="{ recovery: false }">
          <div class="mb-6" x-show="! recovery">
            Por favor, confirme el acceso a su cuenta ingresando el código de autenticación proporcionado por su aplicación de autenticación.
          </div>

          <div class="mb-6" x-show="recovery">
            Confirme el acceso a su cuenta ingresando uno de sus códigos de recuperación de emergencia.
          </div>

          <x-validation-errors class="mb-1" />

          <form method="POST" action="{{ route('two-factor.login') }}">
            @csrf
            <div class="mb-5" x-show="! recovery">
              <x-label class="form-label" value="{{ __('Código') }}" />
              <x-input class="{{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
              <x-input-error for="code"></x-input-error>
            </div>
            <div class="mb-5" x-show="recovery">
              <x-label class="form-label" value="{{ __('Recovery Code') }}" />
              <x-input class="{{ $errors->has('recovery_code') ? 'is-invalid' : '' }}" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
              <x-input-error for="recovery_code"></x-input-error>
            </div>
            <div class="d-flex justify-content-end gap-2">
              <div x-show="! recovery" x-on:click="recovery = true; $nextTick(() => { $refs.recovery_code.focus()})">
                <button type="button" class="btn btn-outline-secondary">Utilice un código de recuperación</button>
              </div>
              <div x-cloak x-show="recovery" x-on:click="recovery = false; $nextTick(() => { $refs.code.focus() })">
                <button type="button" class="btn btn-outline-secondary">Utilice un código de autenticación</button>
              </div>
              <x-button class="px-3">Iniciar sesión</x-button>
          </div>
        </form>
        </div>
      </div>
    </div>
    <!-- /Two Steps Verification -->
  </div>
</div>
@endsection