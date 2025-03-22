<?php

namespace App\Classes;

use Livewire\Wireable;

class CPU implements Wireable
{
    private array $moves = [];
    private array $tree = [];
    private string $board;
    private int $level;
    private int $branch;

    public function __construct($board)
    {
        $this->board = $board;
        $this->build_tree();
        $this->level = strlen($this->board)-1;
        $this->branch = 0;
        $this->build_moves();
    }

    function build_moves(): void
    {
        # Loop the length of the string
        $l = strlen($this->board);

        # Set tree level and branch variable
        $branch = 0;
        $level = $l -1;

        # Set the board variable
        $board = $this->board;

        # Loop through the possible moves
        for ($i = 0; $i < $l; $i++)
        {
            # Fill in the turns, player, and action
            $turn = $i+1;
            $player = $this->get_player($i+1);

            # Determine the best move unless it is the very last one
            if($i != $l-1) { $action = $this->best_move($branch, $level);}
            else {$action = 'Game Over';}

            # Create the move and add it to the array
            $move = new Move($turn, $player, $action, $board);
            $this->moves[] = $move;

            # Resolve the branch if right was entered for the next iteration
            if($action == 'Right')
            {
                # Increment our branch value
                $branch = $branch + 1;
                $level = $level - 1;

                # Set board to trim right string
                $board = substr($board, 0, -1);
            }
            else
            {
                # Set Board to trim left string
                $board = substr($board, 1);
                $level = $level - 1;
            }

        }

    }

    function build_tree(): void
    {
        # Clear our tree just in case
        $this->tree = [];

        # Grab our string length
        $l = strlen($this->board);

        # Loop through the string
        for($i = 0; $i < $l; $i++)
        {
            # Special case - on the first time, reverse the string
            if($i ==0)
            {
                $this->tree[$i] = strrev($this->board);
                continue;
            }

            # If we are in an odd portion of the loop, use OR
            if($i % 2 == 0) {$this->tree[$i] = $this->or_tree($this->tree[$i-1]);}

            # otherwise, use AND
            else { $this->tree[$i] = $this->and_tree($this->tree[$i-1]);}
        }

        # Reverse the array - This screws things up!
        # $this->tree = array_reverse($this->tree);
    }

    function or_tree(string $s) : string
    {
        # Get the length of the string
        $l = strlen($s);

        # Create the return string
        $r = '';

        # Loop through and OR each value pair
        for($i = 0; $i < $l-1; $i++)
        {
            if($s[$i] == 'W' or $s[$i+1] == 'W') { $r .= 'W';}
            else { $r .= 'L'; }
        }

        # Return the string
        return $r;
    }

    function and_tree(string $s) : string
    {
        # Get the string length
        $l = strlen($s);

        # Create the return value
        $r = '';

        # Loop through and AND each value pair
        for($i = 0; $i < $l-1; $i++)
        {
            if($s[$i] == 'W' and $s[$i+1] == 'W') { $r .= 'W';}
            else { $r .= 'L'; }
        }

        # Return the string
        return $r;
    }

    function get_moves(): array
    {
        return $this->moves;
    }

    function get_player($turn) : string
    {
        # Note: Turns start at 1, not zero!

        # Return the current player
        if($turn % 2 == 0) { $player = '2P';}
        else { $player = '1P';}

        # Return value
        return $player;
    }

    function move_left() : void
    {
        # Branch stays the same, level increments
        $this->level = $this->level - 1;
    }

    function move_right() : void
    {
        # Branch and level increment
        $this->branch = $this->branch + 1;
        $this->level = $this->level - 1;
    }

    public function best_move($branch, $level) : string
    {
        # Moves coming in start at 0!

        # See what left and right branches produce
        $left = $this->tree[$level-1][$branch];
        $right = $this->tree[$level-1][$branch+1];

        # Set Left as the default move
        $m = 'Left';

        # Conditions where we want right
        if($level %2 == 0 and $right == 'W') { $m = 'Right';}
        if($level % 2 != 0 and $right == 'L') { $m = 'Right';}

        # Return our value
        return $m;
    }
    public function predict_winner() : string
    {
        # Get the length of the board
        $l = strlen($this->board);

        # Get the current condition
        $v = $this->tree[$this->level][$this->branch];

        # Set 1P as default return value
        $r = '1P';

        # if Even and W, 2P Wins
        if($l % 2 == 0 and $v == 'W') { $r = '2P';}

        # If Odd and L, 2P Wins
        if($l % 2 != 0 and $v == 'L') { $r = '2P';}

        #dd($this->tree, $this->level, $this->branch, $r);

        # return our value
        return $r;
    }

    public function toLivewire(): array
    {
        return
        [
            'level' => $this->level,
            'board' => $this->board,
            'branch' => $this->branch,
            'moves' => $this->moves,
            'tree' => $this->tree,
        ];
    }

    public function get_branch(): int { return $this->branch;}
    public function get_level(): int { return $this->level;}
    public function get_tree(): array { return $this->tree;}

    public static function fromLivewire($value): static
    {
        $level = $value['level'];
        $board = $value['board'];
        $branch = $value['branch'];
        $moves = $value['moves'];
        $tree = $value['tree'];

        return new static($board);
    }
}
