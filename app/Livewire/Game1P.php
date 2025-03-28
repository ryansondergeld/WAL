<?php

namespace App\Livewire;

use App\Classes\CPU;
use Livewire\Component;
use Random\RandomException;

class Game1P extends Component
{

    public array $map = [];
    public int $map_level = 0;
    public int $map_branch = 0;
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
        # Generate the board and CPU info
        $this->generate_board();
        $this->update_CPU();

        # Set the initial map
        $this->map = $this->CPU->get_tree();
        $this->map_level = $this->CPU->get_level();
        $this->map_branch = $this->CPU->get_branch();

        # Update the game
        $this->update_game();
    }

    public function render(): object
    {
        return view('livewire.game1-p');
    }

    /**
     * @throws RandomException
     */
    public function init(): void
    {
        # Flip a random coin to see if the CPU goes first
        if(random_int(0, 1) == 1)
        {
            $this->player = 'CPU';
            $this->stream(to: 'player', content: $this->player, replace: true);
            $this->CPU_turn();
        }
    }

    /**
     * @throws RandomException
     */
    private function generate_board() : void
    {
        # Declare variables
        $r = '';

        # Get a random length
        $l = random_int(5, 55);

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
        # Pick left
        $this->pick_left();

        # If this isn't the last move, CPU's turn
        if($this->map_level > 0)
        {
            # Run CPU
            $this->CPU_turn();
        }

    }

    public function pick_left(): void
    {
        # Remove the left-most character
        $this->board = substr($this->board, 1);

        # Moving left, decrement the level by 1
        $this->map_level = $this->map_level - 1;

        # Update the game
        $this->update_game();
    }

    public function right(): void
    {
        # Pick right
        $this->pick_right();

        # If this isn't the last move, CPU's turn
        if($this->map_level > 0)
        {
            # Run CPU
            $this->CPU_turn();
        }

    }

    public function pick_right(): void
    {
        # Remove right-most character
        $this->board = substr($this->board, 0, -1);

        # Moving right, decrement level by 1 and add 1 to branch
        $this->map_level = $this->map_level - 1;
        $this->map_branch = $this->map_branch + 1;

        # Update the game
        $this->update_game();
    }

    public function update_game(): void
    {
        # Get the string length
        $l = strlen($this->board);

        # Updated predicted winner
        $ml = strlen($this->map[0]);
        $mv = $this->map[$this->map_level][$this->map_branch];
        $this->winner = '1P';

        # if Even and W, 2P Wins
        if($ml % 2 == 0 and $mv == 'W') { $this->winner = '2P';}

        # If Odd and L, 2P Wins
        if($ml % 2 != 0 and $mv == 'L') { $this->winner = '2P';}

        if($this->map_level >0)
        {
            $this->best = $this->best_move($this->map_branch, $this->map_level);
        }

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

    public function update_CPU(): void
    {
        # Generate a new CPU Instance
        $this->CPU = new CPU($this->board);

        # grab the moves
        $moves = $this->CPU->get_moves();

        # Let's use moves to predict the best move / Winner
        $this->best = $moves[0]->get_action();
    }

    public function CPU_turn(): void
    {
        # Stream the board change
        $this->player = 'CPU';
        $this->best = 'CPU is thinking. . . ';
        $this->stream(to: 'player', content: $this->player, replace: true);
        $this->stream(to: 'board', content: $this->board, replace: true);
        $this->stream(to: 'best',content: $this->best, replace: true);
        usleep(500 * 1000);

        # Get the best move
        $this->best = $this->best_move($this->map_branch, $this->map_level);

        # Pick the best move
        if($this->best == 'Right') { $this->pick_right();}
        else { $this->pick_left();}

        # Pause and stream the message
        $this->best = 'CPU is Moving ' . $this->best;
        $this->stream(to: 'best',content: $this->best, replace: true);
        usleep(750 * 1000);

        # Update the game
        $this->update_game();

        # Change back to player's turn
        $this->player = 'Player 1';
        $this->stream(to: 'player', content: $this->player, replace: true);
    }

    public function best_move($branch, $level) : string
    {
        # Moves coming in start at 0!

        # See what left and right branches produce
        $left = $this->map[$this->map_level-1][$this->map_branch];
        $right = $this->map[$this->map_level-1][$this->map_branch+1];

        # Set Left as the default move
        $m = 'Left';

        # Conditions where we want right
        if($this->map_level %2 == 0 and $right == 'W') { $m = 'Right';}
        if($this->map_level % 2 != 0 and $right == 'L') { $m = 'Right';}

        # Return our value
        return $m;
    }

}
