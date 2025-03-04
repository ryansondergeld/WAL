<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use Random\RandomException;
use App\Classes\Node;

class WinnersAndLosers extends Component
{
    public string $board = '';
    public int $state = 0;
    public string $player = 'Player 1';

    /**
     * @throws RandomException
     */
    # Mount will only once when the page is loaded
    public function mount(): void
    {
        # Generate a random number
        $this->generate();
    }

    # Render will run every time an event happens
    public function render(): View|Factory|Application
    {
        # Show the view
        return view('livewire.winnersandlosers');
    }

    /**
     * @throws RandomException
     */
    private function generate() : void
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

        # Return the string
        $this->board = $r;
    }

    /**
     * @throws RandomException
     */
    public function click(): void
    {
        # Generate a random number
        $this->generate();

        # Set the game state to 1
        $this->state = 1;

        # Set the player to player 1
        $this->player = 'Player 1';
    }

    public function left(): void
    {
        # This button should only work if we are in the right state
        if($this->state != 1) { return; }

        # Remove the left-most character
        $this->board = substr($this->board, 1);

        # Update the game
        $this->update_game();
    }

    public function right(): void
    {
        # This button should only work if we are in the right state
        if($this->state != 1) { return; }

        # Remove right-most character
        $this->board = substr($this->board, 0, -1);

        # Update the game
        $this->update_game();
    }

    public function update_game(): void
    {
        # Get the string length
        $l = strlen($this->board);

        # Write who's turn it is
        if($l % 2 == 0){ $this->player = 'Player 1';}
        else { $this->player = 'Player 2';}

        # Determine if the game is over
        if($l < 2)
        {
            # Game is over
            $this->state = 2;

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
