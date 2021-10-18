<x-card>
  @if (isset($header))
    <h1 class="text-xl font-bold text-gray-700 uppercase mb-4">
      {{ $header }}
    </h1>
  @endif

  <div class="space-y-6">
    {{ $slot }}
  </div>
</x-card>
