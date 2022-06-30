<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('role.all')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Roles";
        $data['roles'] = Role::all();

        $permissionName = 'customer';

//        $permission = Permission::create(['name' => $permissionName.'.self','guard_name' => 'web', 'group_name' =>  $permissionName ]);
//        $permission = Permission::create(['name' => $permissionName.'.show','guard_name' => 'web', 'group_name' =>  $permissionName ]);
//        $permission = Permission::create(['name' => $permissionName.'.update','guard_name' => 'web', 'group_name' =>  $permissionName ]);
//        $permission = Permission::create(['name' => $permissionName.'.delete','guard_name' => 'web', 'group_name' =>  $permissionName ]);
//        $permission = Permission::create(['name' => $permissionName.'.approved','guard_name' => 'web', 'group_name' =>  $permissionName ]);

        return view('backend.role.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('role.create')){
            abort(403,'Unauthorized Action');
        }
        $data['permissions'] = Permission::all();
        $data['permission_groups'] = User::getPermissionGroups();
        // dd($permission_groups);
        return view('backend.role.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //dd($request->all());
        //Check authentication
        if (!Auth::user()->can('role.create')){
            abort(403,'Unauthorized Action');
        }
        // Validation Data
        $request->validate([
            'name' => ['required', 'min:4','max:30','unique:roles'],
        ],[
            'name.required' => 'Please give a role name'
        ]);

        //Process Data
        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        $permissions = $request->permissions;

        if(!empty($permissions)){
            $role->syncPermissions($permissions);
        }

        return back()->with('success','Successfully added a new role');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Check authentication
        if (!Auth::user()->can('role.show')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Check authentication
        if (!Auth::user()->can('role.update')){
            abort(403,'Unauthorized Action');
        }
        $data['role'] = Role::find($id);


        $data['permissions'] = Permission::all();
        $data['permission_groups'] = User::getPermissionGroups();

        return view('backend.role.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('role.update')){
            abort(403,'Unauthorized Action');
        }
        // Validation Data
        $request->validate([
            'name' => ['required', 'min:4','max:30','unique:roles,id',$request->id],
        ],[
            'name.required' => 'Please give a role name'
        ]);

        // Process Data
        $role = Role::find($id);

        $permissions = $request->permissions;

        if(!empty($permissions)){
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($permissions);
        }

        return back()->with('success','Successfully update role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Check authentication
        if (!Auth::user()->can('role.delete')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('dashboard');
    }

}
