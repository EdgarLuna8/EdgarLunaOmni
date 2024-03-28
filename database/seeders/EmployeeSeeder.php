<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Creamos una instancia de Faker
        $faker = Faker::create();

        // Creamos 20 empleados falsos
        for ($i = 0; $i < 30; $i++) {
            Employee::create([
                'codigo' => $faker->unique()->randomNumber(5),
                'nombre' => $faker->name,
                'salarioDolares' => $faker->numberBetween(1000, 5000),
                'salarioPesos' => $faker->numberBetween(20000, 100000),
                'direccion' => "Av Patria 555 Col. Ladron de Guevara, Zapopan Jal",
                'estado' => $faker->state,
                'ciudad' => $faker->city,
                'celular' => $faker->phoneNumber,
                'correo' => $faker->unique()->safeEmail,
                'activo' => $faker->boolean
            ]);
        }
    }
}
