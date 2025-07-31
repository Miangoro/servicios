<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::table('catalogo_proveedores_contactos', function (Blueprint $table) {
            $table->foreign('id_proveedor')
                  ->references('id_proveedor')
                  ->on('catalogo_proveedores')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catalogo_proveedores_contactos', function (Blueprint $table) {
             $table->dropForeign(['id_proveedor']);
        });
    }
};
