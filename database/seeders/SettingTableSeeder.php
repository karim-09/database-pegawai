<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Setting::updateOrCreate(
            [
                'id_setting'        => 1,
            ],
            [
                'nama_perusahaan'   => 'PT ABC DEF GHI',
                'alamat'            => 'Jl. Moyudan',
                'telepon'           => '08123456789',
                'path_logo'         => '/img/logo.png',
            ]
        );
    }
}
