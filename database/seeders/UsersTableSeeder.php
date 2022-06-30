<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create a Default User

        $user = User::where('email','apol@apol.com.bd')->first();

        if (is_null($user)){
            DB::table('users')->insert([
               [ 'name' => 'Apol Shop', 'uid' => uniqid(), 'phone' => '01644394107', 'email' => 'apol@gmail.com','username' => 'apol@gmail.com', 'password' => bcrypt('apol@gmail.com'), 'status' => 'active', 'text_password' =>'apol@gmail.com'],
               [ 'name' => 'Zayed',  'uid' => uniqid(), 'phone' => '01745685895',  'email' => 'zariq@gmail.com','username' => 'zariq@gmail.com', 'password' => bcrypt('zariq@gmail.com'), 'status' => 'active', 'text_password' =>'zariq@gmail.com'],
            ]);
        }
    }
}
