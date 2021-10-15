<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Applications') }}
      </h2>
  </x-slot>

  <div class="py-8 max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-4 w-auto">
      <div class="flex mb-4 gap-4">
        @foreach (App\Enums\CharacterStatus::getInstances() as $_status)
          <a href="{{ route('applications.index', [ 'status' => $_status->value ]) }}" class="{{ $status == $_status ?:"opacity-40" }}">
            <x-character.status :status=$_status/>
          </a>
        @endforeach
      </div>

      <table class="table-auto w-full border">
        <thead class="border bg-gray-200">
          <tr>
            <th class="px-4 py-2 border border-gray-400">
              Character
            </th>
            <th class="px-4 py-2 border border-gray-400">
              Player
            </th>
            <th class="px-4 py-2 border border-gray-400">
              Time
            </th>
            <th class="px-4 py-2 border border-gray-400">
              Actions
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($characters as $character)
            <tr class="py-2 border hover:bg-gray-100 text-center">
              <td class="px-4 py-2 border">
                <a class="font-bold underline text-blue-600 visited:text-purple-600" href="{{ route('characters.show', $character->login) }}">
                  {{ $character->name }}
                </a>
              </td>
              <td class="px-4 py-2 border">
                {{ $character->user->name }}
              </td>
              <td class="px-4 py-2 border">
                {{ Carbon\Carbon::parse($character->status_updated_at)->diffForHumans() }}
              </td>
              <td class="px-4 py-2 border">
                {{-- TODO: Application Actions --}}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="pt-4">
        {{ $characters->appends(request()->query())->links() }}
      </div>
    </div>
  </div>
</x-app-layout>
