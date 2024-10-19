<?php

namespace App\Http\Controllers;

use App\Http\Requests\Team\TeamRequest;
use App\Models\Team;
use App\Services\Country\CountryIndexService;
use App\Services\Team\TeamDestroyService;
use App\Services\Team\TeamIndexService;
use App\Services\Team\TeamShowService;
use App\Services\Team\TeamStoreService;
use App\Services\Team\TeamUpdateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeamController extends Controller
{
    /**
     * @var TeamIndexService
     */
    protected TeamIndexService $indexService;

    /**
     * @var TeamStoreService
     */
    protected TeamStoreService $storeService;

    /**
     * @var TeamShowService
     */
    protected TeamShowService $showService;

    /**
     * @var TeamUpdateService
     */
    protected TeamUpdateService $updateService;

    /**
     * @var TeamDestroyService
     */
    protected TeamDestroyService $destroyService;

    /**
     * @var CountryIndexService
     */
    protected CountryIndexService $countryIndexService;

    public function __construct(
        TeamIndexService    $indexService,
        TeamStoreService    $storeService,
        TeamShowService   $showService,
        TeamUpdateService   $updateService,
        TeamDestroyService  $destroyService,
        CountryIndexService $countryIndexService
    )
    {
        $this->indexService = $indexService;
        $this->storeService = $storeService;
        $this->showService = $showService;
        $this->updateService = $updateService;
        $this->destroyService = $destroyService;
        $this->countryIndexService = $countryIndexService;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $teams = $this->indexService->execute();
        return view('teams.index', compact('teams'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $countries = $this->countryIndexService->execute();
        return view('teams.form', compact('countries'));
    }

    /**
     * @param TeamRequest $request
     * @return RedirectResponse
     */
    public function store(TeamRequest $request): RedirectResponse
    {
        $this->storeService->execute($request->validated(), $request);
        return redirect()->route('teams.index')->with('success', 'Equipo creado exitosamente');
    }

    /**
     * @param Team $team
     * @return View
     */
    public function show(Team $team): View
    {
        $team = $this->showService->execute($team);
        return view('teams.show', compact('team'));
    }

    /**
     * @param Team $team
     * @return View
     */
    public function edit(Team $team): View
    {
        $countries = $this->countryIndexService->execute();
        return view('teams.form', compact('team', 'countries'));
    }

    /**
     * @param TeamRequest $request
     * @param Team $team
     * @return RedirectResponse
     */
    public function update(TeamRequest $request, Team $team): RedirectResponse
    {
        $this->updateService->execute($team, $request->validated(), $request);
        return redirect()->route('teams.index')->with('success', 'Equipo actualizado exitosamente');
    }

    /**
     * @param Team $team
     * @return RedirectResponse
     */
    public function destroy(Team $team): RedirectResponse
    {
        $this->destroyService->execute($team);
        return redirect()->route('teams.index')->with('success', 'Equipo eliminado exitosamente');
    }
}
