<?php

namespace App\Livewire;

use App\Classes\CPU;
use Livewire\Component;
use Random\RandomException;

class Game1P extends Component
{

    public string $board = '';
    public int $state = 0;
    public string $player = 'Player 1';
    public ?CPU $CPU = null;
    public string $best = 'Right';
    public string $winner = '1P';
    public array $moves = [];

    /**
     * @throws RandomException
     */
    public function mount(): void
    {
        $this->generate_board();
        $this->update_CPU();

        # dd($this->moves, $this->board);
    }

    public function boot(): void
    {
        #$this->generate_board();
    }
    public function render(): object
    {
        return view('livewire.game1-p');
    }

    /**
     * @throws RandomException
     */
    private function generate_board() : void
    {
        # Declare variables
        $r = '';

        # Get a random length
        $l = random_int(3, 5);

        # Set the allowable characters
        $c = 'WL';

        # Create our String
        for($i = 0; $i < $l; $i++)
        {
            # Flip a coin
            $d = random_int(0, 1);

            # Append W or L
            if($d == 0) { $r = $r. 'W';}
            else { $r = $r . 'L';}
        }

        # Set the board to our generated string
        $this->board = $r;

    }

    public function left(): void
    {
        # This button should only work if we are in the right state
        if($this->state != 0) { return; }

        # Remove the left-most character
        $this->board = substr($this->board, 1);

        # Update the game
        $this->update_game();
    }

    public function right(): void
    {
        # This button should only work if we are in the right state
        if($this->state != 0) { return; }

        # Remove right-most character
        $this->board = substr($this->board, 0, -1);

        # Update the game
        $this->update_game();
    }

    public function update_game(): void
    {
        # Get the string length
        $l = strlen($this->board);

        # Update player's turn
        if($this->player == 'Player 1') {$this->player = 'Player 2';}
        else {$this->player = 'Player 1';}

        $this->update_CPU();

        # Determine if the game is over
        if($l < 2)
        {
            # Game is over
            $this->state = 1;

            if($this->board == 'W')
            {
                $this->player = $this->player . ' Wins!';
            }
            else
            {
                $this->player = $this->player . ' Lost!';
            }
        }
    }

    public function update_CPU(): void
    {
        # Generate a new CPU Instance
        $this->CPU = new CPU($this->board);

        # grab the moves
        $moves = $this->CPU->get_moves();

        # Let's use moves to predict the best move / Winner
        $this->best = $moves[0]->get_action();
    }
}
