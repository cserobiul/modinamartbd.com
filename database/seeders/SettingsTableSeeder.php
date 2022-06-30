<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hasOldData = Settings::where('id', 1)->first();

        if (is_null($hasOldData)) {
            DB::table('settings')->insert([
                'app_name' => 'E Com Application',
                'email' => 'info@apol.com.bd',
                'logo' => 'assets/images/logo.png',
                'favicon' => 'assets/images/favicon.png',
                'phone' => '01644394107',
                'address' => 'mirpur, dhaka-1216',
                'social_facebook' => 'www.facebook.com',
                'social_instagram' => 'www.instagram.com',
                'social_youtube' => 'www.youtube.com',
                'footer' => 'Technical Supported by Apol Ltd',
            ]);
        }
    }
}
