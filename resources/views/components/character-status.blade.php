<div class="px-3 py-1 text-white bg-{{ App\Enums\CharacterStatus::getColor($status) }} ring-4 ring-{{ App\Enums\CharacterStatus::getColor($status) }} ring-opacity-50 rounded-full font-bold">
  {{ __($status->description) }}
</div>
