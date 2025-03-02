<div class="py-2 px-4 w-[360px] h-[640px]">
    <div class="flex justify-center items-center w-full h-1/8">
        <H1 class="text-2xl">Winners and Losers</H1>
    </div>
    <div class="flex flex-col justify-center items-center break-all w-full h-3/4">
        @if($state == 0)
            <div class="h-1/8">
                <p>Welcome to Winners and Losers.</p>
            </div>
        <div class="w-full flex flex-col justify-start break-normal h-3/4 px-4 py-2">
            <p>How to Play:</p>
            <ol class="list-disc">
                <li>There will be a string of 5-50 random "L" and "W" letters created when the game starts</li>
                <li>Each player takes turns removing one letter from the left or right</li>
                <li>The game continues until the last letter is removed</li>
                <li>The player who takes the last letter from the string wins if the last letter is "W"</li>
                <li>The player who takes the last letter form the string loses if the last letter is "L"</li>
            </ol>
        </div>
        <div>
            <p>click begin to start the game</p>
        </div>
        @elseif($state == 1)
            <div class="flex flex-col justify-center items-center h-1/4">
                <p class="text-2xl">{{$player}}</p>
            </div>
            <div class="h-3/4">
            <p class="break-words">{{$board}}</p>
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
    <div class="flex justify-center items-center w-full h-1/8 ">
        @if($state == 0)
            <div class="flex justify-center w-full">
                <button wire:click="click" class="bg-slate-200 rounded-md border border-slate-300 py-2 px-4 max-h-16 max-w-full">Start Game</button>
            </div>
        @elseif($state == 1)
            <div class="flex justify-center w-1/2">
                <button wire:click="left" class="bg-slate-200 rounded-md border border-slate-300 py-2 px-4 max-h-16">Remove Left</button>
            </div>
            <div class="flex justify-center w-1/2">
                <button wire:click="right" class="bg-slate-200 rounded-md border border-slate-300 py-2 px-4 max-h-16">Remove Right</button>
            </div>
        @elseif($state == 2)
            <div class="flex justify-center w-full">
                <button wire:click="click" class="bg-slate-200 rounded-md border border-slate-300 py-2 px-4 max-h-16">Play Again</button>
            </div>
        @endif
    </div>
    <div>
        
    </div>
</div>
