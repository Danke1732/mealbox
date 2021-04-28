<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;

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
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);

        /**
         * 本番環境httpsにする
         */
        if (\App::environment('heroku')) {
            \URL::forceScheme('https');
            // 本番環境ページネーション2ページ目httpsにする
            $this->app['request']->server->set('HTTPS', 'on');
        }
    }
}
