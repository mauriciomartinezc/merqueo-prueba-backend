<?php

namespace App\Services\Team;

use App\Models\Team;

class TeamDestroyService
{
    /**
     * @param Team $team
     * @return Team
     */
    public function execute(Team $team): Team
    {
        $team->delete();
        return $team;
    }
}
