<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Expense;
use App\Models\User;
use App\Policies\ExpensePolicy;
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
        Expense::class => ExpensePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-expense', function (User $user, Expense $expense) {
            return $user->id === $expense->user_id;
        });
        
        Gate::define('delete-expense', function (User $user, Expense $expense) {
            return $user->id === $expense->user_id;
        });

    }
}
