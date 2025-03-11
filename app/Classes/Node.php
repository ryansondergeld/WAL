<?php

namespace App\Classes;
class Node
{
    public string $value;
    public string $type;
    public ?Node $left;
    public ?Node $right;
    public ?string $best;
    public ?string $winner;

    public function __construct($string, $type)
    {
        $this->value = $string;
        $this->type = $type;
        $this->left = null;
        $this->right = null;
        $this->best = null;
        $this->winner = null;
    }

    public function build_tree(Node $n)
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
        $left_value = $this->build_tree($n->left);
        $right_value = $this->build_tree($n->right);

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
