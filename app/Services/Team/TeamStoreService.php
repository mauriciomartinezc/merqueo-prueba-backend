<?php

namespace App\Services\Team;

use app\Http\Requests\Team\TeamRequest;
use App\Models\Team;

class TeamStoreService
{
    /**
     * @param array $data
     * @param TeamRequest|null $request
     * @return Team
     */
    public function execute(array $data, ?TeamRequest $request = null): Team
    {
        $team = new Team($data);

        if ($request && $request->hasFile('flag_image')) {
            $team->flag_image = $request->file('flag_image')->store('flags', 'public');
        }

        $team->save();

        return $team;
    }
}
