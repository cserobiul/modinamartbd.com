<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->can('settings.update')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Settings";

        $data['settings'] = Settings::where('id',1)->first();
        return view('backend.settings.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('settings.create')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('dashboard');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Check authentication
        if (!Auth::user()->can('settings.create')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
        //Check authentication
        if (!Auth::user()->can('settings.show')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $settings)
    {
        //Check authentication
        if (!Auth::user()->can('settings.update')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('dashboard');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Settings $settings)
    {
        //Check authentication
        if (!Auth::user()->can('settings.update')){
            abort(403,'Unauthorized Action');
        }

        $request->validate([
            'app_name' => ['required','string', 'min:3','max:50'],
            'phone' => ['nullable', 'numeric', 'min:10'],
            'address' => ['nullable','string', 'min:12','max:255'],
            'footer' => ['nullable','string', 'min:10','max:255'],

            'logo' => ['nullable','mimes:png','max:256'],
            'favicon' => ['nullable','mimes:png','max:128'],
        ]);
//      dd($request->all());
        $data['id'] = 1;
        $data['app_name'] = $request->app_name;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['address'] = $request->address;
        $data['social_facebook'] = $request->social_facebook;
        $data['social_instagram'] = $request->social_instagram;
        $data['social_youtube'] = $request->social_youtube;
        $data['footer'] = $request->footer;

//      dd($data);
        $oldData = Settings::where('id',1)->first();

        // logo
        if($request->hasFile('logo')){

            //First Delete old logo
            if(file_exists(public_path($oldData->logo))){
                unlink(public_path($oldData->logo));
            }

            $file = $request->file('logo');
            $path = 'assets/images';
            $file_name = 'logo'.'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);     //Upload new logo
            $data['logo'] = $path.'/'.$file_name;

        }

// favicon
        if($request->hasFile('favicon')){

            //Delete old Favicon
            if(file_exists(public_path($oldData->favicon))){
                unlink(public_path($oldData->favicon));
            }

            $file = $request->file('favicon');
            $path = 'assets/images';
            $file_name = 'favicon'.'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);     //Upload new favicon
            $data['favicon'] = $path.'/'.$file_name;
        }

        DB::table('settings')
            ->where('id',$data['id'])
            ->update($data);
        session()->flash('success','Settings Updated Successfully');
        return redirect()->route('settings.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $settings)
    {
        //Check authentication
        if (!Auth::user()->can('settings.delete')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('dashboard');
    }

    public function permissionGenerator($permissionName){
        $permission = Permission::create(['name' => $permissionName.'.all','guard_name' => 'web', 'group_name' =>  $permissionName ]);
        $permission = Permission::create(['name' => $permissionName.'.create','guard_name' => 'web', 'group_name' =>  $permissionName ]);
        $permission = Permission::create(['name' => $permissionName.'.show','guard_name' => 'web', 'group_name' =>  $permissionName ]);
        $permission = Permission::create(['name' => $permissionName.'.update','guard_name' => 'web', 'group_name' =>  $permissionName ]);
        $permission = Permission::create(['name' => $permissionName.'.delete','guard_name' => 'web', 'group_name' =>  $permissionName ]);
        $permission = Permission::create(['name' => $permissionName.'.approved','guard_name' => 'web', 'group_name' =>  $permissionName ]);
    }
}
