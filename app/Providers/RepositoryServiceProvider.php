<?php

namespace App\Providers;

use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\ManufacturerRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\SlideRepositoryInterface;
use App\Repositories\CategoriesRepository;
use App\Repositories\ManufacturersRepository;
use App\Repositories\ProductsRepository;
use App\Repositories\SlidesRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoriesRepository::class);
        $this->app->bind(ManufacturerRepositoryInterface::class, ManufacturersRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductsRepository::class);
        $this->app->bind(SlideRepositoryInterface::class, SlidesRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
