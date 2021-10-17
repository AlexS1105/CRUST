<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Manage Users') }}
    </h2>
  </x-slot>

  <x-container class="max-w-5xl">
    <div class="bg-white rounded-xl shadow-lg p-6 w-auto">
      <x-search-field class="w-full mb-6" :search="$search" :route="route('users.index')"/>

      @if(count($users))
        <table class="table-auto w-full border">
          <thead class="border bg-gray-200">
            <tr>
              <th class="px-4 py-2 border border-gray-400">
                @sortablelink('name', 'Name')
              </th>
              <th class="px-4 py-2 border border-gray-400">
                Characters
              </th>
              <th class="px-4 py-2 border border-gray-400">
                @sortablelink('created_at', 'Registered')
              </th>
              <th class="px-4 py-2 border border-gray-400">
                Actions
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
              <tr class="py-2 border hover:bg-gray-100">
                <td class="px-4 py-2 border">
                  <a class="font-bold underline text-blue-600 visited:text-purple-600" href="{{ route('users.show', $user) }}">
                    {{ $user->name }}
                  </a>
                </td>
                <td class="px-4 py-2 border text-center">
                  @foreach ($user->characters as $character)
                    <a class="font-bold underline text-blue-600 visited:text-purple-600" href="{{ route('characters.show', $character->login) }}">
                      {{ $character->name }}
                    </a>

                    @unless ($loop->last)
                      ,
                    @endunless
                  @endforeach
                </td>
                <td class="px-4 py-2 border text-center">
                  {{ Carbon\Carbon::parse($user->created_at)->diffForHumans() }}
                </td>
                <td class="border">
                  <div class="flex w-min mx-auto">
                    <x-user.actions :user="$user" :tooltip="true"/>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <p class="pt-4 text-xl font-semibold text-gray-500 text-center">
          No users found
        </p>
      @endif

      <div class="pt-4">
        {{ $users->links() }}
      </div>
    </div>
  </x-container>
</x-app-layout>
