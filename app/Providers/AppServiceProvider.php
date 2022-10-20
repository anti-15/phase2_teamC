<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Member;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $group_id=Member::all();
        view()->share('group_id', $group_id);
    }
}
