<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Default supplier
        DB::table('suppliers')->insert([
            ['name' => 'Zariq Ltd', 'phone' => '01756985874',  'email' => 'sale@zariq.com.bd', 'address' => 'gazipur, dhaka',  'user_id' => 1, ],
            ['name' => 'SSK Ltd', 'phone' => '01856985874',  'email' => 'sale@sskltd.com.bd', 'address' => 'mipur, dhaka',  'user_id' => 1, ],
            ['name' => 'DMC Ltd', 'phone' => '0196985874',  'email' => 'sale@dmc.com.bd', 'address' => 'faridpur, dhaka',  'user_id' => 1, ],
            ['name' => 'Janata Fashion Ltd', 'phone' => '01556985874',  'email' => 'sale@janata.com', 'address' => 'khulna',  'user_id' => 1, ],
        ]);
    }
}
