<?php

namespace App\Providers;

use App\Models\{Assessment, Option, Question};
use App\Policies\{AssessmentPolicy, OptionPolicy, QuestionPolicy};
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
        Assessment::class => AssessmentPolicy::class,
        Question::class => QuestionPolicy::class,
        Option::class => OptionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('create-assessment', [AssessmentPolicy::class, 'create']);
        Gate::define('update-assessment', [AssessmentPolicy::class, 'update']);
        Gate::define('delete-assessment', [AssessmentPolicy::class, 'delete']);
        Gate::define('create-question', [QuestionPolicy::class, 'create']);
        Gate::define('update-question', [QuestionPolicy::class, 'update']);
        Gate::define('delete-question', [QuestionPolicy::class, 'delete']);
        Gate::define('create-option', [OptionPolicy::class, 'create']);
        Gate::define('update-option', [OptionPolicy::class, 'update']);
        Gate::define('delete-option', [OptionPolicy::class, 'delete']);
    }
}
