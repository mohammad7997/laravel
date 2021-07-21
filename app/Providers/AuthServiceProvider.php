<?php

namespace App\Providers;

use App\Models\Answer;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('UserAdminThread', function (User $user, Thread $thread) {
            return $user->id == $thread->user_id;
        });

        Gate::define('user_answer',function (User $user,Answer $answer){
           return $user->id==$answer->user_id;
        });
    }
}
