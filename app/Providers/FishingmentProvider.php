<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\EventRepository;
use App\Repositories\EventRepositoryInterface;
use App\Repositories\FishingResultsRepository;
use App\Repositories\FishingResultsRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\ImagesRepository;
use App\Repositories\ImagesRepositoryInterface;
use App\Repositories\FishSpeciesRepository;
use App\Repositories\FishSpeciesRepositoryInterface;
use App\Repositories\EvaluationCriteriaRepository;
use App\Repositories\EvaluationCriteriaRepositoryInterface;
use App\Repositories\EntryListRepository;
use App\Repositories\EntryListRepositoryInterface;
use App\Repositories\ChatsRepository;
use App\Repositories\ChatsRepositoryInterface;

class FishingmentProvider extends ServiceProvider
{
    /**
     * 登録する必要のある全コンテナ結合
     *
     * @var array
     */
    public $bindings = [
        EventRepositoryInterface::class => EventRepository::class,
        FishingResultsRepositoryInterface::class => FishingResultsRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
        ImagesRepositoryInterface::class => ImagesRepository::class,
        FishSpeciesRepositoryInterface::class => FishSpeciesRepository::class,
        EvaluationCriteriaRepositoryInterface::class => EvaluationCriteriaRepository::class,
        EntryListRepositoryInterface::class => EntryListRepository::class,
        ChatsRepositoryInterface::class => ChatsRepository::class,
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
