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
        Permission::create(['name' => 'Recibos']);
        Permission::create(['name' => 'Cargar pagos']);
        Permission::create(['name' => 'Actualizar usuario']);
        Permission::create(['name' => 'Mis bancos']);
        Permission::create(['name' => 'Usuarios']);
        Permission::create(['name' => 'Transferencias']);

        // create roles and assign created permissions

        $role = Role::create(['name' => 'cliente']);
        $role->givePermissionTo('Recibos');
        $role->givePermissionTo('Cargar pagos');
        $role->givePermissionTo('Mis bancos');

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
        
        $role = Role::create(['name' => 'developers']);
        $role->givePermissionTo(Permission::all());
    }
}
