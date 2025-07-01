@php
    use Illuminate\Support\Facades\Route;
    $configData = Helper::appClasses();
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Iniciar sesión')

@section('page-style')
    {{-- Page Css files --}}
    @vite('resources/assets/vendor/scss/pages/page-auth.scss')
@endsection

@section('content')

    <style>
        /* Video responsive */
        video {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            transform: translateX(calc((100% - 100vw) / 2));
            z-index: -2;
        }

        .facebook-iframe {
            position: fixed;
            left: 10px;
            bottom: 10px;
            z-index: 9999;
        }

        /* Halloween */
        .bat {
            position: absolute;
            top: -50px;
            opacity: 0;
            animation: flyDown 3s ease-out forwards;
            pointer-events: none;
            width: 20px;
            /* Ancho predeterminado */
            max-width: 37px;
            /* No más de 20px */
        }

        @keyframes flyDown {
            0% {
                opacity: 0;
                transform: translateY(0) scale(0.3);
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                transform: translateY(100vh) scale(1.5);
            }
        }

        /*navidad*/
        .snowflake {
            position: fixed;
            top: -10px;
            font-size: 1.5rem;
            color: #ffffff;
            opacity: 0.8;
            animation: fall linear infinite;
            z-index: -1;
        }

        @keyframes fall {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.8;
            }

            100% {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }

        /*Celular responsive y pc*/
        @media (max-width: 1700px) {
            video {
                min-width: 150%;
            }

            .bat {
                width: 20px !important;
                max-width: 37px !important;
            }

            .flex-container {
                gap: 20px;
                justify-content: space-evenly;
                flex-wrap: wrap;

            }
        }

        @media (max-width: 990px) {
            .img-logo {
                visibility: hidden;
            }

            .facebook {
                visibility: hidden;
            }
        }

        @media (max-width: 768px) {
            video {
                display: none;
            }

            .authentication-inner {
                padding: 1rem;
            }

            .form-floating {
                margin-bottom: 1rem;
            }

            .btn {
                padding: 0.75rem;
            }
        }

        .flex-container {
            display: flex;
            width: auto;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .flex-container-cel {
            display: flex;
            flex-wrap: wrap;
            width: auto;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 20px;

        }

        .imagenes,
        .redes {
            width: 190px;
            height: auto;
            transition: transform 0.3s ease;
        }

        .redes {
            width: 50px;
        }

        /* Efecto de rebote */
        @keyframes rebote {
            0% {
                transform: scale(1.1) translateY(0);
            }

            30% {
                transform: scale(1.15) translateY(-10px);
            }

            50% {
                transform: scale(1.1) translateY(0);
            }

            70% {
                transform: scale(1.15) translateY(-5px);
            }

            100% {
                transform: scale(1.15) translateY(0);
            }
        }

        .imagenes:hover,
        .redes:hover {
            animation: rebote 0.6s ease;
        }

        .imagenes,
        .redes {
            transform: scale(1);
        }

        .imagenes:hover,
        .redes:hover {
            transform: scale(1.15);
        }

        .border-effect {
            border-radius: 50%;
            transition: all 0.3s ease-in-out;
        }

        .border-effect:hover {
            transform: scale(1.15);
            transition: transform 0.3s ease-in-out;
        }


        .border-effect-boton {
            border-radius: 50%;
            transition: all 0.3s ease-in-out;
        }

        .border-effect-boton:hover {
            transform: scale(1.07);
            transition: transform 0.3s ease-in-out;
        }

        .boton-effect:hover {
            filter: drop-shadow(0 0 8px #16ba76);
            transition: all 0.3s ease-in-out;
        }

        .face-effect:hover {
            box-shadow: 0 0 15px dodgerblue,
                0 0 20px dodgerblue,
                0 0 25px dodgerblue,
                0 0 30px dodgerblue;
            transition: all 0.3s ease-in-out;
        }

        .insta-effect:hover {
            box-shadow: 0 0 15px #a04293,
                0 0 20px #a04293,
                0 0 25px #a04293,
                0 0 30px #a04293;
            transition: all 0.3s ease-in-out;
        }

        .btn {
            position: relative;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }

        /* Estilo de Santa Claus y animacion*/
        .santa {
            position: absolute;
            top: 0;
            left: -100px;
            width: 120px;
            height: 120px;
            background-image: url('{{ asset('assets/img/branding/santa.png') }}');
            background-size: cover;
            animation: volar 5.5s cubic-bezier(0.25, 0.8, 0.25, 1) infinite;
            display: none;
        }

        @keyframes volar {
            0% {
                transform: translateX(-100px) translateY(0) scale(1) rotate(0deg);
                filter: drop-shadow(0px 10px 10px #f5bf03);
            }

            25% {
                transform: translateX(25vw) translateY(15vh) scale(1.2) rotate(-10deg);
                filter: drop-shadow(0px 15px 15px #f5bf03);
            }

            50% {
                transform: translateX(50vw) translateY(0) scale(1.1) rotate(5deg);
                filter: drop-shadow(0px 17px 17px #f5bf03);
            }

            75% {
                transform: translateX(75vw) translateY(15vh) scale(1.2) rotate(-5deg);
                filter: drop-shadow(0px 15px 15px #f5bf03);
            }

            100% {
                transform: translateX(80vw) translateY(0) scale(1) rotate(0deg);
                filter: drop-shadow(0px 10px 10px #f5bf03);
            }
        }

        .hover-linea {
            display: inline-block;
            position: relative;
            color: #50d7fc;
            text-decoration: none;
            cursor: pointer;
        }

        .hover-linea::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 0;
            height: 2px;
            background-color: #50d7fc;
            transition: width 0.3s ease;/
        }

        .hover-linea:hover::after {
            width: 100%;
        }

        .hover-zoom {
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .hover-zoom:hover {
            transform: scale(1.1);
        }
    </style>

    <div id="desktop-view" class="d-none">
        <div class="authentication-wrapper authentication-cover">
            <a href="{{ url('/') }}" class="auth-cover-brand d-flex align-items-center gap-2">
                <span class="app-brand-logo demo img-logo"><img height="135px"
                        src="{{ asset('assets/img/branding/logo_oc.png') }}" alt=""></span>
            </a>
            <div class="authentication-inner row m-0">
                <div class="santa"></div>
               <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2 min-vh-100">
  <img style="inset-block-end: 0%" src="{{ asset('assets/img/fondo_oc_cidam.jpg') }}"
       class="authentication-image w-100 h-100 object-fit-cover"
       alt="mask"
       data-app-light-img="fondo_oc_cidam.jpg"
       data-app-dark-img="fondo_oc_cidam.jpg" />
</div>

                <div
                    class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-12 px-12 py-6">
                    <div class="w-px-400 mx-auto pt-5 pt-lg-0">
                        <h4 class="text-center">¡Bienvenido!</h4>

                        <img class="hover-zoom" height="150px" src="{{ asset('assets/img/branding/logo.png') }}"
                            alt="Logo">
                        <p class="mb-5">Por favor, inicie sesión</p>
                        @if (session('status'))
                            <div class="alert alert-success mb-3" role="alert">
                                <div class="alert-body">
                                    {{ session('status') }}
                                </div>
                            </div>
                        @endif
                        <div class="facebook-iframe facebook">
                            <iframe
                                src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Forganismo.certificador.CIDAM&amp;tabs=timeline&amp;width=340&amp;height=500&amp;small_header=false&amp;adapt_container_width=true&amp;hide_cover=false&amp;show_facepile=true&amp;appId=1310192986090547"
                                width="340" height="500" style="border:none;overflow:hidden; border-radius: 20px;"
                                allowfullscreen=""
                                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                        </div>
                        <form id="formAuthentication" class="mb-5" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    id="login-email" name="email" placeholder="john@example.com" autofocus
                                    value="{{ old('email') }}">
                                <label for="login-email">Correo</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <span class="fw-medium">{{ $message }}</span>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <div class="form-password-toggle">
                                    <div class="input-group input-group-merge @error('password') is-invalid @enderror">
                                        <div class="form-floating form-floating-outline">
                                            <input type="password" id="login-password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                aria-describedby="password" />
                                            <label for="login-password">Contraseña</label>
                                        </div>
                                        <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <span class="fw-medium">{{ $message }}</span>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-5 d-flex justify-content-between mt-5">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="remember-me">
                                    <label class="form-check-label" for="remember-me">
                                        Recuérdame
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="float-end mb-1 mt-2">
                                        <span>¿Olvidó su contraseña?</span>
                                    </a>
                                @endif
                            </div>
                            <button class="btn btn-primary d-grid w-100 border-effect-boton"><i class="ri-login-box-line"></i> Iniciar sesión
                            </button>
                        </form>
             

                        <div style="text-align: center">
                            <p>¡Síguenos en nuestras redes sociales!</p>
                        </div>
                        <div class="flex-container">
                            <a href="https://www.facebook.com/organismo.certificador.CIDAM" target="_blank">
                                <img src="{{ asset('assets/img/branding/facebook_logo.png') }}" alt=""
                                    class="redes border-effect  face-effect">
                            </a>
                            <div style="gap: 10px"></div>
                            <a href="https://www.instagram.com/oc_cidam/" target="_blank">
                                <img src="{{ asset('assets/img/branding/instagram_logo.png') }}" alt=""
                                    class="redes border-effect insta-effect">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vista movil -->
    <div id="mobile-view" class="d-none">
        <div class="authentication-wrapper authentication-cover">
            <a href="{{ url('/') }}"
                class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2">
                <span class="app-brand-logo demo"><img height="135px"
                        src="{{ asset('assets/img/branding/logo_oc.png') }}" alt=""></span>
            </a>
            <div class="authentication-inner row m-0">
                <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2">
                    <!--<video autoplay muted loop style="max-width: 100%; height: 100%;">
                        <source src="{{ asset('video/fondo.mp4') }}" type="video/mp4">
                        Tu navegador no soporta el formato de video
                    </video>-->
                    <img src="sasdas" class="authentication-image" alt="mask" data-app-light-img="{{ asset('video/fondo_oc_cidam.jpg') }}" data-app-dark-img="{{ asset('video/fondo_oc_cidam.jpg') }}">
                </div>
                <div
                    class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-6 px-4">
                    <div class="w-100 mx-auto">
                        <h4 class="text-center">¡Bienvenido!</h4>
                        <img class="d-block mx-auto mb-3" height="100px"
                            src="{{ asset('assets/img/branding/logo.png') }}" alt="">
                        <p class="text-center mb-4">Por favor, inicie sesión</p>

                        @if (session('status'))
                            <div class="alert alert-success mb-3" role="alert">
                                <div class="alert-body">
                                    {{ session('status') }}
                                </div>
                            </div>
                        @endif
                        <form id="formAuthentication-mobile" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    id="login-email-mobile" name="email" placeholder="john@example.com" autofocus
                                    value="{{ old('email') }}">
                                <label for="login-email-mobile">Correo</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <span class="fw-medium">{{ $message }}</span>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <div class="form-password-toggle">
                                    <div class="input-group input-group-merge @error('password') is-invalid @enderror">
                                        <div class="form-floating form-floating-outline">
                                            <input type="password" id="login-password-mobile"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                aria-describedby="password" />
                                            <label for="login-password-mobile">Contraseña</label>
                                        </div>
                                        <span class="input-group-text cursor-pointer" style=" height: 48px;">
                                            <i class="ri-eye-off-line"></i>
                                        </span>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <span class="fw-medium">{{ $message }}</span>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me-mobile">
                                    <label class="form-check-label" for="remember-me-mobile">Recuérdame</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-end">¿Olvidó su contraseña?</a>
                                @endif
                            </div>
                            <button class="btn btn-primary d-grid w-100 border-effect-boton">
                                Iniciar sesión
                            </button>
                        </form>
                        <p class="text-center">
                            <span>¿No estás certificado?</span>
                            @if (Route::has('register'))
                                <a href="{{ route('solicitud-cliente') }}" class="text-info hover-linea">¡Quiero
                                    certificarme!</a>
                            @endif
                        </p>
                        <div class="flex-container-cel">
                            <a href="https://cidam.org/sitio/empresas_certificadas.php" target="_blank">
                                <img src="{{ asset('assets/img/branding/empresas_certificadas_cidam.png') }}"
                                    alt="imagen de empresa certificado" class="imagenes">
                            </a>
                            <a href="https://cidam.org/sitio/autenticidad_certificados.php" target="_blank">
                                <img src="{{ asset('assets/img/branding/validacion_certificados_cidam.png') }}"
                                    alt="imagen de calidacion certificado" class="imagenes">
                            </a>
                            <a href="https://cidam.org/sitio/autenticidad_hologramas.php" target="_blank">
                                <img src="{{ asset('assets/img/branding/validacion_hologramas_cidam.png') }}"
                                    alt=" imagen de" class="imagenes">
                            </a>
                        </div>
                        <div style="text-align: center">
                            <p>👇¡Síguenos en nuestras redes sociales!👇</p>
                        </div>
                        <div class="flex-container">
                            <a href="https://www.facebook.com/organismo.certificador.CIDAM" target="_blank">
                                <img src="{{ asset('assets/img/branding/facebook_logo.png') }}" alt=""
                                    class="redes border-effect face-effect">
                            </a>
                            <div style="gap: 10px"></div>
                            <a href="https://www.instagram.com/oc_cidam/" target="_blank">
                                <img src="{{ asset('assets/img/branding/instagram_logo.png') }}" alt=""
                                    class="redes border-effect insta-effect">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<script>
    //metodo para cambiar de escritorio a celular
    document.addEventListener('DOMContentLoaded', function() {
        function toggleView() {
            const mobileView = document.getElementById('mobile-view');
            const desktopView = document.getElementById('desktop-view');

            if (window.innerWidth <= 768) {
                mobileView.classList.remove('d-none');
                desktopView.classList.add('d-none');
            } else {
                desktopView.classList.remove('d-none');
                mobileView.classList.add('d-none');
            }
        }
        toggleView();
        window.addEventListener('resize', toggleView);
    });

    //Halloween
    let batCount = 0;
    const maxBats = 10; // Máximo número de murciélagos
    const maxWidth = 768; // Ancho máximo para considerar el diseño responsive

    function isHalloweenSeason() {
        const today = new Date();
        const startDate = new Date(today.getFullYear(), 9, 1); // 1 de octubre
        const endDate = new Date(today.getFullYear(), 10, 2); // 2 de noviembre
        return today >= startDate && today <= endDate;
    }

    function createBat() {
        if (batCount < maxBats && window.innerWidth >
            maxWidth) {
            const bat = document.createElement("img");
            const batImages = [
                "{{ asset('assets/img/branding/murcielago.png') }}",
                "{{ asset('assets/img/branding/calabazin.png') }}",
                "{{ asset('assets/img/branding/fantasma.png') }}"
            ];
            bat.src = batImages[Math.floor(Math.random() * batImages.length)];
            bat.classList.add("bat");
            bat.style.left = Math.random() * 90 + "vw";
            bat.style.width = Math.random() * 30 + 20 + "px"; // Tamaño entre 20px y 50px
            document.body.appendChild(bat);
            batCount++;
            bat.addEventListener("animationend", () => {
                bat.remove();
                batCount--; // Reduce el contador al terminar la animación
            });
        }
    }
    if (isHalloweenSeason()) {
        setInterval(createBat, 1000);
    }

    //vavidad
    function isChristmasSeason() {
        const today = new Date();
        const month = today.getMonth();
        return month === 11;
    }

    function createSnowflake() {
        const snowflake = document.createElement("span");
        snowflake.classList.add("snowflake");
        snowflake.textContent = "❄";
        snowflake.style.left = Math.random() * 70 + "vw";
        snowflake.style.animationDuration = Math.random() * 3 + 2 + "s"; // Duración de caída de 2 a 5 segundos
        snowflake.style.fontSize = Math.random() * 10 + 5 + "px"; // Tamaño entre 10px y 20px

        document.body.appendChild(snowflake);

        snowflake.addEventListener("animationend", () => {
            snowflake.remove();
        });
    }
    if (isChristmasSeason()) {
        setInterval(createSnowflake, 500);
    }

    function isDecember() {
        const today = new Date();
        const month = today.getMonth();
        return month === 11;
    }
    if (isDecember()) {
        document.getElementById("santa").style.display = "block";
    } else {
        document.getElementById("santa").style.display = "none";
    }
</script>
