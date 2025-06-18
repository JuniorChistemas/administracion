<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MyCompany;


class MyCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MyCompany::factory()->create([
            'ruc' => '20412345678',
            'razon_social' => 'Mi Empresa SAC',
            'nombre_comercial' => 'MiComercial',
            'ubigueo' => '150101',
            'departamento' => 'Lima',
            'provincia' => 'Lima',
            'distrito' => 'Lima',
            'urbanizacion' => null,
            'direccion' => 'Av. Siempre Viva 742',
            'cod_local' => '0000',
        ]);
    }
}
