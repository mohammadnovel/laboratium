<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
  
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           'role.list',
           'role.create',
           'role.edit',
           'role.delete',
           'role.show',
           'user.list',
           'user.create',
           'user.edit',
           'user.delete',
           'user.show',
           'permission.list',
           'permission.create',
           'permission.edit',
           'permission.delete',
           'permission.show',
           'compotition.show',
           'compotition.create',
           'compotition.edit',
           'compotition.delete',
           'service.show',
           'service.create',
           'service.edit',
           'service.delete',
           'mutu-indicator.show',
           'mutu-indicator.create',
           'mutu-indicator.edit',
           'mutu-indicator.delete',
           'parameter.show',
           'parameter.create',
           'parameter.edit',
           'parameter.delete',
           'report.show',
           'report.create',
           'report.edit',
           'report.delete',
           'indification.show',
           'indification.create',
           'indification.edit',
           'indification.delete',
           'general.show',
           'general.create',
           'general.edit',
           'general.delete',
           'patient-indification.show',
           'patient-indification.create',
           'patient-indification.edit',
           'patient-indification.delete',
        ];
     
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}