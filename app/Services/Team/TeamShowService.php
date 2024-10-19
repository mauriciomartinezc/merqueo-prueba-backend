<?php

namespace App\Services\Team;

use app\Http\Requests\Team\TeamRequest;
use App\Models\Team;

class TeamShowService
{
    /**
     * @param Team $team
     * @return Team
     */
    public function execute(Team $team): Team
    {
        return $team;
    }
}
