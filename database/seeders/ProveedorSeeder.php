<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proveedor;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proveedor::Create([
            'nombre' => 'Sofia',
            'estado' =>1
        ]);
        Proveedor::Create([
            'nombre' => 'Frigor',
            'estado' =>1

        ]);
        Proveedor::Create([
            'nombre' => 'Impastas S.A.',
            'estado' =>1

        ]);
        Proveedor::Create([
            'nombre' => 'EMBOL SA',
            'estado' =>1

        ]);
        Proveedor::Create([
            'nombre' => 'MAXIMILIANA',
            'estado' =>1

        ]);
    }
}
