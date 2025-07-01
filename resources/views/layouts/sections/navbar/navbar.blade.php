@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
$containerNav = ($configData['contentLayout'] === 'compact') ? 'container-xxl' : 'container-fluid';
$navbarDetached = ($navbarDetached ?? '');
@endphp

<!-- Navbar -->
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
<nav class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme" id="layout-navbar">
  @endif
  @if(isset($navbarDetached) && $navbarDetached == '')
  <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="{{$containerNav}}">
      @endif

      <!--  Brand demo (display only for navbar-full and hide on below xl) -->
      @if(isset($navbarFull))
        <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-6">
          <a href="{{url('/')}}" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'var(--bs-primary)'])</span>
            <span class="app-brand-text demo menu-text fw-semibold">{{config('variables.templateName')}}</span>
          </a>
          @if(isset($menuHorizontal))
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
              <i class="ri-close-fill align-middle"></i>
            </a>
          @endif
        </div>
      @endif

      <!-- ! Not required for layout-without-menu -->
      @if(!isset($navbarHideToggle))
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
          <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="ri-menu-fill ri-22px"></i>
          </a>
        </div>
      @endif

      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">


        @if(!isset($menuHorizontal))
        <!-- Search -->
        <div class="navbar-nav align-items-center">
          <div class="nav-item navbar-search-wrapper mb-0">
            <a class="nav-item nav-link search-toggler fw-normal px-0" href="javascript:void(0);">
              <i class="ri-search-line ri-22px scaleX-n1-rtl me-3"></i>
              <span class="d-none d-md-inline-block text-muted">Buscar (Ctrl+/)</span>
            </a>
          </div>
        </div>
        <!-- /Search -->
        @endif



       <ul class="navbar-nav flex-row align-items-center ms-auto">
          @if(isset($menuHorizontal))
            <!-- Search -->
            <li class="nav-item navbar-search-wrapper me-1 me-xl-0">
              <a class="nav-link btn btn-text-secondary rounded-pill search-toggler fw-normal" href="javascript:void(0);">
                <i class="ri-search-line ri-22px scaleX-n1-rtl"></i>
              </a>
            </li>
            <!-- /Search -->
          @endif


          @if($configData['hasCustomizer'] == true)
            <!-- Style Switcher -->
            <li class="nav-item dropdown-style-switcher dropdown me-1 me-xl-0">
              <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <i class='ri-22px'></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                <li>
                  <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                    <span class="align-middle"><i class='ri-sun-line ri-22px me-3'></i>Claro</span>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                    <span class="align-middle"><i class="ri-moon-clear-line ri-22px me-3"></i>Oscuro</span>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                    <span class="align-middle"><i class="ri-computer-line ri-22px me-3"></i>Sistema</span>
                  </a>
                </li>
              </ul>
            </li>
            <!-- / Style Switcher -->
          @endif

          <!-- Quick links  -->
          <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-1 me-xl-0">
            <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
              <i class='ri-star-smile-line ri-22px'></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end py-0">
              <div class="dropdown-menu-header border-bottom py-50">
                <div class="dropdown-header d-flex align-items-center py-2">
                  <h6 class="mb-0 me-auto">Accesos directos</h6>
                  <a href="javascript:void(0)" class="btn btn-text-secondary rounded-pill btn-icon dropdown-shortcuts-add" data-bs-toggle="tooltip" data-bs-placement="top" title="Agregar acceso directo"><i class="ri-add-line text-heading ri-24px"></i></a>
                </div>
              </div>
              <div class="dropdown-shortcuts-list scrollable-container">
{{--                 <div class="row row-bordered overflow-visible g-0">
                  <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                      <i class="ri-calendar-line ri-26px text-heading"></i>
                    </span>
                    <a href="{{url('app/calendar')}}" class="stretched-link">Calendar</a>
                    <small class="mb-0">Appointments</small>
                  </div>
                  <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                      <i class="ri-file-text-line ri-26px text-heading"></i>
                    </span>
                    <a href="{{url('app/invoice/list')}}" class="stretched-link">Invoice App</a>
                    <small class="mb-0">Manage Accounts</small>
                  </div>
                </div> --}}
{{--                 <div class="row row-bordered overflow-visible g-0">
                  <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                      <i class="ri-user-line ri-26px text-heading"></i>
                    </span>
                    <a href="{{url('app/user/list')}}" class="stretched-link">User App</a>
                    <small class="mb-0">Manage Users</small>
                  </div>
                  <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                      <i class="ri-computer-line ri-26px text-heading"></i>
                    </span>
                    <a href="{{url('app/access-roles')}}" class="stretched-link">Role Management</a>
                    <small class="mb-0">Permission</small>
                  </div>
                </div> --}}
{{--                 <div class="row row-bordered overflow-visible g-0">
                  <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                      <i class="ri-pie-chart-2-line ri-26px text-heading"></i>
                    </span>
                    <a href="{{url('/')}}" class="stretched-link">Dashboard</a>
                    <small class="mb-0">Analytics</small>
                  </div>
                  <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                      <i class="ri-settings-4-line ri-26px text-heading"></i>
                    </span>
                    <a href="{{url('pages/account-settings-account')}}" class="stretched-link">Setting</a>
                    <small class="mb-0">Account Settings</small>
                  </div>
                </div> --}}
                <div class="row row-bordered overflow-visible g-0">
                  <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                      <i class="ri-question-line ri-26px text-heading"></i>
                    </span>
                    <a href="{{url('pages/faq')}}" class="stretched-link">FAQs</a>
                    <small class="mb-0">Preguntas Frecuentes</small>
                  </div>
                  <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                      <i class="ri-file-edit-line ri-26px text-heading"></i>
                    </span>
                    <a href="{{url('solicitudes-historial')}}" class="stretched-link">Solicitudes</a>
                    <small class="mb-0">Solicitudes de servicios</small>
                  </div>
                  <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                      <i class="ri-arrow-down-circle-fill ri-26px text-heading"></i>
                    </span>
                    <a target="_Blank" href="https://www.ilovepdf.com/es/comprimir_pdf" class="stretched-link">Bajar peso</a>
                    <small class="mb-0">Bajar el peso a pdfs</small>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <!-- Quick links -->

          <!-- Notification -->
          <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-4 me-xl-1">
            <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
              <i class="ri-notification-2-line ri-22px"></i>
                 @if (auth()->check())
                    @if(Auth::user()->unreadNotifications->count() > 0)
                      <span class="position-absolute top-0 start-50 translate-middle-y badge badge-dot bg-danger mt-2 border"></span>
                    @endif
                  @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end py-0">
              <li class="dropdown-menu-header border-bottom py-50">
                <div class="dropdown-header d-flex align-items-center py-2">
                  <h6 class="mb-0 me-auto">Notificaciones</h6>
                  <div class="d-flex align-items-center">
                    <span class="badge rounded-pill bg-label-primary fs-xsmall me-2">
                      @if (auth()->check())
                          {{ auth()->user()->unreadNotifications->count() }}

                          notificación{{ auth()->user()->unreadNotifications->count() > 1 ? 'es' : '' }}
                      @endif

                    </span>
                    <a href="javascript:void(0)" class="btn btn-text-secondary rounded-pill btn-icon dropdown-notifications-all" data-bs-toggle="tooltip" data-bs-placement="top" title="Marcar todas como leidas"><i class="ri-mail-open-line text-heading ri-20px"></i></a>
                  </div>
                </div>
              </li>
              <li class="dropdown-notifications-list scrollable-container">
                <ul class="list-group list-group-flush">

                  @if (auth()->check())
                    @if(Auth::user()->unreadNotifications->count() > 0)
                      @foreach (Auth::user()->unreadNotifications as $notification)

                        <li class="list-group-item list-group-item-action dropdown-notifications-item"
                        onclick="redirigirNotificacion('{{ $notification->data['url'] }}', '{{ $notification->id }}')">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <img src="{{ \App\Models\User::find($notification->notifiable_id)?->profile_photo_url ?? asset('assets/img/avatars/1.png') }}" alt class="rounded-circle">

                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="small mb-1">{{ $notification->data['title'] }}</h6>
                              <small class="mb-1 d-block text-body">{{ $notification->data['message'] }}</small>
                              <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a onclick="marcarComoLeida('{{ $notification->id }}')" href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                              <a onclick="marcarComoLeida('{{ $notification->id }}')" class="dropdown-notifications-archive"><span class="ri-close-line ri-20px"></span></a>
                            </div>
                          </div>
                        </li>
                      @endforeach

                    @else
                    <li class="list-group-item">No hay notificaciones nuevas.</li>

                    @endif
                  @endif



                </ul>
              </li>
              <li class="border-top">
                <div class="d-grid p-4">
                  <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
                    <small class="align-middle">Ver todas las notificaciones</small>
                  </a>
                </div>
              </li>
            </ul>
          </li>
          <!--/ Notification -->

          <!-- User -->
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
              <div class="avatar avatar-online">
                <img src="{{ Auth::user() ? Auth::user()->profile_photo_url : asset('assets/img/avatars/1.png') }}" alt class="rounded-circle">
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="{{ Route::has('profile.show') ? route('profile.show') : url('pages/profile-user') }}">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-2">
                      <div class="avatar avatar-online">
                        <img src="{{ Auth::user() ? Auth::user()->profile_photo_url : asset('assets/img/avatars/1.png') }}" alt class="rounded-circle">
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <span class="fw-bold d-block small">
                        @if (Auth::check())
                          {{ Auth::user()->name }}
                        @else
                          Sin usuario logeado
                        @endif
                      </span>
                      <small class="text-primary">
                        @if (Auth::check() and Auth::user()->puesto)
                        {{ Auth::user()->puesto }}
                        @elseif(Auth::user()->empresa)
                                {{ Auth::user()->empresa->razon_social }}
                        @else
                           Miembro del consejo
                        @endif
                    </small>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li>
                <a class="dropdown-item" href="{{ Route::has('profile.show') ? route('profile.show') : url('pages/profile-user') }}">
                  <i class="ri-user-3-line ri-22px me-3 text-primary"></i><span class="align-middle">Mi perfil</span>
                </a>
              </li>

              @if (Auth::check() && Laravel\Jetstream\Jetstream::hasApiFeatures())
                <li>
                  <a class="dropdown-item" href="{{ route('api-tokens.index') }}">
                    <i class="ri-key-2-line ri-22px me-3"></i><span class="align-middle">API Tokens</span>
                  </a>
                </li>
              @endif

              @if (Auth::User() && Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <li>
                  <div class="dropdown-divider"></div>
                </li>
                <li>
                  <h6 class="dropdown-header">Manage Team</h6>
                </li>
                <li>
                  <div class="dropdown-divider"></div>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ Auth::user() ? route('teams.show', Auth::user()->currentTeam->id) : 'javascript:void(0)' }}">
                    <i class="ri-settings-3-line ri-22px me-3"></i><span class="align-middle">Team Settings</span>
                  </a>
                </li>
                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                  <li>
                    <a class="dropdown-item" href="{{ route('teams.create') }}">
                      <i class="ri-group-line ri-22px me-3"></i><span class="align-middle">Create New Team</span>
                    </a>
                  </li>
                @endcan

                @if (Auth::user()->allTeams()->count() > 1)
                  <li>
                    <div class="dropdown-divider"></div>
                  </li>
                  <li>
                    <h6 class="dropdown-header">Switch Teams</h6>
                  </li>
                  <li>
                    <div class="dropdown-divider"></div>
                  </li>
                @endif

                @if (Auth::user())
                  @foreach (Auth::user()->allTeams() as $team)
                  {{-- Below commented code read by artisan command while installing jetstream. !! Do not remove if you want to use jetstream. --}}

                  <x-switchable-team :team="$team" />
                  @endforeach
                @endif
              @endif
              <li>
                <div class="dropdown-divider"></div>
              </li>
              @if (Auth::check())
                <li>
                  <div class="d-grid px-4 pt-2 pb-1">
                    <a class="btn btn-sm btn-danger d-flex" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      <small class="align-middle">Cerrar sesión</small>
                      <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                    </a>
                  </div>
                </li>
                <form method="POST" id="logout-form" action="{{ route('logout') }}">
                  @csrf
                </form>
              @else
                <li>
                  <div class="d-grid px-4 pt-2 pb-1">
                    <a class="btn btn-sm btn-danger d-flex" href="{{ Route::has('login') ? route('login') : url('auth/login-basic') }}">
                      <small class="align-middle">Login</small>
                      <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                    </a>
                  </div>
                </li>
              @endif
             </ul>
          </li>
          <!--/ User -->
        </ul>
      </div>

      <!-- Search Small Screens -->
      <div class="navbar-search-wrapper search-input-wrapper {{ isset($menuHorizontal) ? $containerNav : '' }} d-none">
        <input type="text" class="form-control search-input {{ isset($menuHorizontal) ? '' : $containerNav }} border-0" placeholder="Buscar..." aria-label="Buscar...">
        <i class="ri-close-fill search-toggler cursor-pointer"></i>
      </div>
      <!--/ Search Small Screens -->
      @if(!isset($navbarDetached))
    </div>
    @endif
  </nav>
  <!-- / Navbar -->


  <script>

function redirigirNotificacion(url, id) {
        marcarComoLeida(id);
        window.location.href = url;
    }




function marcarComoLeida(notificationId) {
    $.ajax({
        url: '/notificacion-leida/' + notificationId, // Ruta al controlador que marcará la notificación como leída
        type: 'POST',
        data: {
            '_token': '{{ csrf_token() }}' // Agrega el token CSRF para proteger tu solicitud
        },
        success: function(response) {
            $('#notification_' + response.id).remove();


        },
        error: function(xhr, status, error) {
            console.error(error); // Maneja cualquier error que ocurra durante la solicitud AJAX
        }
    });
}





  </script>
