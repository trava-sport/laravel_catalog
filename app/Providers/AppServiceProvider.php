<?php

namespace App\Providers;

use App\Models\Fabric;
use Illuminate\Support\ServiceProvider;
use App\Models\Size;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

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
        // $size_id = DB::table('items')->select('size_id')->groupBy('size_id')->get();
        // //$size_id =[];
        // $sizes = [];
        // foreach ($size_id as $id) {
        //     $sizes[] = $id->size_id;
        // }

        // $filter_size = Size::whereIn('id', $sizes)->get();

        // $fabric_id = DB::table('items')->select('fabric_id')->groupBy('fabric_id')->get();
        // $fabrics = [];
        // foreach ($fabric_id as $id) {
        //     $fabrics[] = $id->fabric_id;
        // }

        // $filter_fabric = Fabric::whereIn('id', $fabrics)->get();

        // View::share([
        //     'filter_size' => $filter_size,
        //     'filter_fabric' => $filter_fabric
        // ]);
    }
}
