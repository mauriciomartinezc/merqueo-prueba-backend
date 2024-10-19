<?php

namespace App\Http\Controllers;

use App\Services\Game\GameService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class TournamentController extends Controller
{
    /**
     * @var GameService
     */
    protected GameService $gameService;

    /**
     * @param GameService $gameService
     */
    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $gamesByRound = $this->gameService->getGamesGroupedByRound();
        $finalGame = $this->gameService->getFinalGame();
        $thirdPlaceGame = $this->gameService->getThirdPlaceGame($finalGame);

        return view('tournaments.index', compact('gamesByRound', 'finalGame', 'thirdPlaceGame'));
    }

    /**
     * @return RedirectResponse
     */
    public function generate(): RedirectResponse
    {
        Artisan::call('simulate:games');
        return redirect()->route('tournaments.index');
    }
}
