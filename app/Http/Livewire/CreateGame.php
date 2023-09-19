<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Team;
use Livewire\Component;

class CreateGame extends Component
{
    // var to control modal form
    public $open = false;

    // vars to create new game
    public $date, $time;    
    // vars to control dependant dropdown
    public $locals;
    public $localId;
    public $visitorId;
    public $visitors;

    
    protected $rules = [
        'localId' => 'required|integer', // Add the validation rule here
        'visitorId' => 'required|integer',
        'date' => 'required|date',
        'time' => 'required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->locals = Team::orderBy('name')->get();
        $this->getVisitors();
    }

    public function render()
    {
        return view('livewire.create-game');
    }

    public function updatedLocalId()
    {
        $this->getVisitors();
    }

    public function getVisitors()
    {
        if($this->localId !='') {
            $this->visitors = Team::where('id', '!=', $this->localId)->orderBy('name')->get();
        } else {
            $this->visitors = [];
        }
    }

    // function to save new game
    public function save()
    {

        $this->validate();

        $new_game= Game::create([
            'team_1_id' => $this->localId,
            'team_2_id' => $this->visitorId,
            'date' => $this->date,
            'time' => $this->time
        ]);

        $message = "New game (".$new_game->team_1->name." - ".$new_game->team_2->name.") created successfully.";

        $this->reset(['open', 'localId', 'visitorId', 'date', 'time']);

        // dinamically renders the game list
        $this->emitTo('show-games', 'render');
        $this->emit('alert', 'Game created!', $message);

    }
}
