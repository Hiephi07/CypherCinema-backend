<?php

namespace App\Providers;

use App\Repositories\Banner\BannerRepository;
use App\Repositories\Banner\BannerRepositoryInterface;
use App\Repositories\City\CityRepository;
use App\Repositories\City\CityRepositoryInterface;
use App\Repositories\Event\EventRepository;
use App\Repositories\Event\EventRepositoryInterface;
use App\Repositories\Movie\MovieRepository;
use App\Repositories\Movie\MovieRepositoryInterface;
use App\Repositories\Paymentmethod\PaymentMethodRepository;
use App\Repositories\Paymentmethod\PaymentMethodRepositoryInterface;
use App\Repositories\Seat\SeatRepository;
use App\Repositories\Seat\SeatRepositoryInterface;
use App\Repositories\Showtime\ShowtimeRepository;
use App\Repositories\Showtime\ShowtimeRepositoryInterface;
use App\Repositories\Theater\TheaterRepository;
use App\Repositories\Theater\TheaterRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Voucher\VoucherRepository;
use App\Repositories\Voucher\VoucherRepositoryInterface;

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
        $this->app->bind(PaymentMethodRepositoryInterface::class, PaymentMethodRepository::class);
        $this->app->bind(VoucherRepositoryInterface::class, VoucherRepository::class);
        $this->app->bind(ShowtimeRepositoryInterface::class, ShowtimeRepository::class);
        $this->app->bind(SeatRepositoryInterface::class, SeatRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
