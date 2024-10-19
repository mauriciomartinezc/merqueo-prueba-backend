<?php

namespace App\Services\Player;

use app\Http\Requests\Player\PlayerRequest;
use App\Models\Player;

class PlayerStoreService
{
    /**+
     * @param array $data
     * @param PlayerRequest|null $request
     * @return Player
     */
    public function execute(array $data, ?PlayerRequest $request = null): Player
    {
        $player = new Player($data);

        if ($request && $request->hasFile('photo')) {
            $player->photo = $request->file('photo')->store('photos', 'public');
        }

        $player->save();

        return $player;
    }
}
