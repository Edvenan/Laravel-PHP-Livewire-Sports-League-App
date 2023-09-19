<div>
    <div class="flex flex-auto px-1 py-4 space-x-2">
        <a class="btn btn-blue " wire:click="$set('open', true)">
            <i class="fas fa-edit"></i>
        </a>

        <a class="btn btn-red" wire:click="$set('open', true)">
            <i class="fa-solid fa-trash"></i>
        </a>
    </div>

    <x-dialog-modal wire:model='open'>

        <x-slot name='title'>
            Edit Game:
            <span class="ml-12 text-sm text-blue-500">{{$game->team_1->name}} - {{$game->team_2->name}}</span>
        </x-slot>

        <x-slot name='content'>
            {{-- teams selection --}}
            <div class="flex justify-between">
                {{-- team 1 --}}
                <div class="mb-4 ml-4">
                    <x-label for='localId' value="Local Team:" />
                    <select class="w-52 text-sm rounded-lg border-gray-300 shadow-lg" id='localId' wire:model='game.team_1_id'>
                        {{-- <option value="{{$game->team_1_id}}">{{$game->team_1->name}}</option> --}}
                        @foreach($locals as $local)
                            <option value="{{$local->id}}" {{ $game->team_1_id == $local->id ? 'selected' : '' }}>{{$local->name}}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-1 text-xs" for='localId'/>
                </div
                {{-- score --}}>
                <div class="">
                    <x-label class="text-center" value="Score" />
                    <x-input class="w-16 px-1 text-center text-sm" id="score_team_1" type="number" min="0" onkeydown="return false" wire:model="game.score_team_1"/>
                    <span class="mx-1">-</span>
                    <x-input class="w-16 px-1 text-center text-sm" id="score_team_2" type="number" min="0" onkeydown="return false" wire:model="game.score_team_2"/>
                    <x-input-error class="mt-1 text-xs" for='score_team_1'/>
                    <x-input-error class="mt-1 text-xs" for='score_team_2'/>
                </div>
                {{-- team 2 --}}
                <div class="mb-4 ">
                    <x-label for='visitorId' value="Visitor Team:" />
                    <select class="w-52 text-sm rounded-lg border-gray-300 shadow-lg" id='visitorId' wire:model='game.team_2_id'>
                        @foreach($visitors as $visitor)
                            <option value="{{$visitor->id}}" {{ $game->team_2_id == $visitor->id ? 'selected' : '' }}>{{$visitor->name}}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-1 text-xs" for='visitorId'/>
                </div>
            </div>
            
            <div class="flex justify-between">
                {{-- Game Date --}}
                <div class="mb-4 ml-4">
                    <x-label for='date' value="Game Date:" />
                    <x-input class=" text-sm" id="date" type="date" wire:model="game.date"/>
                    <x-input-error class="mt-1 text-xs" for='date'/>
                </div>
                {{-- Game Time --}}
                <div class="mb-4 ">
                    <x-label for='time' value="Game Time:" />
                    <x-input class=" text-sm" id="time" type="time"  wire:model="game.time"/>
                    <x-input-error class="mt-1 text-xs" for='time'/>
                </div>
            </div>

        </x-slot>

        <x-slot name='footer'>
            <x-secondary-button wire:click="$set('open', false)">
                Cancel
            </x-secondary-button>

            <x-danger-button class="ml-4" wire:click="save" wire:loading.remove wire:target="save">
                Update Game
            </x-danger-button>

            <x-danger-button class="ml-4" wire:loading wire:target="save">Updating...</x-danger-button>

        </x-slot>

    </x-dialog-modal>

</div>
