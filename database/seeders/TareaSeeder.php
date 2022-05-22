<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tarea;

class TareaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tarea::create([
            'nombre' => 'Registrar Inv. Diario',
            
            'hora_inicio' => '10:30:20',
            'hora_fin' => '10:40:20',
            'turno' => 'Pre Turno',
            'dia_semana' => 'Lunes',
            'cargo_id' => 1,
           
        ]);

        Tarea::create([
            'nombre' => 'Registrar Inv. Semanal',
  
            'hora_inicio' => '11:30:20',
            'turno' => 'Turno',
            'dia_semana' => 'Lunes',
            'cargo_id' => 1,
           
        ]);

        Tarea::create([
            'nombre' => 'Rellenar Planilla de Costos',            
            'hora_inicio' => '08:20:20',
            'turno' => 'Post Turno',
            'dia_semana' => 'Lunes',
            'cargo_id' => 2,
           
        ]);
    }
}
