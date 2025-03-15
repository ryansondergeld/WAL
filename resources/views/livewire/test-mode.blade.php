<div class="py-2 px-4 w-[360px] h-[640px]">
    <div class="flex justify-center items-center w-full h-1/8">
        <H1 class="text-2xl">Winners and Losers</H1>
    </div>
    <div class="flex flex-col justify-start items-center break-all w-full h-3/4">
        <div class="w-full flex flex-col justify-start break-normal h-3/4 px-4 py-2">
            <p class="w-full flex justify-center">Enter a string of 'W' and 'L' below and click Test String to see how the game will play out.</p>
            <p class="text-sm text-red-500">{{$errors}}</p>
            <div class="flex justify-center w-full py-2">
                <input type="text" wire:model="input" class="border border-slate-300 py-2 px-4 h-12 w-64"></input>
            </div>
            <div class="flex justify-center w-full py-2">
                <a href="/" wire:click="test_string" wire:click.prevent class="bg-slate-200 rounded-md border border-slate-300 py-2 px-4 h-12 w-64 text-center hover:bg-blue-200">Test String</a>
            </div>
            <div class="test flex flex-col">
                <table>
                    <thead>
                    <tr>
                        <td>Turn</td>
                        <td>Player</td>
                        <td>Board</td>
                        <td>Move</td>
                    </tr>
                    </thead>
                    @foreach($moves as $move)
                    <tr>
                        <td>{{$move->get_turn()}}</td>
                        <td>{{$move->get_player()}}</td>
                        <td>{{$move->get_board()}}</td>
                        <td>{{$move->get_action()}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="flex justify-center items-center w-full h-1/8 py-2">
        <div class="flex justify-center w-full py-2">
            <a href="/" wire:navigate class="bg-slate-200 rounded-md border border-slate-300 py-2 px-4 h-12 w-64 text-center hover:bg-blue-200"><- Back</a>
        </div>
    </div>
</div>
