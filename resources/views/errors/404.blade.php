<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-center text-xl text-gray-800 leading-tight ">
            {{ __('The IT Academy Error Page') }}
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 ">

        <div class="text-left border-l-8 border-red-700 shadow-xl rounded-lg">
            <x-alert-message class="flex flex-col" type="danger">
                <x-slot name="title">
                    Holy moly! Exception received!
                </x-slot> 
                <p>Code 404 - Not found. Sorry!</p>
            </x-alert-message>
        </div>
        <div class="text-left border-l-8 border-red-700 shadow-xl rounded-lg">
            <x-alert-message class="flex flex-col" type="danger">
                <x-slot name="title">
                    Exception message:
                </x-slot> 
                <p>{{$exception->getMessage()}}</p>
            </x-alert-message>
        </div>
        <div class="text-left border-l-8 border-red-700 shadow-xl rounded-lg">
            <x-alert-message class="flex flex-col items-left text-left text-wrap" type="danger">
                <x-slot name="title">
                    Exception file:
                </x-slot> 
                <p class="flex flex-col h-full items-left text-left text-wrap whitespace-normal overflow-auto" >{{$exception->getFile()}}</p>
            </x-alert-message>
        </div>
    </div>

</x-app-layout>


{{-- @extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found')) --}}
