<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Product;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //非 CLI 下进行 view 加载
        if (PHP_SAPI != 'cli') {
            //view()->share('products_count', Product::count());
        }
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }
}
