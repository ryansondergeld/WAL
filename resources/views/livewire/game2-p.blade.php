<div class="py-2 px-4 w-[360px] h-[640px]">
    <div class="flex justify-center items-center w-full h-1/8">
        <H1 class="text-2xl">Winners and Losers</H1>
    </div>
    <div class="flex flex-col justify-center items-center break-all w-full h-3/4">
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
    <div class="flex justify-center items-center w-full h-1/8 ">
        @if($state == 0)
            <div class="flex justify-center w-1/2">
                <button wire:click="left" class="bg-slate-200 rounded-md border border-slate-300 py-2 px-4 max-h-16">Remove Left</button>
            </div>
            <div class="flex justify-center w-1/2">
                <button wire:click="right" class="bg-slate-200 rounded-md border border-slate-300 py-2 px-4 max-h-16">Remove Right</button>
            </div>
        @elseif($state == 1)
            <div class="flex justify-center w-full">
                <a href="/" wire:navigate class="bg-slate-200 rounded-md border border-slate-300 py-2 px-4 h-12 w-64 text-center hover:bg-blue-200""><- Back to Home</a>
            </div>
        @endif
    </div>
</div>
