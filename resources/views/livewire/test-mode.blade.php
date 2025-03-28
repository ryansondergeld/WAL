<div class="main-container-test">
    <div class="header-container">
        <H1 class="text-2xl">Winners and Losers</H1>
    </div>
    <div class="flex flex-col justify-start items-center break-all w-full h-full">
        <div class="w-full flex flex-col justify-start break-normal h-3/4 px-4 py-2">
            <p class="w-full flex justify-center break-normal">Enter a string of 'W' and 'L' below and click Test String to see how the game will play out.</p>
            <p class="error-text">{{$errors}}</p>
            <div class="full-button-container">
                <input type="text" wire:model="input" class="basic-input">
            </div>
            <div class="full-button-container">
                <a href="/" wire:click="test_string" wire:click.prevent class="full-button">Test String</a>
            </div>
            <div class="flex flex-col w-full">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <th class="w-1/4 text-left">Turn</th>
                        <th class="w-1/4 text-left">Player</th>
                        <th class="w-1/4 text-left">Board</th>
                        <th class="w-1/4 text-left">Move</th>
                    </tr>
                    </thead>
                    @foreach($moves as $move)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <td>{{$move->get_turn()}}</td>
                            <td>{{$move->get_player()}}</td>
                            <td class="max-w-10 break-all">{{$move->get_board()}}</td>
                            <td>{{$move->get_action()}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="control-container">
        <div class="full-button-container">
            <a href="/" wire:navigate class="full-button"><- Back</a>
        </div>
    </div>
</div>
