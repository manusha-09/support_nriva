<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use view;
use DB;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Paginator::useBootstrap();
        

        view()->composer('*', function($view) {

    $view->with(['counttickets' => DB::table('tbl_ticketing_system_notifications')->whereNull('read_at')->get()]);
     $view->with(['logodetails' => DB::table('tbl_ticketing_system_logoData')->first()]);
});


    }

   


}
