<?php

namespace App\Services;

use App\Enums\CharacterStatus;
use App\Events\CharacterCompletelyDeleted;
use App\Events\CharacterDeleted;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CharacterService
{
    public function create($request)
    {
        $validated = $request->validated();
        $character = $request->user()->characters()->create($validated);
        $character->charsheet()->create();

        $this->saveReference($character, $validated);

        return $character;
    }

    public function saveReference($character, $validated)
    {
        if (isset($validated['reference'])) {
            $this->deleteReferences($character);
            $file = $validated['reference'];
            Storage::disk('characters')->putFileAs($character->id, $file, 'reference');
        }
    }

    public function deleteReferences($character)
    {
        $disk = Storage::disk('characters');

        foreach ($disk->files($character->id) as $file) {
            if (\Str::startsWith(basename($file), 'reference')) {
                $disk->delete($file);
            }
        }
    }

    public function resizeReference($fileName, $size)
    {
        $disk = Storage::disk('characters');
        $img = Image::make($disk->get($fileName));
        $img->resize($size, $size, function ($constraint) {
            $constraint->aspectRatio();
        });

        $disk->put($fileName.'_'.$size, $img->encode());
    }

    public function update($character, $request)
    {
        $validated = $request->validated();

        $character->update($validated);

        $this->saveReference($character, $validated);
    }

    public function restore($character)
    {
        $character->status = CharacterStatus::Blank;
        $character->save();
    }

    public function forceDelete($character)
    {
        event(new CharacterCompletelyDeleted($character));

        $character->delete();
    }

    public function delete($character)
    {
        $character->status = CharacterStatus::Deleting;
        $character->save();

        event(new CharacterDeleted($character));
    }
}
