<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Livewire\Component;


class CreateTeam extends Component
{
    
    // var to control modal form
    public $open = false;

    // vars to create team
    public $name, $foundation_year, $stadium, $emblem_photo;

    /**
     * Validation rules
     */
    protected $rules = [
        'name' => 'unique:\App\Models\Team,name|required|string|min:2', // Add the validation rule here
        'foundation_year' => 'required|integer|min:1850|max:2023',
        'stadium' => 'unique:\App\Models\Team,stadium|required|string',
        'emblem_photo' => 'nullable|url',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.create-team');
    }

    public function save()
    {
        
        $this->validate();

        if($this->emblem_photo=="") {
            /* $this->emblem_photo = "https://upload.wikimedia.org/wikipedia/commons/0/0a/Football_Image_Logo.png"; */
            $this->emblem_photo = "https://www.multilac.com/uploads/projects/noimage.png";
        }

        Team::create([
            'name' => $this->name,
            'foundation_year' => $this->foundation_year,
            'stadium' => $this->stadium,
            'points' => 0,
            'emblem_photo' => $this->emblem_photo,
            'num_games' => 0,
            'won' => 0,
            'draw' => 0,
            'lost' => 0,
            'goals' => 0,
            'against' => 0,
            'average' => 0
        ]);

        $message = "New team '".$this->name."' created successfully.";

        // Reset the form and close the modal

        $this->reset(['open', 'name', 'foundation_year', 'stadium', 'emblem_photo']);


        // dinamically renders the game list
        $this->emitTo('show-teams','render');
        $this->emit('alert',"Team Created!", $message);

    
    }

}




