<div class="main-container">
    <div class="header-container">
        <H1 class="text-2xl">Winners and Losers</H1>
    </div>
    <div class="content-container">
        @if($state == 0 or $state == 1)
            <div class="flex flex-col justify-center items-center h-1/4">
                <p class="text-2xl" wire:stream="player">{{$player}}</p>
            </div>
            <div class="h-3/4">
                <p class="break-words" wire:stream="board">{{$board}}</p>
            </div>
            <div>
                AI Predicted Winner: {{$winner}}
            </div>
            <div wire:stream="best">
                AI Recommended move: {{$best}}
            </div>
        @elseif($state == 2)
            <div class="flex flex-col justify-center items-center h-1/4">
                <p class="text-3xl">{{$board}}</p>
                <p>Game is over!</p>
                {{$player}}
            </div>
            <div class="flex flex-col justify-start items-center h-3/4">
            </div>
        @endif
    </div>
    <div class="control-container">
        @if($state == 0 or $state == 1)
            <div class="half-button-container">
                <button wire:click="left" wire:loading.attr="disabled" wire:target="left, init" class="half-button">Remove Left</button>
            </div>
            <div class="half-button-container">
                <button wire:click="right" wire:loading.attr="disabled" wire:target="right, init" class="half-button">Remove Right</button>
            </div>
        @elseif($state == 2)
            <div class="half-button-container">
                <a href="/" wire:navigate class="half-button"><- Back to Home</a>
            </div>
            <div class="half-button-container">
                <a href="/Game1P" wire:navigate class="half-button">Play Again!</a>
            </div>
        @endif
        <div wire:init="init"></div>
    </div>
</div>
