<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\Code;
use App\Models\CodeKind;
use Illuminate\Support\ServiceProvider;

class CodeServiceProvider extends ServiceProvider
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
            'code.index', function($view) {
                $displayCount = config('const.constant.code_display_count');
                $codes = Code::orderBy('id', 'asc')
                            ->orderBy('sort', 'asc')
                            ->paginate($displayCount);
                $kinds = CodeKind::orderBy('kind', 'asc')
                                ->get();
                $view->with('codes', $codes)->with('kinds', $kinds);
            }
        );
    }
}
