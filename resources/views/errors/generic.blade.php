<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-center text-xl text-gray-800 leading-tight ">
            {{ __('The IT Academy League Ranking') }}
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 ">

        <div class="text-left border-l-8 border-red-700 shadow-xl sm:rounded-lg">
            <x-alert-message class="flex flex-col" type="danger">
                <x-slot name="title">
                    Holy moly! Exception thrown.
                </x-slot> 
                <p>Don't know why. Sorry!</p>
            </x-alert-message>
        </div>
        
    </div>

</x-app-layout>