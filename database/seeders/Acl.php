<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Acl extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    	$modList = [];
        $i=0;

        //Dept
        \App\Models\Dept::updateOrCreate(
            [
                'deptcode'      => 'ho',
            ],
            [
                'deptname'    	=> 'Head Office',
                'deptemail'     => 'ho@company.com',
                'depttelp'      => '021654987',
                'deptaddress'   => 'Jakarta',
                'created_by'    => 1,
            ]
        );

        \App\Models\Dept::updateOrCreate(
            [
                'deptcode'      => 'dki',
            ],
            [
                'deptname'    	=> 'Jabodetabek',
                'deptperent'    => 'ho',
                'deptemail'     => 'jabodetabek@company.com',
                'depttelp'      => '021456258',
                'deptaddress'   => 'Jabodetabek',
                'created_by'    => 1,
            ]
        );

        \App\Models\Dept::updateOrCreate(
            [
                'deptcode'      => 'jkt',
            ],
            [
                'deptname'    	=> 'Jakarta',
                'deptperent'    => 'dki',
                'deptemail'     => 'jakarta@company.com',
                'depttelp'      => '021987321',
                'deptaddress'   => 'Jakarta',
                'created_by'    => 1,
            ]
        );

        \App\Models\Dept::updateOrCreate(
            [
                'deptcode'      => 'bks',
            ],
            [
                'deptname'    	=> 'Bekasi',
                'deptperent'    => 'dki',
                'deptemail'     => 'bekasi@company.com',
                'depttelp'      => '021123456',
                'deptaddress'   => 'Bekasi',
                'created_by'    => 1,
            ]
        );

        \App\Models\Dept::updateOrCreate(
            [
                'deptcode'      => 'slo',
            ],
            [
                'deptname'    	=> 'Solo',
                'deptperent'    => 'ho',
                'deptemail'     => 'solo@company.com',
                'depttelp'      => '0276369852',
                'deptaddress'   => 'Solo',
                'created_by'    => 1,
            ]
        );
        //End Dept

        //Module
        $i=$i+1;
        \App\Models\Module::updateOrCreate(
            [
                'modulekode'       => 'dashboard',
            ],
            [
                'modulename'        => 'Dashboard',
                'moduledesk'        => 'Halaman dashboard',
                'moduleurl'         => 'dashboard',
                'moduleicon'        => 'fa fa-dashboard',
                'modulesort'        => $i,
            ]
        );
        array_push($modList, 'dashboard');

        $i=$i+1;
        \App\Models\Module::updateOrCreate(
            [
                'modulekode'       => 'dept',
            ],
            [
                'modulename'        => 'Departemen',
                'moduledesk'        => 'Menampilkan data departemen',
                'moduleurl'         => 'dept',
                'moduleicon'        => 'fa fa-university',
                'modulesort'        => $i,
            ]
        );
        array_push($modList, 'dept');

        $i=$i+1;
        \App\Models\Module::updateOrCreate(
            [
                'modulekode'       => 'pegawai',
            ],
            [
                'modulename'        => 'Pegawai',
                'moduledesk'        => 'Menampilkan data pegawai',
                'moduleurl'         => 'pegawai',
                'moduleicon'        => 'fa fa-users',
                'modulesort'        => $i,
            ]
        );
        array_push($modList, 'pegawai');

        $i=$i+1;
        \App\Models\Module::updateOrCreate(
            [
                'modulekode'       => 'role',
            ],
            [
                'modulename'        => 'Role',
                'moduledesk'        => 'Menampilkan data role',
                'moduleurl'         => 'role',
                'moduleicon'        => 'fa fa-expeditedssl',
                'modulesort'        => $i,
            ]
        );
        array_push($modList, 'role');

        $i=$i+1;
        \App\Models\Module::updateOrCreate(
            [
                'modulekode'       => 'user',
            ],
            [
                'modulename'        => 'User',
                'moduledesk'        => 'Menampilkan data user',
                'moduleurl'         => 'user',
                'moduleicon'        => 'fa fa-user',
                'modulesort'        => $i,
            ]
        );
        array_push($modList, 'user');

        $i=$i+1;
        \App\Models\Module::updateOrCreate(
            [
                'modulekode'       => 'setting',
            ],
            [
                'modulename'    	=> 'Pengaturan',
                'moduledesk'        => 'Pengaturan web',
                'moduleurl'       	=> 'setting',
                'moduleicon'       	=> 'fa fa-cogs',
                'modulesort'       	=> $i,
            ]
        );
        array_push($modList, 'setting');
        //End Module

        //Role
        \App\Models\Role::updateOrCreate(
            [
                'id'       => 1,
            ],
            [
                'rolename'    	=> 'Superadmin',
                'roledesk'      => 'Superadmin',
                'modulelists'   => json_encode($modList),
                'created_by'    => 1,
            ]
        );
        \App\Models\Role::updateOrCreate(
            [
                'id'       => 2,
            ],
            [
                'rolename'      => 'Other Role',
                'roledesk'      => 'Other Role',
                'modulelists'   => json_encode(['dashboard']),
                'created_by'    => 1,
            ]
        );

        \DB::statement("SELECT setval('roles_id_seq', (SELECT max(id) FROM roles));");
        //End Role

        //User
        \App\Models\User::updateOrCreate(
            [
                'username' 		=> 'admin',
                'email' 		=> 'admin@company.com',
            ],
            [
                'name' 			=> 'Administrator',
                'password' 		=> bcrypt('123456'),
                'role_id' 		=> 1,
                'created_by'    => 1,
            ]
        );
        //End User
    }
}
