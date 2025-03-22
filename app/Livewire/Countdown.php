<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Countdown extends Component
{
    public int $countdown = 2;
    public int $state = 0;
    public string $move = 'Player Turn';
    public int $times_clicked = 0;
    public int $return_clicks = 0;
    public string $isDisabled = '';
    public string $test = "Hello there";

    public function render(): object
    {
        return view('livewire.countdown');
    }

    public function rendered(): void
    {

    }

    public function begin(): void
    {
        $this->times_clicked++;
        $this->count_down();
        $this->second();
        # Set the state to in process
        #$this->isDisabled = 'disabled';
        #$this->stream(to: 'isDisabled', content: $this->isDisabled, replace: true);
        #sleep(2);
        #$this->isDisabled = '';

        #$this->times_clicked++;
        #$this->stream(to: 'clicks', content: $this->times_clicked, replace: true);

        #if ($this->times_clicked > 5) { $this->isDisabled = 'disabled';}

        # $this->count_down();

        # Put the state back to clickable
        #$this->stream(to: 'isDisabled', content: $this->isDisabled, replace: true);

    }

    public function count_down(): void
    {
        while ($this->countdown > 0 )
        {
            # Sleep so we can see it
            sleep(1);

            # Update
            $this->countdown--;

            # Stream to the countdown
            $this->stream(to: 'count',content: $this->countdown, replace: true);

            #if($this->countdown == 3) { dd($this->countdown, $this->state, $this->times_clicked);}
        }

        sleep(1);
        $this->countdown = 5;
        $this->stream(to: 'count',content: $this->countdown, replace: true);
        # dd($this->countdown, $this->times_clicked, $this->return_clicks);
    }

    public function second(): void
    {
        # For usleep 1000 * 1000 = 1 second, so 750 * 1000 = 750,000 us or 750 ms
        $this->move = 'Right';
        $this->stream(to: 'move', content: $this->move, replace: true);
        usleep(750 * 1000);
        $this->move = 'Left';
        $this->stream(to: 'move', content: $this->move, replace: true);
        usleep(750 * 1000);
        $this->move = 'Player Turn';
        $this->stream(to: 'move', content: $this->move, replace: true);
        usleep(750 * 1000);
    }

    public function init(): void
    {
        usleep(1750 * 1000);
        $this->test = "General Kenobi";
        $this->stream(to: 'test', content: $this->test, replace: true);
    }
}
