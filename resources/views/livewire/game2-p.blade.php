<div class="main-container">
    <div class="header-container">
        <H1 class="text-2xl">Winners and Losers</H1>
    </div>
    <div class="content-container">
        @if($state == 0)
            <div class="flex flex-col justify-center items-center h-1/4">
                <p class="text-2xl">{{$player}}</p>
            </div>
            <div class="h-3/4">
                <p class="break-words">{{$board}}</p>
            </div>
        @elseif($state == 1)
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
        @if($state == 0)
            <div class="half-button-container">
                <button wire:click="left" class="half-button">Remove Left</button>
            </div>
            <div class="half-button-container">
                <button wire:click="right" class="half-button">Remove Right</button>
            </div>
        @elseif($state == 1)
            <div class="full-button-container">
                <a href="/" wire:navigate class="full-button"><- Back to Home</a>
            </div>
        @endif
    </div>
</div>
