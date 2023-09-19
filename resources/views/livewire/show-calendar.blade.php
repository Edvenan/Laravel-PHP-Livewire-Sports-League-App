<div>

    {{-- Calendar header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center text-gray-800 leading-tight">
            {{ __('League Calendar') }}
        </h2>
    </x-slot>


    <!-- Calendar -->
    <div>
        {{-- Convert games to events --}}
        @php
            $events = [];
            $colors = ['blue', 'red', 'yellow', 'purple', 'green'];
            foreach ($games as $item){
                    $event =[
                        'event_title' => $item->team_1->name."<br>-<br>".$item->team_2->name,
                        'event_team1' => $item->team_1->name,
                        'event_team2'=> $item->team_2->name,
                        'event_score1'=> $item->score_team_1,
                        'event_score2'=> $item->score_team_2,
                        'event_date' => $item->date,
                        'event_time' => $item->time,
                        'event_theme' => $colors[array_rand($colors)],
                        'event_stadium' => $item->team_1->stadium,
                        'event_id' => $item->id,
                        'event_logo1' => $item->team_1->emblem_photo,
                        'event_logo2' => $item->team_2->emblem_photo,
                    ];
                    $events[] = $event;
            }
        @endphp

        <div x-data="app()" x-init="[initDate(), getNoOfDays()]" class="max-w-7xl mx-auto px-1 sm:px-4 md:px-6 lg:px-8 sm:mt-8" >
            <div class="container mx-auto px-1 sm:px-4 py-2 ">
                <div class="bg-white  rounded-lg shadow-lg overflow-hidden">
                    
                    {{-- Calendar Header --}}
                    <div class="flex w-full  py-2 px-2 sm:px-6 ">
                        {{-- show current Month and Year --}}
                        <div class="flex ml-0 pt-1.5" >
                            <span x-text="MONTH_NAMES[month]" class="w-[90px] text-right text-lg  font-bold text-gray-800"></span>
                            <span x-text="year" class="ml-1 text-lg text-blue-600 font-bold"></span>
                        </div>

                        {{-- button to go to this today --}}
                        <div class="mx-auto pt-1.5">
                            <span class="text-lg border-2 border-gray-100 rounded-lg px-2 py-2 font-bold text-gray-500 cursor-pointer hover:bg-gray-200" 
                            @click="initDate();  getNoOfDays();">
                                Today</span>
                        </div>
                        
                        {{-- buttons to change month --}}
                        <div class="flex items-center">
                            <div class="border rounded-lg px-1" style="padding-top: 2px;">
                                <button 
                                    type="button"
                                    class="leading-none rounded-lg transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 items-center" 
                                    @click="month = (month-1 == -1) ? 11 : month-1; year = (month == 11) ? year-1 : year; getNoOfDays();">
                                    <svg class="h-6 w-6 text-gray-500 inline-flex leading-none"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>  
                                </button>
                                <div class="border-r inline-flex h-6"></div>		
                                <button 
                                    type="button"
                                    class="leading-none rounded-lg transition ease-in-out duration-100 inline-flex items-center cursor-pointer hover:bg-gray-200 p-1" 
                                    @click="month = (month+1 == 12) ? 0 : month+1; year = (month == 0) ? year+1 : year; getNoOfDays();">
                                    <svg class="h-6 w-6 text-gray-500 inline-flex leading-none"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>									  
                                </button>
                            </div>
                        </div>
                    </div>	

                    {{-- Week days Header --}}
                    <div class="-mx-1 -mb-1 flex flex-wrap rounded-lg ">
                        <template x-for="(day, index) in DAYS" :key="index" class="border-b-4 border-gray-200" >	
                            <div style="width: 14.28%" class=" px-3 py-3 border-b-4 border-gray-200 bg-gray-700 text-center text-xs font-semibold text-gray-100 uppercase tracking-wide">
                                <div
                                    x-text="day" 
                                    class=" font-bold text-center">
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Calendar Body --}}
                    <div class="-mx-1 -mb-1">
                        {{-- print all days --}}
                        <div class="flex flex-wrap border-t border-l px-1">
                            {{-- print blankdays --}}
                            <template x-for="blankday in blankdays">
                                <div class = "w-[14.28%] h-[90px] sm:h-[120px] text-center border-r border-b px-4 pt-2   ">
                                </div>
                            </template>	
                            {{-- print no blankdays --}}
                            <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">	
                                <div class = "w-[14.28%] h-[90px] sm:h-[120px] sm:px-4 pt-2 border-r border-b relative ">
                                    
                                    {{-- Today Highlighter --}}
                                    <div
                                        x-text="date"
                                        class="inline-flex w-6 h-6 items-center justify-center text-center leading-none rounded-full transition ease-in-out duration-100"
                                        :class="{'bg-blue-500 text-white': isToday(date) == true, 'text-gray-700 /*hover:bg-blue-200*/': isToday(date) == false }"">
                                    </div>
                                    
                                    {{-- print games in calendar --}}
                                    <div class="h-[60px] sm:h-[90px] overflow-y-auto mt-0.5  ">
                                        <template x-for="event in events.filter(e => new Date(e.event_date).toDateString() ===  new Date(year, month, date).toDateString() )">
                                            <div @click="showEventModal(event)" class="sm:px-2 sm:py-1 rounded-lg  overflow-hidden border-2 cursor-pointer" :class="{
                                                    'border-blue-200 text-blue-800 hover:bg-blue-100': event.event_theme === 'blue',
                                                    'border-red-200 text-red-800 hover:bg-red-100': event.event_theme === 'red',
                                                    'border-yellow-200 text-yellow-800 hover:bg-yellow-100': event.event_theme === 'yellow',
                                                    'border-green-200 text-green-800 hover:bg-green-100': event.event_theme === 'green',
                                                    'border-purple-200 text-purple-800 hover:bg-purple-100': event.event_theme === 'purple'
                                                }">
                                                {{-- Team1 - Team2 --}} 
                                                <div class='h-[20px] sm:h-[28px] flex justify-center'>
                                                    <img class="h-5 w-5 sm:h-7 sm:w-7" x-bind:src="event.event_logo1" alt="Image">
                                                    <span class="my-auto text-xs">-</span>
                                                    <img class="h-5 w-5 sm:h-7 sm:w-7" x-bind:src="event.event_logo2" alt="Image">
                                                </div>
                                            </div>
                                        </template>
                                    </div>

                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>


        <!-- Game Details Modal -->

            <div style=" background-color: rgba(0, 0, 0, 0.8)" class=" fixed z-40 top-0 right-0 left-0 bottom-0 h-full w-full" x-cloak x-show.transition.opacity="openEventModal">
                <div class="p-4 max-w-xl mx-auto  absolute left-0 right-0 overflow-hidden mt-24">
                    <div class="shadow absolute right-0 top-0 w-10 h-10 rounded-full bg-white text-gray-500 hover:text-gray-800 inline-flex items-center justify-center "
                        x-on:click="openEventModal = !openEventModal">
                        <svg class="fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M16.192 6.344L11.949 10.586 7.707 6.344 6.293 7.758 10.535 12 6.293 16.242 7.707 17.656 11.949 13.414 16.192 17.656 17.606 16.242 13.364 12 17.606 7.758z" />
                        </svg>
                    </div>

                    <div class="shadow  rounded-lg bg-white overflow-hidden w-full block p-8">
                        
                        <h2 class="font-bold text-2xl text-center mb-6 text-gray-800 border-b pb-2">Game Details</h2>
                    
                        <div class="flex mb-4 mx-auto align-middle  justify-center">
                            <div class="w-1/3 flex flex-col  items-center  justify-start   ">
                                <img class="h-10 w-10 sm:h-28 sm:w-28" x-bind:src="event_logo1" alt="Image">
                                <span class="w-full text-sm sm:text-lg text-center font-bold flex-wrap border-white  mt-2 sm:py-2 sm:px-4 text-gray-900  leading-tight "
                                x-text="event_team1">                                               
                            </div>
                            <strong class="mt-2 sm:my-auto font-bold sm:text-5xl" x-text="event_score1"></strong>
                            <span class="mt-2 sm:my-auto px-4">-</span>
                            <strong class="mt-2 sm:my-auto font-bold sm:text-5xl" x-text="event_score2"></strong>
                            
                            <div class="w-1/3 flex flex-col items-center justify-start">
                                <img class="h-10 w-10 sm:h-28 sm:w-28" x-bind:src="event_logo2" alt="Image">
                                <span class="w-full text-sm sm:text-lg text-center font-bold flex-wrap border-white  mt-2 sm:py-2 sm:px-4 text-gray-900  leading-tight "
                                x-text="event_team2"> 
                            </div>
                        </div>

                        <div class = "flex flex-row justify-between">
                            <div class="mb-4 mr-1">
                                <label class="text-gray-800 block mb-1 font-bold text-xs sm:text-sm tracking-wide">Event date</label>
                                <input class="bg-gray-200 text-xs sm:text-lg appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-1 sm:px-4 text-center text-gray-700 " type="text" 
                                        x-model="event_date" readonly>
                            </div>
                            <div class="mb-4 ml-1">
                                <label class="text-gray-800 block mb-1 font-bold text-xs sm:text-sm tracking-wide">Event time</label>
                                <input class="bg-gray-200 text-xs sm:text-lg appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-1 sm:px-4 text-center text-gray-700 " type="text" 
                                        x-model="event_time" readonly>
                            </div>
                        </div>

                        <div class="flex flex-col mb-4 mx-auto align-middle">
                            <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">Stadium</label>
                            <input class="bg-gray-200 text-xs sm:text-lg border-2 border-gray-200 rounded-lg text-center w-full py-2 px-4 text-gray-700 " type="text" 
                                    x-model="event_stadium" readonly>
                        </div>
    
                    </div>
                </div>
            </div>
            <!-- /Modal -->
        </div>
    </div>

    <script>
        var eventsData = <?php echo json_encode($events); ?>;
        const MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        function app() {
            return {
                openEventModal: false,
                month: '',
                year: '',
                no_of_days: [],
                blankdays: [],
                days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                events: eventsData,
                event_title: '',
                event_date: '',
                event_time: '',
                event_stadium: '',
                event_logo1: '',
                event_logo2: '',
                event_team1: '',
                event_team2: '',
                event_score1: '',
                event_score2: '',
                event_theme: 'blue',

                themes: [
                    {
                        value: "blue",
                        label: "Blue Theme"
                    },
                    {
                        value: "red",
                        label: "Red Theme"
                    },
                    {
                        value: "yellow",
                        label: "Yellow Theme"
                    },
                    {
                        value: "green",
                        label: "Green Theme"
                    },
                    {
                        value: "purple",
                        label: "Purple Theme"
                    }
                ],

                

                initDate() {
                    let today = new Date();
                    this.month = today.getMonth();
                    this.year = today.getFullYear();
                    this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
                },

                isToday(date) {
                    const today = new Date();
                    const d = new Date(this.year, this.month, date);

                    return today.toDateString() === d.toDateString() ? true : false;
                },

                showEventModal(event) {
                    // open the modal
                    this.openEventModal = true;
                    this.event_date = new Date(event.event_date).toDateString();
                    this.event_time = event.event_time;
                    this.event_stadium = event.event_stadium;
                    this.event_title = event.event_title;
                    this.event_logo1 = event.event_logo1;
                    this.event_logo2 = event.event_logo2;
                    this.event_team1 = event.event_team1;
                    this.event_team2 = event.event_team2;
                    this.event_score1 = event.event_score1;
                    this.event_score2 = event.event_score2;
                },

                addEvent() {
                    if (this.event_title == '') {
                        return;
                    }

                    this.events.push({
                        event_date: this.event_date,
                        event_title: this.event_title,
                        event_theme: this.event_theme
                    });

                    console.log(this.events);

                    // clear the form data
                    this.event_title = '';
                    this.event_date = '';
                    this.event_theme = 'blue';

                    //close the modal
                    this.openEventModal = false;
                },

                getNoOfDays() {
                    let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

                    // find where to start calendar day of week
                    let dayOfWeek = new Date(this.year, this.month).getDay();
                    let blankdaysArray = [];
                    for ( var i=1; i <= dayOfWeek; i++) {
                        blankdaysArray.push(i);
                    }

                    let daysArray = [];
                    for ( var i=1; i <= daysInMonth; i++) {
                        daysArray.push(i);
                    }
                    
                    this.blankdays = blankdaysArray;
                    this.no_of_days = daysArray;
                }
            }
        }
    </script>
        
</div>