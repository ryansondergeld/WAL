<?php

namespace App\Livewire;

use App\Classes\CPU;
use App\Classes\Move;
use Livewire\Component;

class TestMode extends Component
{
    public string $input = '';
    public string $errors = '';
    public array $tree = [];
    public array $output = [];
    public array $moves = [];
    public CPU $CPU;

    public function mount(): void
    {

    }
    public function render(): object
    {
        return view('livewire.test-mode');
    }

    public function test_string()
    {
        # If the string is no good, do nothing
        if (!$this->validate_string()) { return;}

        # Create our CPU and get the output
        $this->CPU = new CPU($this->input);

        # Get the moves list
        $this->moves = $this->CPU->get_moves();
    }
    private function validate_string() : bool
    {
        # Set errors empty
        $this->errors = '';

        # First check if the input is empty
        if ($this->input == '')
        {
            # If it is empty - throw an error
            $this->errors = 'Must enter string of W and L';
        }
        else
        {
            # Get the length of the string
            $l = strlen($this->input);

            # Check each character
            for($i = 0; $i < $l; $i++)
            {
                if ($this->input[$i] !== 'W' and $this->input[$i] !== 'L')
                {
                    # Throw an error if any characters are not 'L' or 'W'
                    $this->errors .= 'Use only W or L';
                    break;
                }
            }
        }

        # Return true or false
        if ($this->errors == '') { return true;}
        else { return false;}
    }
}
