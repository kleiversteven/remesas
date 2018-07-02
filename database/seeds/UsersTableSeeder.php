<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $cliente = User::Create([
           'name' => "cliente",
            'email'=> 'cliente@correo.com',
            'password' => '12345'
        ]);
        $cliente->assignRole('cliente');
        
        $developer = User::Create([
           'name' => "developer",
            'email'=> 'developer@correo.com',
            'password' => '12345'
        ]);
        $developer->assignRole('developers');
        $super_admin = User::Create([
           'name' => "admin",
            'email'=> 'admin@correo.com',
            'password' => '12345'
        ]);
        $super_admin->assignRole('super-admin');
    }
}
