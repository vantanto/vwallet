<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <h3>Hello, {{ Auth::user()->name }}</h3>
</x-app-layout>
