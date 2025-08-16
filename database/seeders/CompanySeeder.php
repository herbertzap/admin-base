<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Company::create([
            'name' => 'Importadora Ejemplo S.A.',
            'rut' => '76.123.456-7',
            'address' => 'Av. Providencia 1234',
            'city' => 'Santiago',
            'phone' => '+56 2 2345 6789',
            'email' => 'contacto@importadoraejemplo.cl',
            'contact_person' => 'Juan Pérez',
            'contact_phone' => '+56 9 8765 4321',
            'contact_email' => 'juan.perez@importadoraejemplo.cl',
            'is_active' => true,
            'notes' => 'Empresa de ejemplo para pruebas del sistema Hermes'
        ]);

        \App\Models\Company::create([
            'name' => 'Comercial Internacional Ltda.',
            'rut' => '78.987.654-3',
            'address' => 'Las Condes 5678',
            'city' => 'Santiago',
            'phone' => '+56 2 3456 7890',
            'email' => 'info@comercialinternacional.cl',
            'contact_person' => 'María González',
            'contact_phone' => '+56 9 1234 5678',
            'contact_email' => 'maria.gonzalez@comercialinternacional.cl',
            'is_active' => true,
            'notes' => 'Empresa especializada en importaciones de tecnología'
        ]);
    }
}
