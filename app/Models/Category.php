<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Category extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'name',
        'slug',
        'photo',
        'order_sl',
        'show_home',
        'parent_id',
        'user_id',
        'update_by',
        'status'
    ];

    public function parentCategory(){
        return $this->hasMany(Category::class,'parent_id')->with('parentCategory');
    }

    public function user(){
        return $this->belongsTo(User::class)->withDefault();
    }
    public function product() {
        return $this->hasMany(Product::class);
    }

    public function updateBy(){
        return $this->belongsTo(User::class,'update_by');
    }



    public static function tree(){
        $allCategories = Category::orderBy('id','ASC')->get();

        $rootCategories = $allCategories->whereNull('parent_id');


        self::formatTree($rootCategories, $allCategories);

//        foreach ($rootCategories as $rootCategory){
//            $rootCategory->children = $allCategories->where('parent_id',$rootCategory->id)->values();
//
//            foreach ($rootCategory->children  as $child){
//                $child->children = $allCategories->where('parent_id',$child->id)->values();
//            }
//        }

        return $rootCategories;
    }


    private static function formatTree($categories, $allCategories){

        foreach ($categories as $category){
            $category->children = $allCategories->where('parent_id',$category->id)->values();

            if ($category->children->isNotEmpty()){
                self::formatTree($category->children, $allCategories);
            }
        }

    }

}

