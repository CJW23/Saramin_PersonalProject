<?php

namespace App\Providers;

use App\Logic\UrlManager;
use App\Repository\AdminRepository;
use App\Repository\UrlRepository;
use App\Repository\UserRepository;
use App\Response\AdminApiControllerResponse;
use App\Response\UrlApiControllerResponse;
use App\Response\UserControllerResponse;
use App\Service\AdminService;
use App\Service\MainService;
use App\Service\UserMainService;
use App\Service\UserSettingService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind("UrlManager", function () {
            return new UrlManager();
        });
        $this->app->bind("AdminService", function () {
            return new AdminService();
        });
        $this->app->bind("MainService", function () {
           return new MainService();
        });
        $this->app->bind("UserMainService", function () {
            return new UserMainService();
        });
        $this->app->bind("UserSettingService", function(){
            return new UserSettingService();
        });
        $this->app->bind("AdminRepository", function(){
            return new AdminRepository();
        });
        $this->app->bind("UrlRepository", function(){
            return new UrlRepository();
        });
        $this->app->bind("UserRepository", function(){
            return new UserRepository();
        });
        $this->app->bind("AdminApiControllerResponse", function(){
            return new AdminApiControllerResponse();
        });
        $this->app->bind("UrlApiControllerResponse", function(){
            return new UrlApiControllerResponse();
        });
        $this->app->bind("UserControllerResponse", function(){
            return new UserControllerResponse();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
