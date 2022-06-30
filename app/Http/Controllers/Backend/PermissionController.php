<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //Check authentication
        if (!Auth::user()->can('role.create')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Permission";
        return view('backend.role.permission_create',$data);
    }

    public function store(Request $request){
        //Check authentication
        if (!Auth::user()->can('role.create')){
            abort(403,'Unauthorized Action');
        }
        $permissionName = trim(strtolower($request->permission_name));
        $permissionsList = [
                $permissionName.'.all',
                $permissionName.'.create',
                $permissionName.'.show',
                $permissionName.'.update',
                $permissionName.'.delete',
                $permissionName.'.approved',
                $permissionName.'.self',
            ];
        foreach ($permissionsList as $key => $permission){
            $permissions = Permission::create(['name' => $permission,'guard_name' => 'web','group_name' =>  $permissionName ]);
        }
        return back()->with('success','Successfully Create New Permissions');

    }
}
