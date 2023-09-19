<div wire:init="loadTeams">

    {{-- Show All header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center text-gray-800 leading-tight">
            {{ __('Teams Management') }}
        </h2>
    </x-slot>

    {{-- Show All teams --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6">

            {{-- search bar & Create Team button --}}
            <div class=" py-4 flex items-center">
                <x-input class="flex-1 mr-4  cursor-pointer" placeholder="Search teams by name, year, stadium..." type="text" wire:model="search">
                </x-input>
                @livewire('create-team')
            </div>

            @if($teams=='loading')
                <div aria-label="Loading..." role="status" class="my-8 flex items-center justify-center space-x-2">
                    <svg class="h-6 w-6 animate-spin stroke-gray-500" viewBox="0 0 256 256">
                        <line x1="128" y1="32" x2="128" y2="64" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line>
                        <line x1="195.9" y1="60.1" x2="173.3" y2="82.7" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line><line x1="224" y1="128" x2="192" y2="128" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line><line x1="195.9" y1="195.9" x2="173.3" y2="173.3" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line><line x1="128" y1="224" x2="128" y2="192" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line><line x1="60.1" y1="195.9" x2="82.7" y2="173.3" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line><line x1="32" y1="128" x2="64" y2="128" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line><line x1="60.1" y1="60.1" x2="82.7" y2="82.7" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line>
                    </svg>
                    <span class="text-xs font-medium text-gray-500">Loading...</span>
                </div>
            @else
                @if ($teams->count())
                    {{-- card grid with teams found --}}
                    <x-card-list-section>
                        
                        @foreach ($teams as $item)
                            <!-- Card Item -->
                            <!-- Clickable Area -->
                            <div class="border my-2 rounded shadow-lg shadow-gray-200 dark:shadow-gray-900 bg-white dark:bg-gray-800 
                                    duration-300 hover:-translate-y-2 hover:border-red-600 hover:border-4 cursor-pointer " 
                                    wire:click="show({{$item}})">

                                    <figure class="p-4 pb-0 flex flex-col justify-between h-full">
                                        <!-- Image -->
                                        <img src="{{$item->emblem_photo}}" class="rounded-t m-auto" />
                                        

                                        <figcaption class="py-4 mb-0">
                                            <div class="mb-4">
                                                <!-- Name -->
                                                <p
                                                    class="text-center h-16 text-sm sm:text-lg mb-4 font-bold leading-relaxed text-gray-800 dark:text-gray-300 overflow-" >
                                                    {{$item->name}}
                                                </p>
                                                {{-- <!-- Foundation Year -->
                                                <p class="float-right">
                                                    {{$item->foundation_year}}
                                                </p>
                                                <small
                                                    class="leading-5 mt-4 text-gray-500 dark:text-gray-400"
                                                    >
                                                    Foundation Year:
                                                </small>
                                                <!-- Stadium -->
                                                <p>
                                                    <small
                                                        class="leading-5 mt-4 text-gray-500 dark:text-gray-400"
                                                        >
                                                        Stadium:
                                                    </small><br>
                                                    <small
                                                        class=" text-gray-500 dark:text-gray-400 float-right"
                                                        >
                                                        {{$item->stadium}}
                                                    </small>
                                                </p><br>
                                                <p class="float-right font-bold">
                                                        {{$item->position()}}
                                                </p>
                                                <small class="leading-5 float-left ">
                                                    Position:
                                                </small>    --}}     
                                            </div>
                                        </figcaption>
                                        
                                    </figure>
                            </div>
                        @endforeach

                    </x-card-list-section>
        
                @else
                    {{-- no teams found --}}
                    <div class="px-12 py-4">
                        <x-alert-message type="danger">
                            <x-slot name="title">
                                The IT Academy League:
                            </x-slot> 
                                No teams found!
                        </x-alert-message>
                    </div>
                @endif 
            @endif

    </div>

    {{-- Edit Modal --}}
    <x-dialog-modal  wire:model='open_edit'>

        <x-slot  name='title'>
            <p class="text-center">Edit Team</p> 
            
        </x-slot>

        <x-slot name='content'>
            <div class="flex flex-col items-center     sm:block">
                <div class="flex flex-col sm:flex-row ">
                    {{-- team name  --}}
                    <div class="mb-4 flex-1">
                        <x-label for='team.name' value="Team name:" />
                        <x-input class="ml-4  text-sm" type="text" id='team.name' wire:model='team.name'/>
                        <x-input-error class="mt-1 ml-4 text-xs" for='team.name'/>

                    </div>
                    {{-- team foundation year --}}
                    <div class="mb-4 flex-1">
                        <x-label for='team.foundation_year' value="Foundation Year:" />
                        <x-input class="ml-4  text-sm" type="number" id='team.foundation_year' max="2023" min="1850" wire:model='team.foundation_year'/>
                        <x-input-error class="mt-1 ml-4 text-xs" for='team.foundation_year'/>
                        
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row">
                    {{-- Team Stadium --}}
                    <div class="mb-4 flex-1">
                        <x-label for='team.stadium' value="Stadium:" />
                        <x-input class="ml-4  text-sm" id="team.stadium" type="text" wire:model="team.stadium"/>
                        <x-input-error class="mt-1 ml-4 text-xs" for='team.stadium'/>
                        
                    </div>
                    {{-- Team Emblem --}}
                    <div class="mb-4 flex-1">
                        <x-label for='team.emblem_photo' value="Team Emblem (url):" />
                        <x-input class="ml-4 sm:w-72   text-sm" id="team.emblem_photo" type="url" wire:model="team.emblem_photo"/>
                        <x-input-error class="mt-1 ml-4 text-xs" for='team.emblem_photo'/>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name='footer'>
            <x-secondary-button wire:click="cancel">
                Cancel
            </x-secondary-button>

            <x-danger-button class="ml-4" wire:click="update" wire:loading.remove wire:target="update">
                Update Team
            </x-danger-button>

            <x-danger-button class="ml-4" wire:loading wire:target="update">Updating...</x-danger-button>

        </x-slot>

    </x-dialog-modal>

    {{-- Show Modal --}}
    <x-dialog-modal  wire:model='open_show'>

        <x-slot name='title'>
            <p class="flex justify-center text-center">Show Team</p>
        </x-slot>

        <x-slot name='content'>
            
            <figure class="pt-4 pb-0 flex flex-col">
                <!-- Image -->
                <img
                    src="{{$team->emblem_photo}}"
                    class="rounded-t mx-auto h-32 " />

                <figcaption class="p-1 sm:p-4 mt-auto w-full mx-auto ">
                    <!-- Name -->
                    <p
                        class="h-16 flex justify-center text-center text-lg mb-4 font-bold  text-gray-800 dark:text-gray-300">
                        {{$team->name}}
                    </p>
                    <!-- Foundation Year -->
                    <div class="flex justify-between leading-5 mt-4 text-gray-800 dark:text-gray-400">
                        <p>Foundation Year:</p>
                        <p>{{$team->foundation_year}}</p>
                    </div>
                    <!-- Stadium -->
                    <div class="flex justify-between leading-5 mt-4 text-gray-800 dark:text-gray-400">
                        <p>Stadium:</p>
                        <p>{{$team->stadium}}</p>
                    </div>

                    <x-section-border />
                    
                    <p class="mt-2 text-gray-800">Statistics:</p>
                    
                    {{-- statistics --}}  
                    <x-table>
                
                        <table class="min-w-full leading-normal">
                            <thead> {{-- Table header --}}
                                <tr>
                                    <th {{-- Table header: Rank --}}
                                        class="px-3 py-3  border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider">
                                        Rank

                                    </th>
                                    
                                    <th {{-- Table header: Num Games --}}
                                        class="px-2 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider">
                                        Matches
                                        
                                    </th>
                                    <th {{-- Table header: Games Won --}}
                                        class="px-2 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider hidden sm:table-cell">
                                        Won
       
                                    </th>
                                    <th {{-- Table header: Games Draw --}}
                                        class="px-2 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider hidden sm:table-cell">
                                        Draw

                                    </th>
                                    <th {{-- Table header: Games Lost --}}
                                        class="px-2 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider hidden sm:table-cell">                                       Lost

                                    </th>
                                    <th {{-- Table header: Goals --}}
                                        class="px-2 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider hidden sm:table-cell">
                                        Goals

                                    </th>
                                    <th {{-- Table header: Goals Against --}}
                                        class="px-2 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider hidden sm:table-cell">
                                        Against

                                    </th>
                                    <th {{-- Table header: Goal Average --}}
                                        class="px-2 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider hidden sm:table-cell">
                                        +/-.
        
                                    </th>
                                    <th {{-- Table header: Points --}}
                                        class="px-2 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider">
                                        Pts.
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
     
                                    <tr>
                                        <td class="px-3 py-5 border-b text-center border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900  whitespace-no-wrap">
                                                {{$team->position()}}
                                            </p>
                                        </td>
                                        <td class="px-2 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap text-center">
                                                {{$team->num_games}}
                                            </p>
                                        </td>
                                        <td class="px-2 py-5 border-b border-gray-200 bg-white text-sm hidden sm:table-cell">
                                            <p class="text-gray-900 whitespace-no-wrap text-center">
                                                {{$team->won}}
                                            </p>
                                        </td>
                                        <td class="px-2 py-5 border-b border-gray-200 bg-white text-sm hidden sm:table-cell">
                                            <p class="text-gray-900 whitespace-no-wrap text-center">
                                                {{$team->draw}}
                                            </p>
                                        </td>
                                        <td class="px-2 py-5 border-b border-gray-200 bg-white text-sm hidden sm:table-cell">
                                            <p class="text-gray-900 whitespace-no-wrap text-center">
                                                {{$team->lost}}
                                            </p>
                                        </td>
                                        <td class="px-2 py-5 border-b border-gray-200 bg-white text-sm hidden sm:table-cell">
                                            <p class="text-gray-900 whitespace-no-wrap text-center">
                                                {{$team->goals}}
                                            </p>
                                        </td>
                                        <td class="px-2 py-5 border-b border-gray-200 bg-white text-sm hidden sm:table-cell">
                                            <p class="text-gray-900 whitespace-no-wrap text-center">
                                                {{$team->against}}
                                            </p>
                                        </td>
                                        <td class="px-2 py-5 border-b border-gray-200 bg-white text-sm hidden sm:table-cell">
                                            <p class="text-gray-900 whitespace-no-wrap text-center">
                                                {{$team->average}}
                                            </p>
                                        </td>
                                        <td class="px-2 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap text-center">
                                                {{$team->points}}
                                            </p>
                                        </td>
                                    </tr>
                              
                            </tbody>
                        </table>
        
                    </x-table>

                    <x-section-border />

                    <p class="mt-2 text-gray-800">Games:</p>

                    {{-- game list --}}
                    @if ($team->games()->count())
                        {{-- Games found --}}
                        <x-table>
                            <table class="min-w-full leading-normal">
                                <thead> {{-- Table header --}}
                                    <tr class="border-gray-400">
                                        <th {{-- Table header: Team 1--}}
                                            class= "cursor-pointer py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider">
                                            Local
                                        </th>
                                        <th {{-- Table header: Score --}}
                                            class="py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider">
                                            <p></p>
                                        </th>   
                                        <th {{-- Table header: Team 2 --}}
                                            class="cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider">
                                            Visitor
                                        </th>
                                        <th {{-- Table header: Date --}}
                                            class="cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th {{-- Table header: Time --}}
                                            class="cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider hidden sm:table-cell">
                                            Time
                                        </th>
                                        <th {{-- Table header: Stadium --}}
                                            class="cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider hidden sm:table-cell">
                                            Stadium
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($team->games() as $item)
            
                                    <tr class="bg-white ">
                                        {{-- Table row column: Team 1 --}}
                                        <td class=" px-3 py-5 border-b border-gray-200  text-xs sm:text-sm">
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
                                        <td class="px-3 py-5 border-b border-gray-200   text-xs sm:text-sm">
    
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
                                        <td class="px-3 py-5 border-b border-gray-200  text-xs sm:text-sm">
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
                                    </tr>
                                        
                                    @endforeach
                                </tbody>
                            </table>
                        </x-table>
            
                    @else
                        {{-- no games found --}}
                        <div class="px-4 sm:px-12">
                            <x-alert-message type="danger">
                                <x-slot name="title">
                                    The IT Academy League:
                                </x-slot> 
                                    No games found!
                            </x-alert-message>
                        </div>
            
                    @endif

                </figcaption>
            </figure>

        </x-slot>

        <x-slot name='footer'>
            
            {{-- Buttons --}}
            <div class="flex mb-0 w-full justify-between ">
                <a class="btn btn-blue mr-auto" wire:click="edit({{$team}})">
                    <i class="fas fa-edit"></i>
                </a>
                <x-danger-button class="m-auto" wire:click="$set('open_show', false)">
                    Close
                </x-danger-button>
                <a class="btn btn-red ml-auto" wire:click="$emit('alert_delete', 'show-teams', {{$team}})">
                    <i class="fa-solid fa-trash "></i>
                </a>
            </div>

        </x-slot>

    </x-dialog-modal>

</div>            
        