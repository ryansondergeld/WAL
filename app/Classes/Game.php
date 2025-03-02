<?php

namespace App\Classes;

class Game
{
    public string $hello = 'Hello There';
    public string $general = 'General Kenobi';

    public function say_hello()
    {
        echo $this->hello;
    }

}
