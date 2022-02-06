<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\interfaces\adminRepositoryInterface;
use App\interfaces\authInterface;
use App\interfaces\bookmarkInterface;
use App\interfaces\categoryInterface;
use App\interfaces\mangaInformationInterface;
use App\interfaces\commentInterface;
use App\interfaces\episodeInterface;
use App\interfaces\likeInterface;
use App\interfaces\multiImageInterface;
use App\interfaces\ratingInterface;
use App\interfaces\volumeInterface;

use App\repositories\adminRepository;
use App\repositories\authRepository;
use App\repositories\bookmarkRepository;
use App\repositories\categoryRepository;
use App\repositories\mangaInformationRepository;
use App\repositories\commentRepository;
use App\repositories\episodeRepository;
use App\repositories\likeRepository;
use App\repositories\multiImageRepository;
use App\repositories\ratingRepository;
use App\repositories\volumeRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
     
       $this->app->bind(adminRepositoryInterface::class,adminRepository::class);
       $this->app->bind(categoryInterface::class,categoryRepository::class);
       $this->app->bind(mangaInformationInterface::class,mangaInformationRepository::class);
       $this->app->bind(commentInterface::class,commentRepository::class);
       $this->app->bind(likeInterface::class,likeRepository::class);
       $this->app->bind(volumeInterface::class,volumeRepository::class);
       $this->app->bind(episodeInterface::class,episodeRepository::class);
       $this->app->bind(multiImageInterface::class,multiImageRepository::class);
       $this->app->bind(ratingInterface::class,ratingRepository::class);
       $this->app->bind(authInterface::class,authRepository::class);
       $this->app->bind(bookmarkInterface::class,bookmarkRepository::class);
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
