<x-action-section>
  <x-slot name="title">
    {{ __('Sesiones del Navegador') }}
  </x-slot>

  <x-slot name="description">
    {{ __('Administra y cierra las sesiones activas en otros navegadores y dispositivos.') }}
  </x-slot>

  <x-slot name="content">
    <x-action-message on="loggedOut">
      {{ __('Hecho.') }}
    </x-action-message>

    <p class="card-text">
      {{ __('Si es necesario, puedes cerrar todas tus demás sesiones de navegador en todos tus dispositivos. Algunas de tus sesiones recientes están listadas a continuación; sin embargo, esta lista puede no ser exhaustiva. Si sientes que tu cuenta ha sido comprometida, también deberías actualizar tu contraseña.') }}
    </p>

    @if (count($this->sessions) > 0)
      <div class="mt-5">
        <!-- Other Browser Sessions -->
        @foreach ($this->sessions as $session)
          <div class="d-flex">
            <div>
              @if ($session->agent->isDesktop())
                <svg fill="none" width="32" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  viewBox="0 0 24 24" stroke="currentColor" class="text-muted">
                  <path
                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                  </path>
                </svg>
              @else
                <svg xmlns="http://www.w3.org/2000/svg" width="32" viewBox="0 0 24 24" stroke-width="2"
                  stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"
                  class="text-muted">
                  <path d="M0 0h24v24H0z" stroke="none"></path>
                  <rect x="7" y="4" width="10" height="16" rx="1"></rect>
                  <path d="M11 5h2M12 17v.01"></path>
                </svg>
              @endif
            </div>

            <div class="ms-2">
              <div>
                {{ $session->agent->platform() ? $session->agent->platform() : 'Unknown' }} -
                {{ $session->agent->browser() ? $session->agent->browser() : 'Unknown' }}
              </div>

              <div>
                <div class="small text-muted">
                  {{ $session->ip_address }},

                  @if ($session->is_current_device)
                    <span class="text-success fw-medium">{{ __('Este dispositivo') }}</span>
                  @else
                    {{ __('Última actividad') }} {{ $session->last_active }}
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif

    <div class="d-flex mt-5">
      <x-button wire:click="confirmLogout" wire:loading.attr="disabled">
        {{ __('Cerrar Sesión en Otros Navegadores') }}
      </x-button>
    </div>

    <!-- Log out Other Devices Confirmation Modal -->
    <x-dialog-modal wire:model.live="confirmingLogout">
      <x-slot name="title">
        {{ __('Cerrar Sesión en Otros Navegadores') }}
      </x-slot>

      <x-slot name="content">
        {{ __('Por favor, introduce tu contraseña para confirmar que deseas cerrar sesión en tus otras sesiones de navegador en todos tus dispositivos.') }}

        <div class="mt-3" x-data="{}"
          x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
          <x-input type="password" placeholder="{{ __('Password') }}" x-ref="password"
            class="{{ $errors->has('password') ? 'is-invalid' : '' }}" wire:model="password"
            wire:keydown.enter="logoutOtherBrowserSessions" />

          <x-input-error for="password" class="mt-2" />
        </div>
      </x-slot>

      <x-slot name="footer">
        <x-secondary-button wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled">
          {{ __('Cancelar') }}
        </x-secondary-button>

        <button class="btn btn-danger ms-1" wire:click="logoutOtherBrowserSessions"
          wire:loading.attr="disabled">
          {{ __('Cerrar Sesión en Otros Navegadores') }}
        </button>
      </x-slot>
    </x-dialog-modal>
  </x-slot>

</x-action-section>
