<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;


class ShowGames extends Component
{
    use WithPagination;

    // vars to sort table by columns
    public $sort = 'date';
    public $direction = False;
    public $page = 1;
    
    // var to search games by teams
    public $search;

    // var to edit & delete games
    public $game, $locals, $visitors;

    // var to open modal
    public $open_edit = false;

    // var to chose pagination size
    public $items = 5;

    // var for Delayed loading
    public $readyToLoad = false;

    /**
     * Mount method to initialize vars used by view
     */
    public function mount()
    {
        $this->game = new Game();
        $this->locals = Team::all();
        $this->visitors = Team::all();
    }

    /*
     * Validation rules
     */
    protected $rules = [
        'game.team_1_id' => 'required|integer', // Add the validation rule here
        'game.team_2_id' => 'required|integer|different:game.team_1_id',
        'game.date' => 'required|date',
        'game.time' => 'required',
        'game.score_team_1' => 'nullable|integer|min:0',
        'game.score_team_2' => 'nullable|integer|min:0'
    ];


   /**
    * listeners
    */
    protected $listeners = ['render','delete'];
    

    /**
     * Dynamic input validation method
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules);
    }

    /**
     * ShowGames Component Render method
     */
    public function render()
    {
        if($this->readyToLoad){

            // get teams based on search bar
            $searchedTeamIds = Team::where('name', 'like', '%'.$this->search.'%')->pluck('id');

            // sort searched teams based on user chosen sorting criteria
            $games =  Game::whereIn('team_1_id', $searchedTeamIds)
                            ->orWhereIn('team_2_id', $searchedTeamIds)->get()
                            ->sortBy($this->sort, SORT_REGULAR, $this->direction);
            
            // paginate sorted resutls                        
            // $this->items  = Number of items to display per page
            $currentPage = request()->get('page', 1); // Current page number
            $paginatedItems = $games->slice(($this->page - 1) * $this->items, $this->items);
            $pagination = new LengthAwarePaginator(
                $paginatedItems,
                $games->count(),
                $this->items,
                $this->page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            $games = $pagination;
        
        }
        else {
            $games = 'loading';
        }
        
        return view('livewire.show-games', compact('games'));
    }

    /**
     * Delayed Loading function
     */
    public function loadGames()
    {
        $this->readyToLoad = true;
    }


    // Sort Game table by columns method
    public function order($sort){

        if ($this->sort == $sort) {
            if ($this->direction == True) {
                $this->direction = False;
            } else {
                $this->direction = True;
            }
        } else {
            $this->sort = $sort;
            $this->direction = False;
        }

        $this->page = 1;
        $this->resetPage();
    }

    /**
     * Edit Game method
     */
    public function edit(Game $game)
    {
        $this->game = $game;
        $this->getLocals();
        $this->getVisitors();
        $this->open_edit = true;
    }

    /**
     * Update Edited Game method
     */
    public function update()
    {
        $this->validate();
        
        if($this->game->update_statistics('edit')){
         
            $this->game->save();

            $this->reset(['open_edit']);

            // Show alert
            $message = "Game (".$this->game->team_1->name." - ".$this->game->team_2->name.") updated successfully.";
            $this->emit('alert', 'Game updated!', $message, 'success');
        } else {
            // something went wrong -> no action taken
        }
    }

    /**
     * Delete Game method
     */
    public function delete(Game $game)
    {
        $this->game = $game;

        if($this->game->update_statistics('delete')){
            $this->game->delete();
            // Show alert
            $message = "Game (".$this->game->team_1->name." - ".$this->game->team_2->name.") deleted successfully.";
            $this->emit('alert', 'Game deleted!', $message, 'success');
        } else {
            // something went wrong -> no action taken
        } 
    }

    /**
     * Function to eliminate page # from search bar and
     * allow full search even when paginating
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * functions to avoid duplicate teams selection
     * when using 'select' elements in Create/Edit games
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
