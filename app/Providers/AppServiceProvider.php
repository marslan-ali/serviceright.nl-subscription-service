<?php

namespace App\Providers;

use App\Core\Infrastructure\Repositories\Contract\ItemRepository;
use App\Core\Infrastructure\Repositories\Contract\PlanRepository;
use App\Core\Infrastructure\Repositories\Contract\SubscriptionRepository;

use App\Core\Infrastructure\Repositories\ItemRepositoryEloquent;
use App\Core\Infrastructure\Repositories\PlanRepositoryEloquent;
use App\Core\Infrastructure\Repositories\SubscriptionRepositoryEloquent;

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
        $this->app->bind(PlanRepository::class, PlanRepositoryEloquent::class);
        $this->app->bind(ItemRepository::class, ItemRepositoryEloquent::class);
        $this->app->bind(SubscriptionRepository::class, SubscriptionRepositoryEloquent::class);
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
