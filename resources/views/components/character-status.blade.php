<div class="px-3 py-1 text-white bg-{{ App\Enums\CharacterStatus::getColor($status) }} rounded-full font-bold">
  {{ __($status->description) }}
</div>
