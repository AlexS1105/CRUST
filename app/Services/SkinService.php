<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class SkinService
{
    public function upload($character, $request)
    {
        $validated = $request->validated();
        $skins = $validated['skins'];
        $prefixes = $validated['prefix'];

        foreach ($skins as $key => $skin) {
            $this->saveSkin($character, $skin, $prefixes[$key] ?? 'default');
        }
    }

    public function saveSkin($character, $file, $prefix)
    {
        $disk = Storage::disk('characters');
        $disk->putFileAs($character->id.'/skins', $file, $prefix);
        $disk->putFileAs('skins', $file, $character->login.'.png');
    }

    public function getSkins($character)
    {
        $disk = Storage::disk('characters');

        return collect($disk->files($character->id.'/skins'))->map(function ($value) use ($disk) {
            return [
                'url' => $disk->url($value),
                'prefix' => basename($value),
            ];
        });
    }

    public function deleteSkin($character, $prefix)
    {
        $disk = Storage::disk('characters');
        $disk->delete($character->id.'/skins/'.$prefix);

        if ($prefix === 'default') {
            $disk->delete('skins/'.$character->login.'.png');
        }
    }
}
