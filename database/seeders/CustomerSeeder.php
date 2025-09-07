<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'full_name' => 'Budi Santoso',
                'phone'     => '081234567890',
                'email'     => 'budi@example.com',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'full_name' => 'Siti Aminah',
                'phone'     => '082112223333',
                'email'     => 'siti@example.com',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'full_name' => 'Agus Pratama',
                'phone'     => '085512341234',
                'email'     => 'agus@example.com',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
        ]);
    }
}
