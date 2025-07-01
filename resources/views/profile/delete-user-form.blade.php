<x-action-section>
  <x-slot name="title">
    {{ __('Eliminar Cuenta') }}
  </x-slot>

  <x-slot name="description">
    {{ __('Elimina tu cuenta de forma permanente.') }}
  </x-slot>

  <x-slot name="content">
    <div>
      {{ __('Una vez que elimines tu cuenta, todos sus recursos y datos serán eliminados de forma permanente. Antes de eliminar tu cuenta, descarga cualquier dato o información que desees conservar.') }}
    </div>

    <div class="mt-3">
      <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
        {{ __('Eliminar Cuenta') }}
      </x-danger-button>
    </div>

    <!-- Delete User Confirmation Modal -->
    <x-dialog-modal wire:model.live="confirmingUserDeletion">
      <x-slot name="title">
        {{ __('Eliminar Cuenta') }}
      </x-slot>

      <x-slot name="content">
        {{ __('¿Estás seguro de que deseas eliminar tu cuenta? Una vez eliminada, todos tus recursos y datos serán eliminados de forma permanente. Por favor, introduce tu contraseña para confirmar que deseas eliminar tu cuenta de manera permanente.') }}

        <div class="mt-2" x-data="{}"
          x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
          <x-input type="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
            placeholder="{{ __('Password') }}" x-ref="password" wire:model="password"
            wire:keydown.enter="deleteUser" />

          <x-input-error for="password" />
        </div>
      </x-slot>

      <x-slot name="footer">
        <x-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
          {{ __('Cancelar') }}
        </x-secondary-button>

        <x-danger-button class="ms-1" wire:click="deleteUser" wire:loading.attr="disabled">
          {{ __('Eliminar Cuenta') }}
        </x-danger-button>
      </x-slot>
    </x-dialog-modal>
  </x-slot>

</x-action-section>
