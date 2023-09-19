<div>

    <x-slot name="header">
        <h2 class="font-semibold text-center text-xl text-gray-800 leading-tight ">
            {{ __('League Ranking') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">

        {{-- items selection & search bar --}}
        <div class=" py-4 flex items-center ">
            <div class="flex items-center ">
                <span class="ml-2 text-xs uppercase text-gray-900">Items</span>
                <select class="ml-2 mr-4 border-gray-300 text-md  text-gray-700 rounded-lg shadow-lg"
                        wire:model="items">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="10000">All</option>
                </select>
            </div>
            
            <x-input class="flex-1 cursor-pointer" placeholder="Search teams by name, year, stadium..." type="text" wire:model="search">
            </x-input>
        </div>

        {{-- Ranking --}}
        
            @if ($teams->count())
                <x-table>
                    <table class="min-w-full leading-normal">
                        <thead> {{-- Table header --}}
                            <tr>
                                <th {{-- Table header: Rank --}}
                                    class="  cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider "
                                    wire:click="order('position')">
                                    <div class="block sm:flex md:block lg:flex">
                                        Rank
                                        <div class="mx-auto sm:mr-0 md:mx-auto lg:mr-0">
                                            {{-- Sort icons --}}
                                            @if ($sort == 'position')
                                                @if ($direction == 'asc')
                                                    <i class=" fas fa-sort-alpha-up-alt  "></i>
                                                @else
                                                    <i class=" fas fa-sort-alpha-down-alt  "></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort "></i>
                                            @endif
                                        </div>
                                    </div>
                                </th>
                                <th {{-- Table header: Team --}}
                                    class="cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider"
                                    wire:click="order('name')">
                                    <div class="block sm:flex md:block lg:flex">
                                        Team
                                        <div class="mx-auto sm:mr-0 md:mx-auto lg:mr-0">
                                            {{-- Sort icons --}}
                                            @if ($sort == 'name')
                                                @if ($direction == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt "></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt "></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort "></i>
                                            @endif
                                        </div>
                                    </div>
                                </th>
                                <th {{-- Table header: Num Games --}}
                                    class="cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider"
                                    wire:click="order('num_games')">
                                    <div class="block sm:flex md:block lg:flex">
                                        Matches
                                        <div class="mx-auto sm:mr-0 md:mx-auto lg:mr-0">
                                            {{-- Sort icons --}}
                                            @if ($sort == 'num_games')
                                                @if ($direction == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt "></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt "></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort "></i>
                                            @endif
                                        </div>
                                    </div>
                                </th>
                                <th {{-- Table header: Games Won --}}
                                    class="cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider hidden md:table-cell"
                                    wire:click="order('won')">
                                    <div class="block sm:flex md:block lg:flex">
                                        Won
                                        <div class="mx-auto sm:mr-0 md:mx-auto lg:mr-0">
                                            {{-- Sort icons --}}
                                            @if ($sort == 'won')
                                                @if ($direction == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt "></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt "></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort "></i>
                                            @endif
                                        </div>
                                    </div>
                                </th>
                                <th {{-- Table header: Games Draw --}}
                                    class="cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider hidden md:table-cell"
                                    wire:click="order('draw')">
                                    <div class="block sm:flex md:block lg:flex">
                                        Draw
                                        <div class="mx-auto sm:mr-0 md:mx-auto lg:mr-0">
                                            {{-- Sort icons --}}
                                            @if ($sort == 'draw')
                                                @if ($direction == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt "></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt "></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort "></i>
                                            @endif
                                        </div>
                                    </div>
                                </th>
                                <th {{-- Table header: Games Lost --}}
                                    class="cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider hidden md:table-cell"
                                    wire:click="order('lost')">
                                    <div class="block sm:flex md:block lg:flex">
                                        Lost
                                        <div class="mx-auto sm:mr-0 md:mx-auto lg:mr-0">
                                            {{-- Sort icons --}}
                                            @if ($sort == 'lost')
                                                @if ($direction == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt "></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt "></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort "></i>
                                            @endif
                                        </div>
                                    </div>
                                </th>
                                <th {{-- Table header: Goals --}}
                                    class="cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider hidden md:table-cell"
                                    wire:click="order('goals')">
                                    <div class="block sm:flex md:block lg:flex">
                                        Goals
                                        <div class="mx-auto sm:mr-0 md:mx-auto lg:mr-0">
                                            {{-- Sort icons --}}
                                            @if ($sort == 'goals')
                                                @if ($direction == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt "></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt "></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort "></i>
                                            @endif
                                        </div>
                                    </div>
                                </th>
                                <th {{-- Table header: Goals Against --}}
                                    class="cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider hidden md:table-cell"
                                    wire:click="order('against')">
                                    <div class="block sm:flex md:block lg:flex">
                                        Against
                                        <div class="mx-auto sm:mr-0 md:mx-auto lg:mr-0">
                                            {{-- Sort icons --}}
                                            @if ($sort == 'against')
                                                @if ($direction == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt "></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt "></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort "></i>
                                            @endif
                                        </div>
                                    </div>
                                </th>
                                <th {{-- Table header: Goal Average --}}
                                    class="cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider hidden md:table-cell"
                                    wire:click="order('average')">
                                    <div class="block sm:flex md:block lg:flex">
                                        +/-
                                        <div class="mx-auto sm:mr-0 md:mx-auto lg:mr-0">
                                            {{-- Sort icons --}}
                                            @if ($sort == 'average')
                                                @if ($direction == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt "></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt "></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort "></i>
                                            @endif
                                        </div>
                                    </div>
                                </th>
                                <th {{-- Table header: Points --}}
                                    class="cursor-pointer px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider"
                                    wire:click="order('points')">
                                    <div class="block sm:flex md:block lg:flex">
                                        Pts.
                                        <div class="mx-auto sm:mr-0 md:mx-auto lg:mr-0">
                                            {{-- Sort icons --}}
                                            @if ($sort == 'points')
                                                @if ($direction == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt "></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt "></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort "></i>
                                            @endif
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody> {{-- Table body --}}
                            @foreach ($teams as $item)

                                <tr class=" border-b border-gray-200 bg-white text-sm duration-300  hover:scale-95 hover:bg-gray-200 cursor-pointer"  wire:click="show({{$item}})">
                                    <td class="px-3 py-5 text-center">
                                        <p class="text-gray-900  whitespace-no-wrap">
                                            {{$item->position()}}
                                        </p>
                                    </td>
                                    <td class="px-3 py-5 ">
                                        <div class="block sm:flex md:block lg:flex items-center">
                                            <div class="  h-10 w-full sm:w-10 md:w-full lg:w-10">
                                                <img class="mx-auto sm:flex-shrink-0 md:mx-auto lg:flex-shrink-0 h-full "
                                                    
                                                    src="{{$item->emblem_photo}}"
                                                    alt="{{$item->name}}" />
                                            </div>
                                            <div class="sm:ml-3 md:ml-0 lg:ml-3">
                                                <p class="text-center sm:text-left md:text-center lg:text-left text-gray-900 whitespace-no-wrap">
                                                    {{$item->name}}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-5 ">
                                        <p class="text-gray-900 whitespace-no-wrap text-center">
                                            {{$item->num_games}}
                                        </p>
                                    </td>
                                    <td class="px-3 py-5  hidden md:table-cell">
                                        <p class="text-gray-900 whitespace-no-wrap text-center">
                                            {{$item->won}}
                                        </p>
                                    </td>
                                    <td class="px-3 py-5  hidden md:table-cell">
                                        <p class="text-gray-900 whitespace-no-wrap text-center">
                                            {{$item->draw}}
                                        </p>
                                    </td>
                                    <td class="px-3 py-5  hidden md:table-cell">
                                        <p class="text-gray-900 whitespace-no-wrap text-center">
                                            {{$item->lost}}
                                        </p>
                                    </td>
                                    <td class="px-3 py-5  hidden md:table-cell">
                                        <p class="text-gray-900 whitespace-no-wrap text-center">
                                            {{$item->goals}}
                                        </p>
                                    </td>
                                    <td class="px-3 py-5  hidden md:table-cell">
                                        <p class="text-gray-900 whitespace-no-wrap text-center">
                                            {{$item->against}}
                                        </p>
                                    </td>
                                    <td class="px-3 py-5  hidden md:table-cell">
                                        <p class="text-gray-900 whitespace-no-wrap text-center">
                                            {{$item->average}}
                                        </p>
                                    </td>
                                    <td class="px-3 py-5 ">
                                        <p class="text-gray-900 whitespace-no-wrap text-center">
                                            {{$item->points}}
                                        </p>
                                    </td>
                                </tr>
                            
                            @endforeach
                        
                        </tbody>
                    </table>
                </x-table>

                {{-- Pagination --}}
                @if($teams->hasPages())
                    <div class="sm:pl-4 pb-4">
                        {{$teams->links()}}
                    </div>
                @endif

                
            @else
               
                <x-alert-message type="danger">
                    <x-slot name="title">
                        The IT Academy League:
                    </x-slot> 
                        No teams found!
                </x-alert-message>
            @endif

        
    </div>

    {{-- Show Modal --}}
    <x-dialog-modal wire:model='open_show'>

        <x-slot name='title'>
            <p class="flex justify-center text-center">Show Team</p>
        </x-slot>

        {{-- Team Data --}}
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

                    {{-- games list --}}
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
                                        <td class=" px-3 py-5 border-b border-gray-200   text-xs sm:text-sm">
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
                                        <td class="px-3 py-5 border-b border-gray-200  text-xs sm:text-sm">
    
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
                                        <td class="px-3 py-5 border-b border-gray-200   text-xs sm:text-sm">
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

                <x-danger-button class="m-auto" wire:click="$set('open_show', false)">
                    Close
                </x-danger-button>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>