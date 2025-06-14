<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportPersonasImages extends Command
{
    protected $signature = 'personas:import-images';
    protected $description = 'Importa imágenes desde public/personas_import a storage/app/public/personas';

    public function handle()
    {
        $source = public_path('personas_import');
        $dest = storage_path('app/public/personas');

        if (!is_dir($source)) {
            $this->error('No existe la carpeta public/personas_import');
            return;
        }

        // Crear la carpeta de destino si no existe
        if (!is_dir($dest)) {
            mkdir($dest, 0777, true);
        }

        $copiados = 0;
        foreach (glob($source . '/*.*') as $file) {
            $filename = basename($file);
            if (copy($file, $dest . '/' . $filename)) {
                $this->info("Copiado: $filename");
                $copiados++;
            } else {
                $this->error("Error al copiar: $filename");
            }
        }

        $this->info("Importación finalizada. Total copiados: $copiados");
    }
}
