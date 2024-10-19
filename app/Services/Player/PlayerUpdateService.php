<?php

namespace App\Services\Player;

use app\Http\Requests\Player\PlayerRequest;
use App\Models\Player;

class PlayerUpdateService
{
    /**
     * @param Player $player
     * @param array $data
     * @param PlayerRequest|null $request
     * @return Player
     */
    public function execute(Player $player, array $data, ?PlayerRequest $request = null): Player
    {
        $player->fill($data);

        if ($request && $request->hasFile('photo')) {
            $player->photo = $request->file('photo')->store('photos', 'public');
        }

        $player->save();

        return $player;
    }
}
