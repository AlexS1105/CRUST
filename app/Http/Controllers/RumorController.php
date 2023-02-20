<?php

namespace App\Http\Controllers;

use App\Http\Requests\RumorRequest;
use App\Models\Character;
use App\Models\Rumor;

class RumorController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $rumors = Rumor::with('character', 'user')
            ->latest()
            ->when(! $user->can('see-index', Rumor::class), function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })
            ->paginate(30);

        return view('rumors.index', compact('rumors'));
    }

    public function create(Character $character)
    {
        $this->authorize('create', [Rumor::class, $character]);

        return view('rumors.create', compact('character'));
    }

    public function store(RumorRequest $request, Character $character)
    {
        $this->authorize('create', [Rumor::class, $character]);

        $character->rumors()->create(array_merge($request->validated(), ['user_id' => auth()->id()]));

        return to_route('characters.show', $character);
    }

    public function edit(Rumor $rumor)
    {
        $this->authorize('manage', $rumor);

        $character = $rumor->character;

        return view('rumors.edit', compact('rumor', 'character'));
    }

    public function update(RumorRequest $request, Rumor $rumor)
    {
        $this->authorize('manage', $rumor);

        $rumor->update($request->validated());

        return to_route('characters.show', $rumor->character);
    }

    public function destroy(Rumor $rumor)
    {
        $this->authorize('manage', $rumor);

        $character = $rumor->character;
        $rumor->delete();

        return to_route('characters.show', $character);
    }
}
