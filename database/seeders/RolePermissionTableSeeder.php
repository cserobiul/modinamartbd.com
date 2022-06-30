<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //find user
        $user = User::find(1);

        //Create Roles
        $SuperAdminRole = Role::create(['name' => 'super admin']);
        $GuestRole = Role::create(['name' => 'guest']);
        $CustomerRole = Role::create(['name' => 'customer']);

        //If user found
        if ($user){
            $user->assignRole($SuperAdminRole);
        }

        //Permission List as array
        $permissions = [
            [
                'group_name' => 'brand',
                'permissions' => [
                    'brand.all',
                    'brand.create',
                    'brand.show',
                    'brand.update',
                    'brand.delete',
                    'brand.approved',
                ]
            ],
             [
                'group_name' => 'buyer',
                'permissions' => [
                    'buyer.all',
                    'buyer.create',
                    'buyer.show',
                    'buyer.update',
                    'buyer.delete',
                    'buyer.approved',
                ]
            ],

            [
                'group_name' => 'category',
                'permissions' => [
                    'category.all',
                    'category.create',
                    'category.show',
                    'category.update',
                    'category.delete',
                    'category.approved',
                ]
            ],

            [
                'group_name' => 'unit',
                'permissions' => [
                    'unit.all',
                    'unit.create',
                    'unit.show',
                    'unit.update',
                    'unit.delete',
                    'unit.approved',
                ]
            ],
            [
                'group_name' => 'size',
                'permissions' => [
                    'size.all',
                    'size.create',
                    'size.show',
                    'size.update',
                    'size.delete',
                    'size.approved',
                ]
            ],
            [
                'group_name' => 'color',
                'permissions' => [
                    'color.all',
                    'color.create',
                    'color.show',
                    'color.update',
                    'color.delete',
                    'color.approved',
                ]
            ],
            [
                'group_name' => 'product',
                'permissions' => [
                    'product.all',
                    'product.create',
                    'product.show',
                    'product.update',
                    'product.delete',
                    'product.approved',
                ]
            ],


            [
                'group_name' => 'payment_method',
                'permissions' => [
                    'payment_method.all',
                    'payment_method.create',
                    'payment_method.show',
                    'payment_method.update',
                    'payment_method.delete',
                    'payment_method.approved',
                ]
            ],
             [
                'group_name' => 'warranty',
                'permissions' => [
                    'warranty.all',
                    'warranty.create',
                    'warranty.show',
                    'warranty.update',
                    'warranty.delete',
                    'warranty.approved',
                ]
            ],

            [
                'group_name' => 'purchase',
                'permissions' => [
                    'purchase.all',
                    'purchase.create',
                    'purchase.show',
                    'purchase.update',
                    'purchase.delete',
                    'purchase.approved',
                ]
            ],
            [
                'group_name' => 'stock',
                'permissions' => [
                    'stock.all',
                    'stock.create',
                    'stock.show',
                    'stock.update',
                    'stock.delete',
                    'stock.approved',
                ]
            ],

            [
                'group_name' => 'sms',
                'permissions' => [
                    'sms.all',
                    'sms.create',
                    'sms.show',
                    'sms.update',
                    'sms.delete',
                    'sms.approved',
                ]
            ],
            [
                'group_name' => 'slider',
                'permissions' => [
                    'slider.all',
                    'slider.create',
                    'slider.show',
                    'slider.update',
                    'slider.delete',
                    'slider.approved',
                ]
            ],

            [
                'group_name' => 'profile',
                'permissions' => [
                    'profile.all',
                    'profile.create',
                    'profile.show',
                    'profile.update',
                    'profile.delete',
                    'profile.approved',
                    'profile.self',
                ]
            ],
            [
                'group_name' => 'user_log',
                'permissions' => [
                    'user_log.all',
                    'user_log.create',
                    'user_log.show',
                    'user_log.update',
                    'user_log.delete',
                ]
            ],
            [
                'group_name' => 'report',
                'permissions' => [
                    'report.all',
                    'report.create',
                    'report.show',
                    'report.update',
                    'report.delete',
                ]
            ],

            [
                'group_name' => 'print',
                'permissions' => [
                    'print.all',
                    'print.show',
                    'print.admin',
                    'print.general',
                    'print.lifetime',
                ]
            ],
            [
                'group_name' => 'user',
                'permissions' => [
                    'user.all',
                    'user.create',
                    'user.show',
                    'user.update',
                    'user.delete',
                    'user.approved',
                ]
            ],
            [
                'group_name' => 'order',
                'permissions' => [
                    'order.all',
                    'order.create',
                    'order.show',
                    'order.update',
                    'order.delete',
                    'order.approved',
                ]
            ],
            [
                'group_name' => 'sale',
                'permissions' => [
                    'sale.all',
                    'sale.create',
                    'sale.show',
                    'sale.update',
                    'sale.delete',
                    'sale.approved',
                ]
            ],

            [
                'group_name' => 'customer',
                'permissions' => [
                    'customer.all',
                    'customer.create',
                    'customer.show',
                    'customer.update',
                    'customer.delete',
                    'customer.approved',
                    'customer.self',
                ]
            ],

            [
                'group_name' => 'supplier',
                'permissions' => [
                    'supplier.all',
                    'supplier.create',
                    'supplier.show',
                    'supplier.update',
                    'supplier.delete',
                    'supplier.approved',
                    'supplier.self',
                ]
            ],
             [
                'group_name' => 'accounts',
                'permissions' => [
                    'accounts.all',
                    'accounts.create',
                    'accounts.show',
                    'accounts.update',
                    'accounts.delete',
                    'accounts.approved',
                ]
            ],


            [
                'group_name' => 'role',
                'permissions' => [
                    'role.all',
                    'role.create',
                    'role.show',
                    'role.update',
                    'role.delete',
                ]
            ],
            [
                'group_name' => 'notebook',
                'permissions' => [
                    'notebook.all',
                    'notebook.create',
                    'notebook.show',
                    'notebook.update',
                    'notebook.delete',
                ]
            ],
            [
                'group_name' => 'settings',
                'permissions' => [
                    'settings.all',
                    'settings.create',
                    'settings.show',
                    'settings.update',
                    'settings.delete',
                ]
            ],

        ];

        //Assign Permissions
        for ($i = 0; $i < count($permissions); $i++){
            $permissionGroup = $permissions[$i]['group_name'];

            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++){
                // Create Permission
                $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j],'group_name' =>  $permissionGroup ]);
                $SuperAdminRole->givePermissionTo($permission);
                $permission->assignRole($SuperAdminRole);
            }
        }

    }
}
