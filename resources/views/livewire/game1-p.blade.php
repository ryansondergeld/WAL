<div class="main-container">
    <div class="header-container">
        <H1 class="text-2xl">Winners and Losers</H1>
    </div>
    <div class="flex flex-col justify-center items-center break-all w-full h-3/4">
        @if($state == 0 or $state == 1)
            <div class="flex flex-col justify-center items-center h-1/4">
                <p class="text-2xl" wire:stream="player">{{$player}}</p>
            </div>
            <div class="h-3/4">
                <p class="break-words" wire:stream="board">{{$board}}</p>
                @foreach($moves as $move)
                    {{$move->get_action()}}
                @endforeach
            </div>
            <div>
                CPU Predicted Winner: {{$winner}}
            </div>
            <div wire:stream="best">
                CPU Recommended move: {{$best}}
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
            <div class="full-button-container">
                <a href="/" wire:navigate class="full-button"><- Back to Home</a>
            </div>
        @endif
        <div wire:init="init"></div>
    </div>
</div>
