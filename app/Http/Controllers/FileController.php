<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function show($filename)
    {
        $filePath = 'firmas/' . $filename;

        if (Storage::disk('public')->exists($filePath)) {
            return response()->file(storage_path('app/public/' . $filePath));
        }

        return response()->json(['message' => 'File not found'], 404);
    }

    public function show2($carpeta,$filename)
    {
        $filePath = 'uploads/' . $carpeta . '/' . $filename;
        $fullPath = storage_path('app/public/' . $filePath);

       

        if (Storage::disk('public')->exists($filePath)) {
            return response()->file($fullPath);
        }

        return response()->json(['message' => 'Archivo no encontrado'], 404);
    }

    public function show3($carpeta,$carpeta2,$filename)
    {
        $filePath = 'uploads/' . $carpeta . '/'. $carpeta2 . '/' . $filename;
        $fullPath = storage_path('app/public/' . $filePath);

       

        if (Storage::disk('public')->exists($filePath)) {
            return response()->file($fullPath);
        }

        return response()->json(['message' => 'Archivo no encontrado'], 404);
    }
}
