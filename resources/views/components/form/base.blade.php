<form class="space-y-8 {{ $attributes->get('class') }}" method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @method($method)

    {{ $slot }}
</form>
