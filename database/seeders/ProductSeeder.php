<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Default Unit
        DB::table('units')->insert([
            ['unit_name' => 'PCS', 'user_id' => 1, ],
            ['unit_name' => 'BOX',  'user_id' => 1, ],
        ]);

        //Default Warranty
        DB::table('warranties')->insert([
            ['warranty_name' => '1 Year', 'user_id' => 1, ],
            ['warranty_name' => '2 Year',  'user_id' => 1, ],
            ['warranty_name' => '3 Year',  'user_id' => 1, ],
            ['warranty_name' => '1 Month',  'user_id' => 1, ],
            ['warranty_name' => '6 Month',  'user_id' => 1, ],
        ]);
        //Default Sizes
        DB::table('sizes')->insert([
            ['size_name' => 'XL', 'user_id' => 1, ],
            ['size_name' => 'XXL',  'user_id' => 1, ],
            ['size_name' => 'Big',  'user_id' => 1, ],
            ['size_name' => 'Medium',  'user_id' => 1, ],
            ['size_name' => '6 Month',  'user_id' => 1, ],
        ]);

        //Default Color
        DB::table('colors')->insert([
            ['color_name' => 'Green','color_code' => '#2cb74a', 'user_id' => 1, ],
            ['color_name' => 'Red','color_code' => '#f7350c',  'user_id' => 1, ],
        ]);
         //Default Payment
        DB::table('payment_methods')->insert([
            ['payment_name' => 'bKash-107','details' => '01644394107', 'user_id' => 1, ],
            ['payment_name' => 'Nagad-107','details' => '01644394107',  'user_id' => 1, ],
            ['payment_name' => 'One Bank','details' => 'Mirpur, Dhaka',  'user_id' => 1, ],
            ['payment_name' => 'City Bank','details' => 'Mohammadpur Dhaka',  'user_id' => 1, ],
        ]);


        //Default Brand
        DB::table('brands')->insert([
            ['brand_name' => 'Apol BD', 'slug' => 'apol_bd',   'user_id' => 1, ],
            ['brand_name' => 'Asus Ltd', 'slug' => 'asusltd',   'user_id' => 1, ],
            ['brand_name' => 'Samsung BD', 'slug' => 'samsungbf',   'user_id' => 1, ],
            ['brand_name' => 'Apple USA', 'slug' => 'appleud',   'user_id' => 1, ],
            ['brand_name' => 'Lenovo BD', 'slug' => 'lenovobd',   'user_id' => 1, ],
        ]);


        //Default Category
        DB::table('categories')->insert([
            ['name' => 'Food', 'slug' => 'food', 'parent_id' => null, 'order_sl' => 1, 'show_home' => 1,  'user_id' => 1, ],
            ['name' => 'Fashion', 'slug' => 'fashion', 'parent_id' => null, 'order_sl' => 2, 'show_home' => 1, 'user_id' => 1, ],
            ['name' => 'Library', 'slug' => 'library', 'parent_id' => null, 'order_sl' => 3, 'show_home' => 1, 'user_id' => 1, ],
            ['name' => 'Mens Fashion', 'slug' => 'mens-fashion', 'parent_id' => 2, 'order_sl' => 1, 'show_home' => 0, 'user_id' => 1, ],
            ['name' => 'Womens Fashion', 'slug' => 'womens-fashion', 'parent_id' => 2, 'order_sl' => 2, 'show_home' => 0, 'user_id' => 1, ],
        ]);

        //Default Products
        DB::table('products')->insert([
            ['name' => 'hp 2 Pavilion 15-eh1678AU', 'slug' => 'hp-21-pavilion-15-eh1678kau', 'category_id' => 1, 'brand_id' => 1, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 5000, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_756820026.png',  'view_section' => 'NEW_ARRIVAL',   'user_id' => 1, ],
            ['name' => 'Carronade Table Lamp', 'slug' => 'carronade-table-lamp33', 'category_id' => 1, 'brand_id' => 2, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 400, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_228902759.jpg',  'view_section' => 'NEW_ARRIVAL',   'user_id' => 1, ],
            ['name' => 'hp 2 Pavilion 15-eh1678AU1', 'slug' => 'hp-21-pavilion-15-eh167ds8au', 'category_id' => 1, 'brand_id' => 3, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 500, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_228902759.jpg',  'view_section' => 'NEW_ARRIVAL',   'user_id' => 1, ],
            ['name' => 'lenovo Pavilion 15-eh1678AU20', 'slug' => 'lenovo-pavilion-15-eh1678fau2', 'category_id' => 3, 'brand_id' => 1, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 350, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_756820026.png',  'view_section' => 'NEW_ARRIVAL',   'user_id' => 1, ],
            ['name' => 'lenovo Pavilion 15-eh1678AU23', 'slug' => 'lenovo-pavilion-15-eh1678bau2', 'category_id' => 3, 'brand_id' => 1, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 350, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_756820026.png',  'view_section' => 'JUST_FOR_YOU',   'user_id' => 1, ],
            ['name' => 'lenovo Pavilion 15-eh1678AU24', 'slug' => 'lenovo-pavilion-15-eh1678jau2', 'category_id' => 1, 'brand_id' => 1, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 700, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_756820026.png',  'view_section' => 'NEW_ARRIVAL',   'user_id' => 1, ],
            ['name' => 'lenovo Pavilion 15-eh1678AU27', 'slug' => 'lenovo-pavilion-15-eh167k8au2', 'category_id' => 4, 'brand_id' => 5, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 850, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_756820026.png',  'view_section' => 'BEST_SELLER',   'user_id' => 1, ],
            ['name' => 'hp 2 Pavilion 15-eh1678AU8', 'slug' => 'hp-21-pavilion-15-eh16c78au', 'category_id' => 1, 'brand_id' => 1, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 500, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_265949917.jpg',  'view_section' => 'BEST_SELLER',   'user_id' => 1, ],
            ['name' => 'dell 2 Pavilion 15-eh1678AU9', 'slug' => 'dell-21-pavilion-15-eh1f678au', 'category_id' => 5, 'brand_id' => 2, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 1200, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_265949917.jpg',  'view_section' => 'BEST_SELLER',   'user_id' => 1, ],
            ['name' => 'dell 2 Pavilion 15-eh1678AU1', 'slug' => 'dell-21-pavilion-15-eh167j8au', 'category_id' => 5, 'brand_id' => 2, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 1200, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_265949917.jpg',  'view_section' => 'JUST_FOR_YOU',   'user_id' => 1, ],
            ['name' => 'dell 2 Pavilion 15-eh1678AU2', 'slug' => 'dell-21-pavilion-15-eh1678fau', 'category_id' => 5, 'brand_id' => 2, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 1200, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_265949917.jpg',  'view_section' => 'NEW_ARRIVAL',   'user_id' => 1, ],
            ['name' => 'dell 2 Pavilion 15-eh1678AU3', 'slug' => 'dell-21-pavilion-15-eh16x78au', 'category_id' => 1, 'brand_id' => 4, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 500, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_265949917.jpg',  'view_section' => 'BEST_SELLER',   'user_id' => 1, ],
            ['name' => 'dell 2 Pavilion 15-eh1678AU4', 'slug' => 'dell-21-pavilion-15-eh16w78au', 'category_id' => 1, 'brand_id' => 4, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 500, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_265949917.jpg',  'view_section' => 'BEST_SELLER',   'user_id' => 1, ],
            ['name' => 'dell 2 Pavilion 15-eh1678AU5', 'slug' => 'dell-21-pavilion-15-ehq1678au', 'category_id' => 1, 'brand_id' => 3, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 500, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_265949917.jpg',  'view_section' => 'FLASH_SELL',   'user_id' => 1, ],
            ['name' => 'dell 2 Pavilion 15-eh1678AU6', 'slug' => 'dell-21-pavilion-15-eh1e678au', 'category_id' => 1, 'brand_id' => 3, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 500, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_265949917.jpg',  'view_section' => 'FLASH_SELL',   'user_id' => 1, ],
            ['name' => 'hp 2 Pavilion 15-eh1678AU11', 'slug' => 'hp-21-pavilion-15-eh1r678au', 'category_id' => 2, 'brand_id' => 2, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 500, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_756820026.png',  'view_section' => 'FLASH_SELL',   'user_id' => 1, ],
            ['name' => 'hp 2 Pavilion 15-eh1678AU22', 'slug' => 'hp-21-pavilion-15-eh16t78au', 'category_id' => 2, 'brand_id' => 3, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 560, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_756820026.png',  'view_section' => 'FLASH_SELL',   'user_id' => 1, ],
            ['name' => 'hp 2 Pavilion 15-eh1678AU33', 'slug' => 'hp-21-pavilion-15-eh167y8au', 'category_id' => 1, 'brand_id' => 5, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 600, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_265949917.jpg',  'view_section' => 'FLASH_SELL',   'user_id' => 1, ],
            ['name' => 'KitchenAid Professional 500 Series Stand Mixer', 'slug' => 'kitchenaid-professional-500-series-stawnd-mixer', 'category_id' => 1, 'brand_id' => 1, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 500, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_265949917.jpg',  'view_section' => 'FLASH_SELL',   'user_id' => 1, ],
            ['name' => 'KitchenAid Professional 500 Series Stand Mixer2', 'slug' => 'kitchenaid-professional-500-series-staand-mixer', 'category_id' => 4, 'brand_id' => 1, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 500, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_265949917.jpg',  'view_section' => 'MOST_POPULAR',   'user_id' => 1, ],
            ['name' => 'KitchenAid Professional 500 Series Stand Mixer3', 'slug' => 'kitchenaid-professional-500-series-stasnd-mixer', 'category_id' => 4, 'brand_id' => 1, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 500, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_265949917.jpg',  'view_section' => 'JUST_FOR_YOU',   'user_id' => 1, ],
            ['name' => 'KitchenAid Professional 500 Series Stand Mixer4', 'slug' => 'kitchenaid-professional-500-series-stafnd-mixer', 'category_id' => 5, 'brand_id' => 1, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 500, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_265949917.jpg',  'view_section' => 'MOST_POPULAR',   'user_id' => 1, ],
            ['name' => 'KitchenAid Professional 500 Series Stand Mixer5', 'slug' => 'kitchenaid-professional-500-series-stfand-mixer', 'category_id' => 5, 'brand_id' => 1, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 500, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_265949917.jpg',  'view_section' => 'JUST_FOR_YOU',   'user_id' => 1, ],
            ['name' => 'KitchenAid Professional 500 Series Stand Mixer6', 'slug' => 'kitchenaid-professional-500-series-stand-mixer', 'category_id' => 3, 'brand_id' => 1, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 500, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_756820026.png',  'view_section' => 'MOST_POPULAR',   'user_id' => 1, ],
            ['name' => 'hp 2 Pavilion 15-eh1678AU123', 'slug' => 'hp-21-pavilion-15-eh1f678au', 'category_id' => 1, 'brand_id' => 1, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 6000, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_228902759.jpg',  'view_section' => 'MOST_POPULAR',   'user_id' => 1, ],
            ['name' => 'Carronade Table Lamp23', 'slug' => 'carronade-table-lamp', 'category_id' => 1, 'brand_id' => 1, 'unit_id' => 1, 'warranty_id' => 1, 'sale_price' => 950, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_228902759.jpg',  'view_section' => 'MOST_POPULAR',   'user_id' => 1, ],
            ['name' => 'hp 2 Pavilion 15-eh1678AU98', 'slug' => 'hp-21-pavilion-15-eh16d78au', 'category_id' => 1, 'brand_id' => 1, 'unit_id' => 3, 'warranty_id' => 1, 'sale_price' => 500, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_756820026.png',  'view_section' => 'SPECIAL_OFFER',   'user_id' => 1, ],
            ['name' => 'hp 2 Pavilion 15-eh1678AU87', 'slug' => 'hp-21-pavilion-15-egh1678au', 'category_id' => 1, 'brand_id' => 1, 'unit_id' => 3, 'warranty_id' => 1, 'sale_price' => 500, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_756820026.png',  'view_section' => 'JUST_FOR_YOU',   'user_id' => 1, ],
            ['name' => 'hp 2 Pavilion 15-eh1678AU45', 'slug' => 'hp-21-pavilion-15-eh167h8au', 'category_id' => 1, 'brand_id' => 1, 'unit_id' => 3, 'warranty_id' => 1, 'sale_price' => 500, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_756820026.png',  'view_section' => 'JUST_FOR_YOU',   'user_id' => 1, ],
            ['name' => 'hp 2 Pavilion 15-eh1678AU255', 'slug' => 'hp-21-pavilion-15-ehk1678au', 'category_id' => 1, 'brand_id' => 1, 'unit_id' => 3, 'warranty_id' => 1, 'sale_price' => 500, 'discount_amount' => 50, 'photo'=> 'assets/images/product/photo_756820026.png',  'view_section' => 'SPECIAL_OFFER',   'user_id' => 1, ],
        ]);

        //Default sliders
        DB::table('sliders')->insert([
            ['title' => 'new slider 1', 'photo' => 'assets/images/slider/photo_342214856.jpg',  'order' => 1,  'user_id' => 1, ],
            ['title' => 'new slider 2', 'photo' => 'assets/images/slider/photo_430631051.jpg',  'order' => 2,  'user_id' => 1, ],
            ['title' => 'new slider 3', 'photo' => 'assets/images/slider/photo_342214856.jpg',  'order' => 3,  'user_id' => 1, ],
            ['title' => 'new slider 4', 'photo' => 'assets/images/slider/photo_430631051.jpg',  'order' => 4,  'user_id' => 1, ],
            ['title' => 'new slider 5', 'photo' => 'assets/images/slider/photo_342214856.jpg',  'order' => 5,  'user_id' => 1, ],
        ]);






    }
}
