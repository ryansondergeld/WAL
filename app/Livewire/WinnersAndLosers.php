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
    public string $best;
    public string $player = 'Player 1';
    private ?Node $ai;

    /**
     * @throws RandomException
     */
    # Mount will only once when the page is loaded
    public function mount(): void
    {
        # Generate a random string
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

        # Set the string
        $this->board = $r;

        # Get the string length
        $l = strlen($this->board);

        # Set Max as default.  If string is even, set as a min player
        $t = 'max';
        # If string is even, set as a min player
        if ($l % 2 == 0) {$t = 'min';}

        # Create a node
        /*
        # Resolve the game tree
        $value = $this->resolve($n);

        $this->ai = $n;
        */
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

        # Set the Best Move
        # $this->best = $this->ai->best;

    }

    public function resolve(Node $n) : int
    {
        # Get the length of the string
        $length =strlen($n->value);

        # Base Case : String length is less than 2
        if($length < 2)
        {
            if($n->value == 'W') { return 1;}
            else { return 0; }
        }

        # Make a Substring with the values to the left and right
        $l = substr($n->value, 1);
        $r = substr($n->value, 0, -1);

        # Make a type for the next pair of nodes that is the opposite of this one
        $type = 'min';
        if($n->type == 'min') { $type = 'max';}

        # Create new nodes to either side
        $n->left = new Node($l, $type);
        $n->right = new Node($r, $type);

        # Resolve those nodes
        $left_value = $this->resolve($n->left);
        $right_value = $this->resolve($n->right);

        # Depending on type, assign the value
        if($n->type == 'max') { $n->value = max($left_value, $right_value);}
        else { $n->value = min($left_value, $right_value);}

        # Set the Best Move
        if($n->type == 'max' and $n->value == $left_value) { $n->best = 'Left';}
        else { $n->best = 'Right';}

        # Set the Predicted winner for min or max node
        if($n->type == 'max')
        {
            if ($n->value == 1) { $n->winner = 'Player 1';}
            else { $n->winner = 'Player 2';}
        }

        if($n->type == 'min')
        {
            if ($n->value == 0) { $n->winner = 'Player 1';}
            else { $n->winner = 'Player 2';}
        }

        # return our value
        return $n->value;
    }


}
