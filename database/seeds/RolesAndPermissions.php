<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // create permissions
        Permission::create(['name' => 'depositos']);
        Permission::create(['name' => 'bancos']);
        Permission::create(['name' => 'cambiartasas']);
        Permission::create(['name' => 'deletebanco']);
        Permission::create(['name' => 'getbanco']);
        Permission::create(['name' => 'listardepositos']);
        Permission::create(['name' => 'listarusuarios']);
        Permission::create(['name' => 'misdepositos']);
        Permission::create(['name' => 'savecuenta']);
        Permission::create(['name' => 'savebanco']);
        Permission::create(['name' => 'savedeposito']);
        Permission::create(['name' => 'tasa']);
        Permission::create(['name' => 'tasas']);
        Permission::create(['name' => 'updatebanco']);
        Permission::create(['name' => 'cargarpagos']);

        // create roles and assign created permissions

        $role = Role::create(['name' => 'Mayorista']);
        $role->givePermissionTo('depositos');
        $role->givePermissionTo('cargarpagos');
        $role->givePermissionTo('misdepositos');
        
        $role = Role::create(['name' => 'cliente']);
        $role->givePermissionTo('depositos');
        $role->givePermissionTo('misdepositos');

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
        
        $role = Role::create(['name' => 'developers']);
        $role->givePermissionTo(Permission::all());
    }
}
