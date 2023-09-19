<div>
    {{-- Create Game button --}}
    <x-danger-button class="text-xs shadow-lg" wire:click="$set('open', true)">
        Create Game
    </x-danger-button>

    <x-dialog-modal wire:model='open'>

        <x-slot name='title'>
            <p class="text-center">Create Game</p>
        </x-slot>

        <x-slot name='content'>

            <div class="flex flex-col items-center      sm:items-stretch">
                {{-- teams selection --}}
                <div class="flex flex-row mb-4      sm:flex-col">

                    {{-- labels --}}
                    <div class="flex flex-col text-right justify-between py-2      sm:flex-row sm:px-16">
                        <x-label for='localId' value="Local Team:" />
                        <x-label for='visitorId' value="Visitor Team:" />
                    </div>

                    <div class="flex flex-col justify-between ml-4      sm:flex-row sm:ml-0 ">
                       {{-- team  1  --}}
                        <div class="flex flex-col space-y-1       sm:flex-row sm:space-y-0 sm:space-x-8">

                            <select class="w-52 text-sm rounded-lg border-gray-300 shadow-lg" id='localId' wire:model='localId'>
                                <option value="">Select local team</option>
                                @foreach($locals as $local)
                                    <option value="{{$local->id}}"  data-select-icon="{{$local->emblem_photo}}">{{$local->name}}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-1 ml-4 text-xs" for='localId'/>
                        
                        </div>

                        {{-- team  2  --}}
                        <div class="flex flex-col space-y-1  mt-2 sm:mt-0    sm:flex-row sm:space-y-0 sm:space-x-8">

                            <select class="w-52 text-sm rounded-lg border-gray-300 shadow-lg" id='visitorId' wire:model='visitorId'>
                                <option value="">Select visitor team</option>
                                @foreach($visitors as $visitor)
                                    <option value="{{$visitor->id}}" data-select-icon="{{$visitor->emblem_photo}}">{{$visitor->name}}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-1 ml-4 text-xs" for='visitorId'/>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-4 mb-4 text-center sm:justify-between sm:w-full">
                    {{-- Game Date --}}
                    <div class="ml-4      sm:ml-0">
                        <x-label for='date' value="Game Date:" />
                        <x-input class="text-sm" id="date" type="date" wire:model="date"/>
                        <x-input-error class="mt-1 text-xs" for='date'/>
                    </div>
                    {{-- Game Time --}}
                    <div class="">
                        <x-label for='time' value="Game Time:" />
                        <x-input class=" text-sm" id="time" type="time" wire:model="time"/>
                        <x-input-error class="mt-1 text-xs" for='time'/>
                    </div>
                </div>
            </div>    
        </x-slot>

        <x-slot name='footer'>
            <x-secondary-button wire:click="$set('open', false)">
                Cancel
            </x-secondary-button>

            <x-danger-button class="ml-4" wire:click="save" wire:loading.remove wire:target="save">
                Create Game
            </x-danger-button>

            <x-danger-button class="ml-4" wire:loading wire:target="save">Saving...</x-danger-button>

        </x-slot>

    </x-dialog-modal>
</div>
