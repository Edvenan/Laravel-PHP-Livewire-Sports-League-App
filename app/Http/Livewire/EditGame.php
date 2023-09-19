<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Team;
use Livewire\Component;

class EditGame extends Component
{
    
    // var to control modal form
    public $open = false;

    public $game;
    public $locals;
    public $visitors;

    /**
     * Validation rules
     */
    protected $rules = [
        'game.team_1_id' => 'required|integer', // Add the validation rule here
        'game.team_2_id' => 'required|integer|different:game.team_1_id',
        'game.date' => 'required|date',
        'game.time' => 'required',
        'game.score_team_1' => 'integer|min:0',
        'game.score_team_2' => 'integer|min:0'
    ];

    /**
     * Dynamic input validation
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules);
    }

    public function mount(Game $game)
    {
        $this->game = $game;
        $this->getLocals();
        $this->getVisitors();

    }

    // Render function
    public function render()
    {
        return view('livewire.edit-game');
    }

   /**
    * Save updated Team function
    */
    public function save()
    {
        $this->validate();
        
        $this->game->save();

        $this->game->

        
        $this->reset(['open']);

        // dinamically renders the game list
        $this->emitTo('show-games', 'render');
        
        // Show alert
        $message = "Game (".$this->game->team_1->name." - ".$this->game->team_2->name.") updated successfully.";
        $this->emit('alert', 'Game updated!', $message);
    }

    /**
     * functions to avoid duplicate teams selection
     */
    public function updatedGameTeam1Id()
    {
        $this->getVisitors();
    }
    public function updatedGameTeam2Id()
    {
        $this->getLocals();
    }
    public function getVisitors()
    {
        if($this->game->team_1_id) {
            $this->visitors = Team::where('id', '!=', $this->game->team_1_id)->orderBy('name')->get();
        } else {
            $this->visitors = [];
        }
    }
    public function getLocals()
    {
        if($this->game->team_2_id) {
            $this->locals = Team::where('id', '!=', $this->game->team_2_id)->orderBy('name')->get();
        } else {
            $this->locals = [];
        }
    }
}
