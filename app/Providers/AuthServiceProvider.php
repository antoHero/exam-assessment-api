<?php

namespace App\Providers;

use App\Models\{Assessment};
use App\Policies\{AssessmentPolicy};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Assessment::class => AssessmentPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('create-assessment', [AssessmentPolicy::class, 'create']);
        Gate::define('update-assessment', [AssessmentPolicy::class, 'update']);
        Gate::define('delete-assessment', [AssessmentPolicy::class, 'delete']);
    }
}
