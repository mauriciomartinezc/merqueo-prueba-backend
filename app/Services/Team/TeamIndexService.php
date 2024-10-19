<?php

namespace App\Services\Team;

use App\Models\Team;
use Illuminate\Pagination\LengthAwarePaginator;

class TeamIndexService
{
    /**
     * @return LengthAwarePaginator
     */
    public function execute(): LengthAwarePaginator
    {
        return Team::paginate(10);
    }
}
