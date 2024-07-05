<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Option extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
        	[
        		'kode' => '1',
        		'nama' => 'SD',
        		'untuk' => 'pendidikan',
        	],
        	[
        		'kode' => '2',
        		'nama' => 'SMP',
        		'untuk' => 'pendidikan',
        	],
        	[
        		'kode' => '3',
        		'nama' => 'SMA/SMK',
        		'untuk' => 'pendidikan',
        	],
        	[
        		'kode' => '4',
        		'nama' => 'D1',
        		'untuk' => 'pendidikan',
        	],
        	[
        		'kode' => '5',
        		'nama' => 'D2',
        		'untuk' => 'pendidikan',
        	],
        	[
        		'kode' => '6',
        		'nama' => 'D2',
        		'untuk' => 'pendidikan',
        	],
        	[
        		'kode' => '7',
        		'nama' => 'D3',
        		'untuk' => 'pendidikan',
        	],
        	[
        		'kode' => '8',
        		'nama' => 'D4',
        		'untuk' => 'pendidikan',
        	],
        	[
        		'kode' => '9',
        		'nama' => 'S1',
        		'untuk' => 'pendidikan',
        	],
        	[
        		'kode' => '10',
        		'nama' => 'S2',
        		'untuk' => 'pendidikan',
        	],
        	[
        		'kode' => '11',
        		'nama' => 'S3',
        		'untuk' => 'pendidikan',
        	],
        	[
        		'kode' => 'A',
        		'nama' => 'Aktif',
        		'untuk' => 'statuspegawai',
        	],
        	[
        		'kode' => 'M',
        		'nama' => 'Mengundurkan Diri',
        		'untuk' => 'statuspegawai',
        	],
        	[
        		'kode' => 'MD',
        		'nama' => 'Meninggal Dunia',
        		'untuk' => 'statuspegawai',
        	],
        	[
        		'kode' => 'D',
        		'nama' => 'Dikeluarkan',
        		'untuk' => 'statuspegawai',
        	],
            [
                'kode' => 'L',
                'nama' => 'Laki-Laki',
                'untuk' => 'jeniskelamin',
            ],
            [
                'kode' => 'P',
                'nama' => 'Perempuan',
                'untuk' => 'jeniskelamin',
            ],
            [
                'kode' => 'IS',
                'nama' => 'Islam',
                'untuk' => 'agama',
            ],
            [
                'kode' => 'KR',
                'nama' => 'Kristen',
                'untuk' => 'agama',
            ],
            [
                'kode' => 'KT',
                'nama' => 'Katolik',
                'untuk' => 'agama',
            ],
            [
                'kode' => 'HI',
                'nama' => 'Hindu',
                'untuk' => 'agama',
            ],
            [
                'kode' => 'BU',
                'nama' => 'Budha',
                'untuk' => 'agama',
            ],
            [
                'kode' => 'LJ',
                'nama' => 'Lajang',
                'untuk' => 'statusnikah',
            ],
            [
                'kode' => 'NK',
                'nama' => 'Nikah',
                'untuk' => 'statusnikah',
            ],
            [
                'kode' => 'DD',
                'nama' => 'Duda',
                'untuk' => 'statusnikah',
            ],
            [
                'kode' => 'JD',
                'nama' => 'Janda',
                'untuk' => 'statusnikah',
            ],
            [
                'kode' => 'DIR',
                'nama' => 'Direktur',
                'untuk' => 'jabatan',
            ],
            [
                'kode' => 'MNG',
                'nama' => 'Manager',
                'untuk' => 'jabatan',
            ],
            [
                'kode' => 'STF',
                'nama' => 'Staff',
                'untuk' => 'jabatan',
            ],
        ];

        foreach ($options as $key => $value) {
            \App\Models\Ms_options::updateOrCreate(
                [
                    'kode' 	=> $value['kode'],
                    'untuk' => $value['untuk'],
                ],
                [
                    'nama' 	=> $value['nama'],
                ]
            );
        }
    }
}
