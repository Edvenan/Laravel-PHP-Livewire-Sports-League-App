<div wire:init="loadGames">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center text-gray-800 leading-tight">
            {{ __('Games Management') }}
        </h2>
    </x-slot>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- search bar & Creata Game button --}}
        <div class="py-4 flex flex-col sm:flex-row items-center">

            <div class="flex items-center mb-1 sm:mb-0">
                <span class="ml-2 text-xs uppercase text-gray-900">Items</span>
                <select class="ml-2 mr-4 border-gray-300 text-md  text-gray-700 rounded-lg shadow-lg"
                        wire:model="items">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="10000">All</option>
                </select>
            </div>

            <x-input class="flex-1 sm:mr-4 cursor-pointer mb-2 w-full sm:w-auto sm:mb-0" placeholder="Search game by team..." type="text" wire:model="search">
            </x-input>
            @livewire('create-game')
        </div>

        {{-- Games list --}}
        @if($games=='loading')
            <div aria-label="Loading..." role="status" class="my-8 flex items-center justify-center space-x-2">
                <svg class="h-6 w-6 animate-spin stroke-gray-500" viewBox="0 0 256 256">
                    <line x1="128" y1="32" x2="128" y2="64" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line>
                    <line x1="195.9" y1="60.1" x2="173.3" y2="82.7" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line><line x1="224" y1="128" x2="192" y2="128" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line><line x1="195.9" y1="195.9" x2="173.3" y2="173.3" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line><line x1="128" y1="224" x2="128" y2="192" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line><line x1="60.1" y1="195.9" x2="82.7" y2="173.3" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line><line x1="32" y1="128" x2="64" y2="128" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line><line x1="60.1" y1="60.1" x2="82.7" y2="82.7" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line>
                </svg>
                <span class="text-xs font-medium text-gray-500">Loading...</span>
            </div>
        @else
            @if ($games->count())
                {{-- Games found --}}
                <x-table>
                    <table class="min-w-full leading-normal">
                        <thead> {{-- Table header --}}
                            <tr class="border-gray-400">
                                <th {{-- Table header: Team 1--}}
                                    class= "cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider"
                                    wire:click="order('team_1.name')">
                                    <div class="block  sm:flex md:block lg:flex">
                                        Local
                                        <div class="mx-auto sm:mr-0 md:mx-auto lg:mr-0">
                                            {{-- Sort icons --}}
                                            @if ($sort == 'team_1.name')
                                                @if (! $direction)
                                                    <i class="fas fa-sort-alpha-up-alt"></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt"></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort"></i>
                                            @endif
                                        </div>
                                    </div>
                                </th>
                                <th {{-- Table header: Score --}}
                                    class="py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider">
                                    
                                </th>   
                                <th {{-- Table header: Team 2 --}}
                                    class="cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider"
                                    wire:click="order('team_2.name')">
                                    <div class="block sm:flex md:block lg:flex">
                                        Visitor
                                        <div class="mx-auto sm:mr-0 md:mx-auto lg:mr-0">
                                            {{-- Sort icons --}}
                                            @if ($sort == 'team_2.name')
                                                @if (! $direction)
                                                    <i class="fas fa-sort-alpha-up-alt"></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt"></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort"></i>
                                            @endif
                                        </div>
                                    </div>
                                </th>
                                <th {{-- Table header: Date --}}
                                    class="cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider"
                                    wire:click="order('date')">
                                    <div class="block sm:flex md:block lg:flex">
                                        Date
                                        <div class="mx-auto sm:mr-0 md:mx-auto lg:mr-0">
                                            {{-- Sort icons --}}
                                            @if ($sort == 'date')
                                                @if (! $direction)
                                                    <i class="fas fa-sort-alpha-up-alt"></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt"></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort"></i>
                                            @endif
                                        </div>
                                    </div>
                                </th>
                                <th {{-- Table header: Time --}}
                                    class="cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider hidden sm:table-cell"
                                    wire:click="order('time')">
                                    <div class="block sm:flex md:block lg:flex">
                                        Time
                                        <div class="mx-auto sm:mr-0 md:mx-auto lg:mr-0">
                                            {{-- Sort icons --}}
                                            @if ($sort == 'time')
                                                @if (! $direction )
                                                    <i class="fas fa-sort-alpha-up-alt"></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt"></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort"></i>
                                            @endif
                                        </div>
                                    </div>
                                </th>
                                <th {{-- Table header: Stadium --}}
                                    class="cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider hidden sm:table-cell"
                                    wire:click="order('team_1.stadium')">
                                    <div class="block sm:flex md:block lg:flex">
                                        Stadium
                                        <div class="mx-auto sm:mr-0 md:mx-auto lg:mr-0">
                                            {{-- Sort icons --}}
                                            @if ($sort == 'team_1.stadium')
                                                @if (! $direction)
                                                    <i class="fas fa-sort-alpha-up-alt"></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt"></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort"></i>
                                            @endif
                                        </div>
                                    </div>
                                </th>
                                <th {{-- Table header: actions --}}
                                class="px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider ">
                                </th>
                            </tr>
                        </thead>
                        <tbody> {{-- Table body --}}
                            @foreach ($games as $item)

                                <tr class="bg-white ">
                                    {{-- Table row column: Team 1 --}}
                                    <td class=" px-3 py-5 border-b border-gray-200  text-sm">
                                        <div class="flex flex-col items-center text-center sm:flex-row-reverse ">
                                            <div class="order-2 sm:order-2 sm:text-right sm:mr-1 text-gray-900 whitespace-no-wrap">
                                                    {{$item->team_1->name}}
                                            </div>

                                            <div class="order-1 sm:order-1 text-gray-900 h-10 w-full sm:w-10 ">
                                                <img class=" mx-auto h-full sm:float-right"
                                                    src="{{$item->team_1->emblem_photo}}"
                                                    alt="" />
                                            </div>
                                        </div>

                                    </td>
                                    {{-- Table row column: Score --}}
                                    <td class="w-16 py-5  border-b border-gray-200  text-sm">
                                        <div class="">
                                            <p class="text-gray-900  text-center whitespace-no-wrap">
                                                {{$item->score_team_1}}
                                                -
                                                {{$item->score_team_2}}
                                            </p>
                                        </div>
                                    </td>
                                    {{-- Table row column: Team 2 --}}
                                    <td class="px-3 py-5 border-b border-gray-200  text-sm">

                                        <div class="flex flex-col items-center text-center sm:flex-row ">
                                            
                                            <div class="order-1 sm:no-order text-gray-900 h-10 w-full sm:w-10 ">
                                                <img class="mx-auto h-full sm:float-left "
                                                    
                                                    src="{{$item->team_2->emblem_photo}}"
                                                    alt="" />
                                            </div>
                                            <div class="order-2 sm:no-order sm:text-left sm:ml-1 text-gray-900 whitespace-no-wrap">
                                                    {{$item->team_2->name}}
                                            </div>

                                        </div>
                                    </td>
                                    {{-- Table row column: Date --}}
                                    <td class="px-3 py-5 border-b border-gray-200  text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap text-center">
                                            {{date('j F, Y', strtotime($item->date))}}
                                        </p>
                                    </td>
                                    {{-- Table row column: Time --}}
                                    <td class="px-3 py-5 border-b border-gray-200  text-sm hidden sm:table-cell">
                                        <p class="text-gray-900 whitespace-no-wrap text-center">
                                            {{\Carbon\Carbon::createFromFormat('H:i:s',$item->time)->format('H:i')}}
                                        </p>
                                    </td>
                                    {{-- Table row column: Stadium --}}
                                    <td class="px-3 py-5 border-b border-gray-200  text-sm hidden sm:table-cell">
                                        <p class="text-gray-900 whitespace-no-wrap text-center">
                                            {{$item->team_1->stadium}}
                                        </p>
                                    </td>
                                    {{-- Table row column: Action Buttons --}}
                                    <td class="border-b border-gray-200 text-sm ">
                                        {{-- call to EditGame component --}}
                                        {{-- @livewire('edit-game', ['game' => $game], key($game->id)) --}}
                                        <div class="flex flex-col pl-1 pr-2 mx-auto space-y-3 items-center sm:flex-row sm:px-1 sm:py-4 sm:space-x-2 sm:space-y-0">
                                            <a class="btn btn-blue" wire:click="edit({{$item}})">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                    
                                            <a class="btn btn-red" wire:click="$emit('alert_delete', 'show-games', {{$item}})">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                </x-table>

                {{-- Pagination --}}
                @if($games->hasPages())
                    <div class="sm:pl-4 pb-4">
                        {{$games->links()}}
                    </div>
                @endif
            @else
                {{-- no games found --}}
                <div class="px-12">
                    <x-alert-message type="danger">
                        <x-slot name="title">
                            The IT Academy League:
                        </x-slot> 
                            No games found!
                    </x-alert-message>
                </div>

            @endif
        @endif
        
    </div>

    {{-- Edit modal --}}
    <x-dialog-modal wire:model='open_edit'>

        <x-slot name='title'>
            <p class="text-center">Edit Game</p> 
            @if ($game->team_1_id)
                <p class="text-sm sm:text-lg mt-8 text-center text-blue-500">{{$game->team_1->name}} - {{$game->team_2->name}}</p>
            @endif
        </x-slot>

        <x-slot name='content'>

            <div class="flex flex-col items-center      sm:items-stretch">
                {{-- teams selection --}}
                <div class="flex flex-row mb-4      sm:flex-col">

                    {{-- Labels --}}
                    <div class="flex flex-col text-right justify-between py-2      sm:flex-row sm:px-16">
                        <x-label for='game.team_1_id' value="Local Team" />
                        @if ($game->date <= now()->format('Y-m-d'))
                            <x-label class="text-right" value="Score" />
                        @endif
                        <x-label for='game.team_2_id' value="Visitor Team" />
                    </div>
                    <div class="flex flex-col justify-between ml-4      sm:flex-row sm:ml-0 ">
                        {{-- team & score 1  --}}
                        <div class="flex flex-col space-y-1       sm:flex-row sm:space-y-0 sm:space-x-8">
                            <select class="w-52 text-sm rounded-lg border-gray-300 shadow-lg" id='game.team_1_id' wire:model='game.team_1_id'>
                                {{-- <option value="{{$game->team_1_id}}">{{$game->team_1->name}}</option> --}}
                                @foreach($locals as $local)
                                    <option value="{{$local->id}}" {{ $game->team_1_id == $local->id ? 'selected' : '' }}>{{$local->name}}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-1 text-xs" for='localId'/>
                            @if ($game->date <= now()->format('Y-m-d'))
                                <div class="flex flex-col items-center    sm:flex-row sm:space-x-1.5">
                                    <x-input class="w-16 mx-auto sm:px-1 text-center text-sm" id="game.score_team_1" type="number" min="0" onkeydown="return false" wire:model="game.score_team_1"/>
                                    <x-input-error class="mt-1 text-xs" for='game.score_team_1'/>
                                    <span class="text-center">-</span>
                                </div>
                            @endif
                        </div>
                    
                        {{-- team & score 2  --}}
                        <div class="flex flex-col space-y-1      sm:flex-row sm:space-y-0 sm:space-x-8">
                            @if ($game->date <= now()->format('Y-m-d'))
                                <x-input class="w-16 mx-auto sm:px-1 text-center text-sm" id="game.score_team_2" type="number" min="0" onkeydown="return false" wire:model="game.score_team_2"/>
                                <x-input-error class="mt-1 text-xs" for='game.score_team_2'/>
                            @endif
                            <select class="w-52 text-sm rounded-lg border-gray-300 shadow-lg" id='game.team_2_id' wire:model='game.team_2_id'>
                                @foreach($visitors as $visitor)
                                    <option value="{{$visitor->id}}" {{ $game->team_2_id == $visitor->id ? 'selected' : '' }}>{{$visitor->name}}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-1 text-xs" for='game.team_2_id'/>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-4 mb-4 text-center sm:justify-between sm:w-full">
                    {{-- Game Date --}}
                    <div class=" ml-4      sm:ml-0">
                        <x-label for='game.date' value="Game Date" />
                        <x-input class=" text-sm" id="game.date" type="date" wire:model="game.date"/>
                        <x-input-error class="mt-1 text-xs" for='game.date'/>
                    </div>
                    {{-- Game Time --}}
                    <div class=" ">
                        <x-label for='game.time' value="Game Time" />
                        <x-input class=" text-sm" id="game.time" type="time"  wire:model="game.time"/>
                        <x-input-error class="mt-1 text-xs" for='game.time'/>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name='footer'>
            <x-secondary-button wire:click="$set('open_edit', false)">
                Cancel
            </x-secondary-button>

            <x-danger-button class="ml-4" wire:click="update" wire:loading.remove wire:target="update">
                Update Game
            </x-danger-button>

            <x-danger-button class="ml-4" wire:loading wire:target="update">Updating...</x-danger-button>

        </x-slot>

    </x-dialog-modal>

</div>
