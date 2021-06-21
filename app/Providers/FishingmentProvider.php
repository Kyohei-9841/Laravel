<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\eventRepository;
use App\Repositories\EventRepositoryInterface;
use App\Repositories\fishingResultsRepository;
use App\Repositories\FishingResultsRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\imagesRepository;
use App\Repositories\ImagesRepositoryInterface;
use App\Repositories\fishSpeciesRepository;
use App\Repositories\FishSpeciesRepositoryInterface;
use App\Repositories\EvaluationCriteriaRepository;
use App\Repositories\EvaluationCriteriaRepositoryInterface;
use App\Repositories\EntryListRepository;
use App\Repositories\EntryListRepositoryInterface;

class FishingmentProvider extends ServiceProvider
{
    /**
     * 登録する必要のある全コンテナ結合
     *
     * @var array
     */
    public $bindings = [
        EventRepositoryInterface::class => eventRepository::class,
        FishingResultsRepositoryInterface::class => fishingResultsRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
        ImagesRepositoryInterface::class => imagesRepository::class,
        FishSpeciesRepositoryInterface::class => fishSpeciesRepository::class,
        EvaluationCriteriaRepositoryInterface::class => EvaluationCriteriaRepository::class,
        EntryListRepositoryInterface::class => EntryListRepository::class,
    ];

    /**
     * 登録する必要のある全コンテナシングルトン
     *
     * @var array
     */
    public $singletons = [
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
