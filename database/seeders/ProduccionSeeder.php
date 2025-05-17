<?php

namespace Database\Seeders;

use App\Models\Produccion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProduccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Produccion::factory()
            ->count(20)
            ->hasGenero()
            ->create();
    }
}
