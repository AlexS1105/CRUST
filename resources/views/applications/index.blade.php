<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Applications') }}
      </h2>
  </x-slot>

  <x-container class="max-w-5xl">
    <div class="bg-white rounded-xl shadow-lg p-6 w-auto">
      <div class="flex mb-4 gap-4 items-center">
        @foreach (App\Enums\CharacterStatus::getInstances() as $_status)
          <a href="{{ route('applications.index', [ 'status' => $_status->value ]) }}" class="{{ $status == $_status ?:"opacity-40" }}">
            <x-character.status :status=$_status/>
          </a>
        @endforeach

        <x-search-field class="w-full" :search="$search" :route="route('applications.index')"/>
      </div>

      @if(count($characters))
        <table class="table-auto w-full border">
          <thead class="border bg-gray-200">
            <tr>
              <th class="px-4 py-2 border border-gray-400">
                @sortablelink('name', 'Name')
              </th>
              <th class="px-4 py-2 border border-gray-400">
                @sortablelink('user.login', 'Player')
              </th>
              @unless($status == App\Enums\CharacterStatus::Blank() || $status == App\Enums\CharacterStatus::Pending())
              <th class="px-4 py-2 border border-gray-400">
                @sortablelink('registrar.name', 'Registrar')
              </th>
              @endunless
              @unless (isset($status))
                <th class="px-4 py-2 border border-gray-400">
                  @sortablelink('status', 'Status')
                </th>
              @endif
              <th class="px-4 py-2 border border-gray-400">
                @sortablelink('status_updated_at', 'Time')
              </th>
              <th class="px-4 py-2 border border-gray-400">
                Actions
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($characters as $character)
              <tr class="py-2 border hover:bg-gray-100">
                <td class="px-4 py-2 border">
                  <a class="font-bold underline text-blue-600 visited:text-purple-600" href="{{ route('characters.show', $character->login) }}">
                    {{ $character->name }}
                  </a>
                </td>
                <td class="px-4 py-2 border text-center">
                  <a class="font-bold underline text-blue-600 visited:text-purple-600" href="{{ route('users.show', $character->user) }}">
                    {{ $character->user->login }}
                  </a>
                </td>
                @unless($status == App\Enums\CharacterStatus::Blank() || $status == App\Enums\CharacterStatus::Pending())
                <td class="px-4 py-2 border text-center">
                  {{ $character->registrar ? $character->registrar->login : "" }}
                </td>
                @endunless
                @unless (isset($status))
                <td class="px-4 py-2 border text-center">
                  <x-character.status :status="$character->status" />
                </td>
                @endunless
                <td class="px-4 py-2 border text-center">
                  {{ Carbon\Carbon::parse($character->status_updated_at)->diffForHumans() }}
                </td>
                <td class="border">
                  <div class="flex w-min mx-auto">
                    <x-application.actions :character="$character" :tooltip="true"/>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <p class="pt-4 text-xl font-semibold text-gray-500 text-center">
          No characters found
        </p>
      @endif

      <div class="pt-4">
        {{ $characters->appends(request()->query())->links() }}
      </div>
    </div>
  </x-container>
</x-app-layout>
