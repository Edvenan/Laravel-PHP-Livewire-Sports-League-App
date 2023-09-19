<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{

    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get a random team ID for team_1_id
        $team1Id = Team::inRandomOrder()->value('id');
    
        // Get a random team ID different from team_1_id for team_2_id
        $team2Id = Team::where('id', '!=', $team1Id)->inRandomOrder()->value('id');
    
        // Generate a random date between Jan 1, 2023 and Jan 1, 2025
        $date = $this->faker->dateTimeBetween('2023-01-01', '2025-01-01')->format('Y-m-d');
    
        // Generate a random time between 09:00 AM and 10:00 PM in 1-hour steps
        $time = $this->faker->dateTimeBetween('09:00', '22:00')->format('H:i');

        return [
            'team_1_id' => $team1Id,
            'team_2_id' => $team2Id,
            'date' => $date,
            'time' => $time,
        ];
    }
}
