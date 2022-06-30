<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('user.all')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Users";
        $data['users'] = User::where('status','active')->simplePaginate(10);
//          $data['users'] = User::where('status','active')->get();
       // dd($data);
        return view('backend.user.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('user.create')){
            abort(403,'Unauthorized Action');
        }

        $data['roles'] = Role::all();
        return view('backend.user.create',$data);
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
        if (!Auth::user()->can('user.create')){
            abort(403,'Unauthorized Action');
        }
        //Validation Data
        $request->validate([
            'name' => ['required','string', 'min:3','max:50'],
            'email' => ['required','string', 'min:10','max:50','unique:users'],
            'phone' => ['required', 'min:11','max:11','unique:users'],
            'password' => ['required', 'min:6','max:20','confirmed'],
            'photo' => ['nullable','mimes:jpeg,jpg,png,gif,svg','max:256',/*'dimensions:min_width=500,min_height=600'*/],
        ],[
            'name.required' => 'Please give a user full name'
        ]);
        $data['uid'] = uniqid();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['username'] = $request->phone;
        $data['password'] = Hash::make($request->password);
        $data['text_password'] = $request->password;
        $data['status'] = 'active';

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'assets/images/img/user';
            $file_name = 'photo'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['profile_photo_path'] = $path.'/'.$file_name;
        }

        //Process Data
        $user = User::create($data);

        if ($request->roles){
            $user->assignRole($request->roles);
        }

        return back()->with('success','Successfully Create a new user');
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
        if (!Auth::user()->can('user.show')){
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
        if (!Auth::user()->can('user.update')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Edit User";
        $data['user'] = User::findOrFail($id);
        $data['roles'] = Role::all();

        return view('backend.user.edit',$data);
    }

    public function profileEdit()
    {
        //Check authentication
        if (!Auth::user()->can('profile.update')){
            abort(403,'Unauthorized Action');
        }

        $data['pageTitle'] = "Update Profile";
        $data['roles'] = Role::all();

        $userId = Auth::user()->id;
        $data['profile'] = User::where('id',$userId)
                ->where('status','active')
                ->first();
        if (!$data['profile']){
            return redirect()->route('dashboard');
        }
        return view('backend.user.profile_update',$data);
    }

    public function profileUpdate(Request $request)
    {
        //Check authentication
        if (!Auth::user()->can('profile.update')) {
            abort(403, 'Unauthorized Action');
        }
        //Validation User Data
        $userId = Auth::user()->id;
        $oldData = User::where('id',$userId)
            ->where('status','active')
            ->first();
        if (!$oldData){
            return redirect()->route('dashboard');
        }

        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'password' => ['nullable', 'min:6', 'max:20', 'confirmed'],
            'photo' => ['nullable', 'mimes:jpeg,jpg,png,gif,svg', 'max:256',/*'dimensions:min_width=500,min_height=600'*/],
        ], [
            'name.required' => 'Please give your full name'
        ]);


        $data['name'] = $request->name;

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
            $data['text_password'] = $request->password;
        }

        // profile photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = 'assets/images/img/user';
            $file_name = 'photo_' . rand(000000000, 999999999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $file_name);
            $data['profile_photo_path'] = $path . '/' . $file_name;

            if (file_exists($oldData->profile_photo_path)) {
                unlink($oldData->profile_photo_path);
            }
        }

        //User Update
        DB::table('users')
            ->where('id', $userId)
            ->update($data);

        return back()->with('success', 'Profile updated Successfully');
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
        if (!Auth::user()->can('user.update')){
            abort(403,'Unauthorized Action');
        }
        //Validation Data
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required','string', 'regex:/^[a-zA-Z\s]+$/', 'min:3','max:40'],
            'email' => ['required','string', 'min:4','max:30','unique:users,id',$request->id],
            'phone' => ['required', 'min:11','max:11','unique:users,id',$request->id],
            'password' => ['nullable', 'min:6','max:20','confirmed'],
            'photo' => ['nullable','mimes:jpeg,jpg,png,gif,svg','max:256',/*'dimensions:min_width=500,min_height=600'*/],
        ],[
            'name.required' => 'Please give a user full name'
        ]);


        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->username = $request->phone;
        if ($request->password){
            $user->password = Hash::make($request->password);
            $user->text_password = $request->password;
        }

        $chkUser = User::findOrFail($id);
        // profile photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'assets/images/img/user';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $user->profile_photo_path = $path.'/'.$file_name;

            if(file_exists($chkUser->profile_photo_path)){
                unlink($chkUser->profile_photo_path);
            }
        }

        $user->save();

        $user->roles()->detach();
        if ($request->roles){
            $user->assignRole($request->roles);
        }

        return back()->with('success','User updated Successfully');
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
        if (!Auth::user()->can('user.delete')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('dashboard');
    }
}
