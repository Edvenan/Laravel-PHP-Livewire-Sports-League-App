<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_1_id',
        'team_2_id',
        'date',
        'time',
        'score_team_1',
        'score_team_2',
    ];

    /**
     * The attributes that are ignored when mass assigning.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Method that retrieves team_1's data
     *
     */
    public function team_1(){
        // Teams table Class - Teams Foreign Key name - Games table foreign key
        return $this->hasOne('App\Models\Team', 'id', 'team_1_id');
    }

    /**
     * Method that retrieves team_2's data
     *
     */
    public function team_2(){
        // Teams table Class - Teams Foreign Key name - Games table foreign key
        return $this->hasOne('App\Models\Team', 'id', 'team_2_id');
    }


    /**
     * Team Statistics update after
     * teams edition/deletion
     */
    public function update_statistics($action)
    {
        
        // Delete Game action
        if($action == 'delete'){

            // delete game with a score ( game was played )
            if(isset($this->score_team_1) && isset($this->score_team_2)){
               
                // undo original game statistics for old team_1 and old team_2
                $this->undo_old_game_statistics();
            }
            // else, delete game w/o score -> just delete game
        }
        // Edit Game with score action
        elseif ($action == 'edit' && isset($this->score_team_1) && isset($this->score_team_2)){

            //check wether there was a score or not before editing
            $original_game = Game::find($this->id);

            // there was a score before
            if(isset($original_game->score_team_1) && isset($original_game->score_team_2)){

                // undo original game statistics for old team_1 and old team_2
                $this->undo_old_game_statistics();
            }

            // apply new game statistics for new team_1 and new team_2
            $this->apply_new_game_statistics();
        }
        // Edit Game w/o score action
        elseif ($action == 'edit' && (is_null($this->score_team_1) || is_null($this->score_team_2))){
            // game not played yet -> no statistics update required -> just edit the game
        }
        // else, raise error
        else {
            $this->emit('alert', 'Update failed!', 'Statistics update failed. No action taken.', 'error');
            return false;
        }
        // if success, return true
        return true;
    }

    /**
     * helper method to undo game statisitics
     * upon a game 'delete' or 'update' 
     */
    public function undo_old_game_statistics()
    {
        // undo old game statistics for old team_1 and old team_2
        
        //get original game object
        $original_game = Game::find($this->id);

        // get teams objects
        $team_1 = Team::find($original_game->team_1_id);
        $team_2 = Team::find($original_game->team_2_id);
       

        // original team_1 won before
        if($original_game->score_team_1 > $original_game->score_team_2){
            // original team_1 statistics
            $team_1->against -= $original_game->score_team_2;
            $team_1->goals -= $original_game->score_team_1 ;
            $team_1->average =  $team_1->goals - $team_1->against;
            $team_1->lost -= 0;
            $team_1->won -= 1;
            $team_1->draw -= 0;
            $team_1->num_games -= 1;
            $team_1->points -= 3;
            // team_2 statistics
            $team_2->against -= $original_game->score_team_1;
            $team_2->goals -= $original_game->score_team_2 ;
            $team_2->average =  $team_2->goals - $team_2->against;
            $team_2->lost -= 1;
            $team_2->won -= 0;
            $team_2->draw -= 0;
            $team_2->num_games -= 1;
            $team_2->points -= 0;
        }
        // original team_1 lost before
        elseif($original_game->score_team_1 < $original_game->score_team_2){
            // original team_1 statistics
            $team_1->against -= $original_game->score_team_2;
            $team_1->goals -= $original_game->score_team_1 ;
            $team_1->average =  $team_1->goals - $team_1->against;
            $team_1->lost -= 1;
            $team_1->won -= 0;
            $team_1->draw -= 0;
            $team_1->num_games -= 1;
            $team_1->points -= 0;
            // team_2 statistics
            $team_2->against -= $original_game->score_team_1;
            $team_2->goals -= $original_game->score_team_2 ;
            $team_2->average =  $team_2->goals - $team_2->against;
            $team_2->lost -= 0;
            $team_2->won -= 1;
            $team_2->draw -= 0;
            $team_2->num_games -= 1;
            $team_2->points -= 3;
        }
        // draw before
        elseif($original_game->score_team_1 == $original_game->score_team_2){
            // original team_1 statistics
            $team_1->against -= $original_game->score_team_2;
            $team_1->goals -= $original_game->score_team_1 ;
            $team_1->average =  $team_1->goals - $team_1->against;
            $team_1->lost -= 0;
            $team_1->won -= 0;
            $team_1->draw -= 1;
            $team_1->num_games -= 1;
            $team_1->points -= 1;
            // team_2 statistics
            $team_2->against -= $original_game->score_team_1;
            $team_2->goals -= $original_game->score_team_2 ;
            $team_2->average =  $team_2->goals - $team_2->against;
            $team_2->lost -= 0;
            $team_2->won -= 0;
            $team_2->draw -= 1;
            $team_2->num_games -= 1;
            $team_2->points -= 1;
        }
        // save updated teams statistics
        $team_1->save();
        $team_2->save();
    }

    /**
     * helper method to undo game statisitics
     * upon a game 'delete' or 'update' 
     */
    public function apply_new_game_statistics()
    {
        // apply new game statistics for new team_1 and new team_2
        
        //get original game object
        $new_game = $this;

        // get teams objects
        $team_1 = Team::find($new_game->team_1_id);
        $team_2 = Team::find($new_game->team_2_id);
       
         // new team_1 wins now
         if($new_game->score_team_1 > $new_game->score_team_2){
            // team_1 statistics
            $team_1->against += $new_game->score_team_2;
            $team_1->goals += $new_game->score_team_1;
            $team_1->average =  $team_1->goals - $team_1->against;
            $team_1->lost -= 0;
            $team_1->won += 1;
            $team_1->draw -= 0;
            $team_1->num_games += 1;
            $team_1->points += 3;
            // team_2 statistics
            $team_2->against += $new_game->score_team_1;
            $team_2->goals += $new_game->score_team_2;
            $team_2->average =  $team_2->goals - $team_2->against;
            $team_2->lost += 1;
            $team_2->won -= 0;
            $team_2->draw -= 0;
            $team_2->num_games += 1;
            $team_2->points -= 0;

        } 
        // team_1 loses now
        elseif($new_game->score_team_1 < $new_game->score_team_2){
            // team_1 statistics
            $team_1->against += $new_game->score_team_2;
            $team_1->goals += $new_game->score_team_1;
            $team_1->average =  $team_1->goals - $team_1->against;
            $team_1->lost += 1;
            $team_1->won += 0;
            $team_1->draw -= 0;
            $team_1->num_games += 1;
            $team_1->points += 0;
            // team_2 statistics
            $team_2->against += $new_game->score_team_1;
            $team_2->goals += $new_game->score_team_2;
            $team_2->average =  $team_2->goals - $team_2->against;
            $team_2->lost += 0;
            $team_2->won += 1;
            $team_2->draw -= 0;
            $team_2->num_games += 1;
            $team_2->points += 3;

        }
        // draw now
        elseif($new_game->score_team_1 == $new_game->score_team_2){
            // team_1 statistics
            $team_1->against += $new_game->score_team_2;
            $team_1->goals += $new_game->score_team_1;
            $team_1->average =  $team_1->goals - $team_1->against;
            $team_1->lost -= 0;
            $team_1->won += 0;
            $team_1->draw += 1;
            $team_1->num_games += 1;
            $team_1->points += 1;
            // team_2 statistics
            $team_2->against += $new_game->score_team_1;
            $team_2->goals += $new_game->score_team_2;
            $team_2->average =  $team_2->goals - $team_2->against;
            $team_2->lost += 0;
            $team_2->won -= 0;
            $team_2->draw += 1;
            $team_2->num_games += 1;
            $team_2->points += 1;

        }
        // save updated teams statistics
        $team_1->save();
        $team_2->save();
    }

}
