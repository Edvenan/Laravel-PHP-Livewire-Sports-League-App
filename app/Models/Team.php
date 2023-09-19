<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ 
        'name',
        'foundation_year',
        'stadium',
        'emblem_photo',
        'points',
        'num_games',
        'won',
        'draw',
        'lost',
        'goals',
        'against',
        'average'
    ];

    /**
     * The attributes that are ignored when mass assigning.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Method to get all the team's games
     * ordered by date
     */
    // 
    public function games(){
        $games = Game::where('team_1_id', $this->id)->orWhere('team_2_id', $this->id)->orderBy('date', 'asc')->get();
        return $games;
    }

    /**
     * Method to get the team's rank or position in the league
     *
     */
    // 
    public function position(){
        $teams = Team::
            orderBy('points', 'desc')
            ->orderBy('num_games', 'asc')
            ->orderBy('average', 'desc')
            ->orderBy('against', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        $position = 1;
        foreach ($teams as $team) {
            if ($this->id == $team->id){
                break;
            } else {
                $position += 1;
            }
        }
        return $position;
    }

    /**
     * Updates Adversary Team Statistics
     * after team's deletion
     */
    public function update_statistics()
    {
        foreach($this->games() as $game) {

            // determine rival's id
            if($game->team_1_id == $this->id) {
                $rival_id = $game->team_2_id;
                $rival_score = $game->score_team_2;
                $deleted_team_score = $game->score_team_1;
            } else{
                $rival_id = $game->team_1_id;
                $rival_score = $game->score_team_1;
                $deleted_team_score = $game->score_team_2;
            }
            // get rival's object
            $rival = Team::find($rival_id);

            if($game->score_team_1 && $game->score_team_2){
                // game was played and there is a score
                if($deleted_team_score > $rival_score){
                    // deleted team won
                    $rival->against -= $deleted_team_score;
                    $rival->goals -= $rival_score;
                    $rival->average =  $rival->goals - $rival->against;
                    $rival->lost -= 1;
                    $rival->won -= 0;
                    $rival->draw -= 0;
                    $rival->num_games -=1;
                    $rival->points += 0;
                }
                elseif($deleted_team_score < $rival_score){
                    // deleted team lost
                    $rival->against -= $deleted_team_score;
                    $rival->goals -= $rival_score;
                    $rival->average =  $rival->goals - $rival->against;
                    $rival->lost -= 0;
                    $rival->won -= 1;
                    $rival->draw -= 0;
                    $rival->num_games -=1;
                    $rival->points -= 3;
                }
                elseif($deleted_team_score == $rival_score){
                    // deleted team draw
                    $rival->against -= $deleted_team_score;
                    $rival->goals -= $rival_score;
                    $rival->average =  $rival->goals - $rival->against;
                    $rival->lost -= 0;
                    $rival->won -= 0;
                    $rival->draw -= 1;
                    $rival->num_games -=1;
                    $rival->points -= 1;
                }

                $rival->save();

            }
            else{
                // game not played yet -> just delete team
                continue;
            }
        }

    }

}
