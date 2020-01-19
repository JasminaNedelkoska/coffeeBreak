<?php
/**
 * Created by PhpStorm.
 * User: Jasmina
 * Date: 15.01.2020
 * Time: 13:37
 */


namespace App\Repositories;

use App\Models\CoffeeBreakPreference;
use App\Repositories\BaseRepository;

class CoffeeBreakPreferenceRepository extends BaseRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return CoffeeBreakPreference::class;
    }

}