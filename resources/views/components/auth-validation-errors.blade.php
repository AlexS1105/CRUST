@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'mb-4']) }}>
        <div class="font-medium text-red-600">
            {{ __('ui.error') }}
        </div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
