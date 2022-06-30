<?php

namespace App\Http\Composers;

use App\Models\Settings;
use Illuminate\View\View;

class SettingsComposer
{
    public function compose(View $view)
    {
       $view->with('settings',Settings::where('id',1)->first());
    }

}
