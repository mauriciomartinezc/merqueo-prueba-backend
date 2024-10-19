<?php

namespace App\Services\Player;

use App\Models\Player;

class PlayerDestroyService
{
    /**
     * @param Player $player
     * @return Player
     */
    public function execute(Player $player): Player
    {
        $player->delete();
        return $player;
    }
}
