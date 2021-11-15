<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Code;

class ForumCommonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'layouts.forum_common', function($view) {
                $code = new CODE();
                $codes = $code->getCodes('CATEGORY');
                $view->with('codes', $codes);
            }
        );
    }
}
