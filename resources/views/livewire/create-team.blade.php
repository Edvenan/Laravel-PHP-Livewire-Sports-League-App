<div>
    {{-- Create Team button --}}
    <x-danger-button class="shadow-lg" wire:click="$set('open', true)">
        Create Team
    </x-danger-button>

    <x-dialog-modal wire:model='open'>

        <x-slot name='title'>
            <p class="text-center">Create New Team</p>
        </x-slot>


        <x-slot name='content'>
            <div class="flex flex-col items-center     sm:block">
                <div class="flex flex-col sm:flex-row ">
                    {{-- team name  --}}
                    <div class="mb-4 flex-1">
                        <x-label for='name' value="Team name:" />
                        <x-input class="ml-4  text-sm" type="text" id='name' wire:model='name'/>
                        <x-input-error class="mt-1 ml-4 text-xs" for='name'/>

                    </div>
                    {{-- team foundation year --}}
                    <div class="mb-4 flex-1">
                        <x-label for='foundation_year' value="Foundation Year:" />
                        <x-input class="ml-4  text-sm" type="number" id='foundation_year' max="2023" min="1850" wire:model='foundation_year'/>
                        <x-input-error class="mt-1 ml-4 text-xs" for='foundation_year'/>
                        
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row">
                    {{-- Team Stadium --}}
                    <div class="mb-4 flex-1">
                        <x-label for='stadium' value="Stadium:" />
                        <x-input class="ml-4  text-sm" id="stadium" type="text" wire:model="stadium"/>
                        <x-input-error class="mt-1 ml-4 text-xs" for='stadium'/>
                        
                    </div>
                    {{-- Team Emblem --}}
                    <div class="mb-4 flex-1">
                        <x-label for='emblem_photo' value="Team Emblem (url):" />
                        <x-input class="ml-4 sm:w-72   text-sm" id="emblem_photo" type="url" wire:model="emblem_photo"/>
                        <x-input-error class="mt-1 ml-4 text-xs" for='emblem_photo'/>
                    </div>
                </div>
            </div>
        </x-slot>




        <x-slot name='footer'>
            <x-secondary-button wire:click="$set('open', false)">
                Cancel
            </x-secondary-button>

            <x-danger-button class="ml-4" wire:click="save" wire:loading.remove wire:target="save">
                Create Team
            </x-danger-button>

            <x-danger-button class="ml-4" wire:loading wire:target="save">Saving...</x-danger-button>
        </x-slot>

    </x-dialog-modal>
</div>
