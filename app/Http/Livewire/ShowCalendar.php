<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Livewire\Component;

class ShowCalendar extends Component
{
   
    public function render()
    {
        $games = Game::all();        
        return view('livewire.show-calendar', compact('games'));
    }

}
