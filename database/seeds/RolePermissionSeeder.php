<?php
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class RolePermissionSeeder.
 *
 * @see https://spatie.be/docs/laravel-permission/v5/basic-usage/multiple-guards
 *
 * @package App\Database\Seeds
 */
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        // Permission List as array
        $permissions = [

            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'dashboard.view',
                    'dashboard.edit',
                ]
            ],
            [
                'group_name' => 'admin',
                'permissions' => [
                    // admin Permissions
                    'admin.create',
                    'admin.view',
                    'admin.edit',
                    'admin.delete',
                ]
            ],
            [
                'group_name' => 'role',
                'permissions' => [
                    // role Permissions
                    'role.create',
                    'role.view',
                    'role.edit',
                    'role.delete',
                ]
            ],
            [
                'group_name' => 'article',
                'permissions' => [
                    // article Permissions
                    'article.create',
                    'article.view',
                    'article.edit',
                    'article.delete',
                ]
            ],
             [
                'group_name' => 'category',
                'permissions' => [
                    // category Permissions
                    'category.create',
                    'category.view',
                    'category.edit',
                    'category.delete',
                ]
            ],

            [
                'group_name' => 'stock',
                'permissions' => [
                    // stock Permissions
                    'stock.view',
                    'stock.delete',
                ]
            ],
            [
                'group_name' => 'stockin',
                'permissions' => [
                    // stockin Permissions
                    'stockin.create',
                    'stockin.view',
                    'stockin.edit',
                    'stockin.show',
                    'stockin.delete',
                ]
            ],
            [
                'group_name' => 'sales',
                'permissions' => [
                    // sales Permissions
                    'sales.create',
                    'sales.view',
                    'sales.edit',
                    'sales.show',
                    'sales.delete',
                ]
            ],
             [
                'group_name' => 'setting',
                'permissions' => [
                    // setting Permissions
                    'setting.create',
                    'setting.view',
                    'setting.edit',
                    'setting.delete',
                ]
            ],
            [
                'group_name' => 'order',
                'permissions' => [
                    // order Permissions
                    'order.create',
                    'order.view',
                    'order.edit',
                    'order.delete',
                    'order.validate',
                    'order.confirm',
                    'order.approuve',
                    'order.reset',
                    'order.reject',
                ]
            ],
            [
                'group_name' => 'examen_documents',
                'permissions' => [
                    // documents Permissions
                    'fiche_entree.create',
                    'facture.create',
                    'fiche_commande.create',
                ]
            ],
        ];


        // Do same for the admin guard for tutorial purposes
        $roleSuperAdmin = Role::create(['name' => 'superadmin', 'guard_name' => 'admin']);

        // Create and Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup, 'guard_name' => 'admin']);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
            }
        }

        // Assign super admin role permission to superadmin user
        $admin = Admin::where('username', 'superadmin')->first();
        if ($admin) {
            $admin->assignRole($roleSuperAdmin);
        }
    }
}
