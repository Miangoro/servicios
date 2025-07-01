<x-form-section submit="uploadSignature">
  <x-slot name="title">
    {{ __('Subir Firma') }}
  </x-slot>

  <x-slot name="description">
    {{ __('Sube una imagen para usar como tu firma. Asegúrate de que sea clara y de tamaño adecuado.') }}
  </x-slot>

  <x-slot name="form">
    <!-- Firma -->
    <div class="mb-6" x-data="{ fileName: null, filePreview: null }">
      <!-- Campo oculto para subir archivo -->
      <input type="file" hidden wire:model.live="signature" x-ref="file"
        x-on:change="
          fileName = $refs.file.files[0].name;
          const reader = new FileReader();
          reader.onload = (e) => { filePreview = e.target.result; };
          reader.readAsDataURL($refs.file.files[0]);
        " />

        <!-- Vista previa de la firma actual -->
        <div class="mt-2" x-show="!filePreview">
          <p>{{ __('Firma actual:') }}</p>
          @if($signatureUrl)
            <img src="{{ $signatureUrl }}" class="img-thumbnail" width="200">
          @else
            <p>{{ __('No se ha subido ninguna firma aún.') }}</p>
          @endif
        </div>

      <!-- Vista previa de la nueva firma -->
      <div class="mt-2" x-show="filePreview">
        <p>{{ __('Vista previa de la nueva firma:') }}</p>
        <img x-bind:src="filePreview" class="img-thumbnail" width="200">
      </div>

      <!-- Botón para seleccionar archivo -->
      <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.file.click()">
        {{ __('Seleccionar nueva firma') }}
      </x-secondary-button>

      <!-- Botón para eliminar firma actual -->

        <button type="button" class="btn btn-danger mt-2" wire:click="deleteSignature">
          {{ __('Eliminar firma') }}
        </button>


      <x-input-error for="signature" class="mt-2" />
    </div>
  </x-slot>

  <x-slot name="actions">
    <div class="d-flex align-items-baseline">
      <x-button>
        {{ __('Guardar Firma') }}
      </x-button>
    </div>
  </x-slot>
</x-form-section>
