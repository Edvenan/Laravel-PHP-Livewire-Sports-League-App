<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('The League!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
            </div>
            <br>

            <div class="shadow-xl sm:rounded-lg">
                <x-alert-message type="danger">
                    <x-slot name="title">
                        Holy Molly!
                    </x-slot> 
                    What the hell!
                </x-alert-message>
            </div>

        </div>
    </div>

    {{-- call ranking livewire component --}}
    @livewire('ranking')
    
</x-app-layout>
