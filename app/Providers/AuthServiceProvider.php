<?php

namespace App\Providers;

use App\Models\Topic;
use App\Models\User;
use App\Policies\TopicPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     * @var array
     */
    protected $policies = [
		 \App\Models\Reply::class => \App\Policies\ReplyPolicy::class,
        'App\Model' => 'App\Policies\ModelPolicy',
        Topic::class => TopicPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
