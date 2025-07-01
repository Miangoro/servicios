<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SignatureUpload extends Component
{
  use WithFileUploads;
    public $signature;
    public $user;
      public function render()
      {
          return view('profile.subir-firmas-perfil', [
              'signatureUrl' => $this->user->firma
                  ? asset('storage/firmas/' . $this->user->firma)
                  : null,
          ]);
      }

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function uploadSignature()
    {
        $this->validate([
            'signature' => 'image|max:2048', // 2MB máximo
        ]);

        // Borra la firma anterior si existe
        if ($this->user->firma) {
            Storage::disk('public')->delete('firmas/' . $this->user->firma);
        }

        // Guarda la nueva firma con nombre único
        $filename = 'firma_' . str_replace(' ', '_', $this->user->name) . '_' . time() . '.' . $this->signature->getClientOriginalExtension();
        $this->signature->storeAs('firmas', $filename, 'public');
        $this->user->firma = $filename;
        $this->user->save();

        session()->flash('message', 'Firma actualizada correctamente.');
    }

    public function deleteSignature()
    {
        if ($this->user->firma) {
            Storage::disk('public')->delete('firmas/' . $this->user->firma);
            $this->user->firma = null;
            $this->user->save();
        }
        session()->flash('message', 'Firma eliminada correctamente.');
    }


}
