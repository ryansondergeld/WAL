<?php

namespace App\Livewire;

use Livewire\Component;

class Game2P extends Component
{
    public string $board = '';
    public int $state = 0;
    public string $player = 'Player 1';

    public function mount(): void
    {
        $this->generate_board();
    }
    public function render(): object
    {
        return view('livewire.game2-p');
    }

    private function best()
    {
        # Start by
    }

    private function generate_board() : void
    {
        # Declare variables
        $r = '';
        $l = random_int(5, 50);
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
        if($l % 2 == 0){ $this->player = 'Player 1';}
        else { $this->player = 'Player 2';}

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
}
