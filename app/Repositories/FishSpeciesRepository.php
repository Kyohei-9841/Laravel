<?php

namespace App\Repositories;

use App\Models\FishSpecies;

class fishSpeciesRepository implements FishSpeciesRepositoryInterface
{
    protected $fishSpeciesModel;

    /**
    * @param object $user
    */
    public function __construct(FishSpecies $fishSpeciesModel)
    {
        $this->fishSpeciesModel = $fishSpeciesModel;
    }

    /**
     * 対象魚を取得
     */
    public function getFishSpeciesAll()
    {
        return $this->fishSpeciesModel->get();
    }
}