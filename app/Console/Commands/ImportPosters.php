<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportPosters extends Command
{
    protected $signature = 'posters:import';
    protected $description = 'Importa imágenes desde public/posters_import a storage/app/public/posters';

    public function handle()
    {
        $source = public_path('posters_import');
        $dest = storage_path('app/public/posters');

        if (!is_dir($source)) {
            $this->error('No existe la carpeta public/posters_import');
            return;
        }

        // Crear la carpeta de destino si no existe
        if (!is_dir($dest)) {
            mkdir($dest, 0777, true);
        }

        foreach (glob($source . '/*.*') as $file) {
            $filename = basename($file);
            copy($file, $dest . '/' . $filename);
            $this->info("Copiado: $filename");
        }

        $this->info('Importación finalizada.');
    }
}