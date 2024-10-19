<?php

namespace App\Http\Controllers;

use App\Http\Requests\Player\PlayerRequest;
use App\Models\Player;
use App\Services\Player\PlayerDestroyService;
use App\Services\Player\PlayerIndexService;
use App\Services\Player\PlayerShowService;
use App\Services\Player\PlayerStoreService;
use App\Services\Player\PlayerUpdateService;
use App\Services\Team\TeamIndexService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PlayerController extends Controller
{
    /**
     * @var PlayerIndexService
     */
    protected PlayerIndexService $indexService;

    /**
     * @var PlayerStoreService
     */
    protected PlayerStoreService $storeService;

    /**
     * @var PlayerShowService
     */
    protected PlayerShowService $showService;

    /**
     * @var PlayerUpdateService
     */
    protected PlayerUpdateService $updateService;

    /**
     * @var PlayerDestroyService
     */
    protected PlayerDestroyService $destroyService;

    /**
     * @var TeamIndexService
     */
    protected TeamIndexService $teamIndexService;

    public function __construct(
        PlayerIndexService   $indexService,
        PlayerStoreService     $storeService,
        PlayerShowService    $showService,
        PlayerUpdateService    $updateService,
        PlayerDestroyService $destroyService,
        TeamIndexService  $teamIndexService
    )
    {
        $this->indexService = $indexService;
        $this->storeService = $storeService;
        $this->showService = $showService;
        $this->updateService = $updateService;
        $this->destroyService = $destroyService;
        $this->teamIndexService = $teamIndexService;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $players = $this->indexService->execute();
        return view('players.index', compact('players'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $teams = $this->teamIndexService->execute();
        return view('players.form', compact('teams'));
    }

    /**
     * @param PlayerRequest $request
     * @return RedirectResponse
     */
    public function store(PlayerRequest $request): RedirectResponse
    {
        $this->storeService->execute($request->validated(), $request);
        return redirect()->route('players.index')->with('success', 'Jugador creado exitosamente');
    }

    /**
     * @param Player $player
     * @return View
     */
    public function show(Player $player): View
    {
        $player = $this->showService->execute($player);
        return view('players.show', compact('player'));
    }

    /**
     * @param Player $player
     * @return View
     */
    public function edit(Player $player): View
    {
        $teams = $this->teamIndexService->execute();
        return view('players.form', compact('player', 'teams'));
    }

    /**
     * @param PlayerRequest $request
     * @param Player $player
     * @return RedirectResponse
     */
    public function update(PlayerRequest $request, Player $player): RedirectResponse
    {
        $this->updateService->execute($player, $request->validated(), $request);
        return redirect()->route('players.index')->with('success', 'Jugador actualizado exitosamente');
    }

    /**
     * @param Player $player
     * @return RedirectResponse
     */
    public function destroy(Player $player): RedirectResponse
    {
        $this->destroyService->execute($player);
        return redirect()->route('players.index')->with('success', 'Jugador eliminado exitosamente');
    }
}
