<?php

namespace App\Providers;

use App\Models\Link;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;
use App\Observers\LinkObserver;
use App\Observers\ReplyObserver;
use App\Observers\TopicObserver;
use App\Observers\UserObserver;
use Carbon\Carbon;
use Dingo\Api\Facade\API;
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
        if (app()->environment() == 'local' || app()->environment() == 'testing') {
            $this->app->register(\Summerblue\Generator\GeneratorsServiceProvider::class);
        }

        if (app()->environment() == 'local') {
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }

        API::error(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(404, '404 Not Found');
        });

        API::error(function (\Illuminate\Auth\Access\AuthorizationException $exception) {
            abort(403, $exception->getMessage());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Carbon 中文化配置
        Carbon::setLocale('zh');
        Link::observe(LinkObserver::class);
        Reply::observe(ReplyObserver::class);
        Topic::observe(TopicObserver::class);
        User::observe(UserObserver::class);
    }
}
