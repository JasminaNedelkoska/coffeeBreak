<?php
/**
 * Created by PhpStorm.
 * User: Jasmina
 * Date: 15.01.2020
 * Time: 13:37
 */


namespace App\Repositories;

use App\Models\CoffeeBreakPreference;
use App\Models\StaffMember;
use App\Repositories\BaseRepository;

class StaffMemberRepository extends BaseRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return StaffMember::class;
    }

}