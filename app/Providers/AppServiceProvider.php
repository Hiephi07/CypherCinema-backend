<?php

namespace App\Providers;

use App\Repositories\Banner\BannerRepository;
use App\Repositories\Banner\BannerRepositoryInterface;
use App\Repositories\Event\EventRepository;
use App\Repositories\Event\EventRepositoryInterface;
use App\Repositories\Movie\MovieRepository;
use App\Repositories\Movie\MovieRepositoryInterface;
use App\Repositories\Theater\TheaterRepository;
use App\Repositories\Theater\TheaterRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->bind(BannerRepositoryInterface::class, BannerRepository::class);
        $this->app->bind(TheaterRepositoryInterface::class, TheaterRepository::class);
        $this->app->bind(MovieRepositoryInterface::class, MovieRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
