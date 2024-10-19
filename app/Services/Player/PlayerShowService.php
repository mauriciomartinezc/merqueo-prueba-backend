<?php

namespace App\Services\Player;

use App\Models\Player;

class PlayerShowService
{
    /**
     * @param Player $player
     * @return Player
     */
    public function execute(Player $player): Player
    {
        return $player;
    }
}
