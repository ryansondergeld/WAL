<?php

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

}