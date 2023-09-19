<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Livewire\Component;
use Livewire\WithPagination;

class ShowRanking extends Component
{
    use WithPagination;

    // vars to sort table by columns
    public $sort = 'position';
    public $direction = 'asc';
    public $page = 1; // used to show sort results from page 1

    // var to launch show modal
    public $open_show = false;

    // var to contain team info
    public $team;

    // var for search bar
    public $search;

    // var to chose pagination size
    public $items = 5;




    // function to initialize team object
    public function mount()
    {
        $this->team = New Team();
    }


    /**
     * Ranking render function
     */
    public function render()
    {

        
            if($this->sort=='position'){
                if($this->direction == 'asc')
                    $teams = Team::
                    where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('stadium', 'like', '%'.$this->search.'%')
                    ->orWhere('foundation_year', 'like', '%'.$this->search.'%')
                
                    ->orderBy('points', 'desc')->orderBy('num_games', 'asc')
                    ->orderBy('average', 'desc')
                    ->orderBy('against', 'asc')
                    ->orderBy('name', 'asc')
                    ->select('*');
                else{
                    $teams = Team::
                    where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('stadium', 'like', '%'.$this->search.'%')
                    ->orWhere('foundation_year', 'like', '%'.$this->search.'%')
                
                    ->orderBy('points', 'asc')->orderBy('num_games', 'desc')
                    ->orderBy('average', 'asc')
                    ->orderBy('against', 'desc')
                    ->orderBy('name', 'desc')
                    ->select('*');

                    
                }
            }
            else{
                $opposite_dir = $this->direction == 'asc' ? 'desc' : 'asc';
                $teams = Team::
                where('name', 'like', '%'.$this->search.'%')
                ->orWhere('stadium', 'like', '%'.$this->search.'%')
                ->orWhere('foundation_year', 'like', '%'.$this->search.'%')
                
                ->orderBy($this->sort, $this->direction)
                
                ->orderBy('num_games',  $opposite_dir)
                ->orderBy('average', $this->direction )
                ->orderBy('against', $opposite_dir)
                ->orderBy('name', $this->direction)
                ->select('*');
            }
                                
            $teams = $teams->paginate($this->items, ['*'], 'page', $this->page);
        

        return view('livewire.show-ranking',compact('teams'));
    }


    // function to sort table by columns
    public function order($sort){

        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
        $this->page = 1;
        $this->resetPage();
    }

    /**
     * Show Team method
     */
    public function show(Team $team)
    {
        $this->team = $team;

        $this->open_show = true;
    }

}
