<?php

namespace App\Services\Player;

use App\Models\Player;
use Illuminate\Pagination\LengthAwarePaginator;

class PlayerIndexService
{
    /**
     * @return LengthAwarePaginator
     */
    public function execute(): LengthAwarePaginator
    {
        return Player::paginate(10);
    }
}
