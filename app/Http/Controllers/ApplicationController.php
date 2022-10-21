<?php

namespace App\Http\Controllers;

use App\Enums\CharacterStatus;
use App\Models\Character;
use App\Services\ApplicationService;

class ApplicationController extends Controller
{
    protected $applicationService;

    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function index()
    {
        $this->authorize('view-applications', Character::class);

        $search = request('search');
        $status = request('status', CharacterStatus::Pending);
        $characters = Character::search($search)
            ->status($status)
            ->oldest('status_updated_at')
            ->sortable()
            ->paginate(20);

        return view('applications.index', compact('characters', 'search', 'status'));
    }

    public function send(Character $character)
    {
        $this->authorize('send', $character);

        $this->applicationService->send($character);

        return back();
    }

    public function cancel(Character $character)
    {
        $this->authorize('cancel', $character);

        $this->applicationService->cancel($character);

        return back();
    }

    public function takeForApproval(Character $character)
    {
        $this->authorize('take-for-approval', $character);

        $this->applicationService->takeForApproval($character);

        return back();
    }

    public function cancelApproval(Character $character)
    {
        $this->authorize('cancel-approval', $character);

        $this->applicationService->cancelApproval($character);

        return back();
    }

    public function requestChanges(Character $character)
    {
        $this->authorize('request-changes', $character);

        $this->applicationService->changesRequested($character);

        return back();
    }

    public function requestApproval(Character $character)
    {
        $this->authorize('request-approval', $character);

        $this->applicationService->requestApproval($character);

        return back();
    }

    public function approve(Character $character)
    {
        $this->authorize('approve', $character);

        $this->applicationService->approve($character);

        return back();
    }

    public function reapproval(Character $character)
    {
        $this->authorize('reapproval', $character);

        $this->applicationService->reapproval($character);

        return back();
    }
}
