<?php

namespace App\Http\Composers;

use App\Models\Category;
use App\Models\Settings;
use Illuminate\View\View;

class CategoryComposer
{
    public function compose(View $view)
    {
       $view->with('categories',Category::tree());
    }

}
