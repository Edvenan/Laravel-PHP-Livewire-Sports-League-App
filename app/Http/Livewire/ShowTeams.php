<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Livewire\Component;
use Illuminate\Validation\Rule;

class ShowTeams extends Component
{
    
    // listeners
    protected $listeners = ['render', 'delete'];
 
    // var to search teams
    public $search;
    
    // var to edit & delete teams
    public $team;

    // var to open modal
    public $open_edit = false;
    public $open_show = false;
    

    /**
     * Mount method to initialize vars used by view
     */
    public function mount()
    {
        $this->team = new Team();
    }

    /**
     * Validation rules method that takes into account
     * those fields with 'unique' property
     */
     protected function rules()
     {
         return [
             'team.name' => [
                 'required',
                 'string',
                 'min:2',
                 Rule::unique('teams', 'name')->ignore($this->team->id),
             ],
             'team.foundation_year' => 'required|integer|min:1850|max:2023',
             'team.stadium' => [
                 'required',
                 'string',
                 Rule::unique('teams', 'stadium')->ignore($this->team->id),
             ],
             'team.emblem_photo' => 'nullable|url',
         ];
     }

    /**
     * Dynamic input validation method
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules());
    }

    // var for Delayed loading
    public $readyToLoad = false;

    /**
     * ShowTeams Component Render method
     */
    public function render()
    {
        if($this->readyToLoad){
            $teams =  Team::where('name', 'like', '%'.$this->search.'%')
                            ->orWhere('stadium', 'like', '%'.$this->search.'%')
                            ->orWhere('foundation_year', 'like', '%'.$this->search.'%')
                            ->orderBy('name','asc')->get();
        }
        else {
            $teams = 'loading';
        }
        return view('livewire.show-teams', compact('teams'));
    }

    /**
     * Delayed Loading function
     */
    public function loadTeams()
    {
        $this->readyToLoad = true;
    }

    /**
     * Show Team method
     */
    public function show(Team $team)
    {
        $this->team = $team;

        $this->open_show = true;
    }

    /**
     * Edit Team method
     */
    public function edit(Team $team)
    {
        $this->reset(['open_show']);
        $this->team = $team;
        $this->open_edit = true;
    }

    /**
     * Update Edited Team method
     */
    public function update()
    {
        $this->validate();
        
        $this->team->save();

        $this->reset(['open_edit']);

        // Show alert
        $message = "Team (".$this->team->name.") updated successfully.";
        $this->emit('alert', 'Team updated!', $message, 'success');

        $this->open_show = true;
    }


    /**
     * Delete Destroyed Game method
     */
    public function delete(Team $team)
    {
        $this->team = $team;

        $this->team->update_statistics();

        $this->team->delete();
        
        $this->reset(['open_show']);

        // Show alert
        $message = "Team (".$this->team->name.") deleted successfully.";
        $this->emit('alert', 'Team deleted!', $message, 'success');
    }

    /**
     * Cancel Edit Team method
     */
    public function cancel()
    {
        $this->reset(['open_edit']);
        $this->open_show = true;
    }

}
