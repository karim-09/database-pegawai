<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class Pegawai extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    	$faker = Faker::create('id_ID');
    	for($i = 1; $i <= 50; $i++){
    		$nip = 'PGW-'.$i;
    		$gender = $faker->randomElement(['male', 'female']);
    		$created_at = date('Y-m-d H:i:s');
    		$tmp_lahir = $faker->randomElement(['Boyolali', 'Solo', 'Sleman', 'Semarang', 'Jakarta']);

    		$deptLists = [];
    		$getDept = \App\Models\Dept::all();
    		foreach ($getDept as $dept) {
	     		$deptLists[] = $dept->deptcode;
    		}
    		$deptcode = $faker->randomElement($deptLists);

    		$agm = [];
    		$sn = [];
    		$pnd = [];
    		$getOption = \App\Models\Ms_options::all();
    		foreach ($getOption as $opt) {
	     		if($opt->untuk == 'agama'){
		     		array_push($agm, $opt->kode);
		     	}
	     		if($opt->untuk == 'statusnikah'){
		     		array_push($sn, $opt->kode);
		     	}
	     		if($opt->untuk == 'pendidikan'){
		     		array_push($pnd, $opt->kode);
		     	}
    		}

    		if($gender == 'male'){
    			$jenis_kelamin = 'L';
    			unset($sn['JD']);
    		}else{
    			$jenis_kelamin = 'P';
    			unset($sn['DD']);
    		}

    		$agama = $faker->randomElement($agm);
    		$status_nikah = $faker->randomElement($sn);
    		$pendidikan = $faker->randomElement($pnd);

            \App\Models\Pegawai::updateOrCreate(
                [
                    'nip' 	=> $nip,
                ],
                [
                    'nama' 	=> $faker->name($gender),
                    'nik' 	=> randomNumber(16),
                    'tmp_lahir' => $tmp_lahir,
                    'tgl_lahir' => $faker->dateTimeBetween('1990-01-01', '2002-01-31')->format('Y-m-d'),
                    'jenis_kelamin' => $jenis_kelamin,
                    'deptcode' => $deptcode,
                    'agama' => $agama,
                    'status_nikah' => $status_nikah,
                    'pendidikan' => $pendidikan,
                    'nama_ayah' => $faker->name('male'),
                    'nama_ibu' => $faker->name('female'),
                    'tgl_masuk' => $faker->dateTimeBetween('2024-01-01', date('Y-m-d'))->format('Y-m-d'),
                    'jabatan' => 'STF',
                    'no_hp' => $faker->unique()->e164PhoneNumber(),
                    'email' => $faker->email,
                    'status' => 'A',
                ]
            );
    	}
    }
}
