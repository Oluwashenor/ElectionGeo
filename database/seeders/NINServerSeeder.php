<?php

namespace Database\Seeders;

use App\Models\NinServer as ModelsNinServer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NINServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('nin_servers')->insert([
            'firstname' => "Oluwapelumi",
            'lastname' => "Fadairo EL-Faithful",
            'address' => "Address A",
            'nin' => "12345678909",
        ]);
    }
}
