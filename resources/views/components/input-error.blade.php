@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-danger mt-1 mb-0']) }}>
        @foreach ((array) $messages as $message)
            <li><small>{{ $message }}</small></li>
        @endforeach
    </ul>
@endif
