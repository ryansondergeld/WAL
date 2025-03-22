<div>
    <div wire:stream="count">
        {{$countdown}}
    </div>
    <div wire:stream="clicks">
        {{$times_clicked}}
    </div>
    <div>
        <p id="feedback">Player's Turn</p>
        <button id="start-button" class="test-button" wire:click.debounce="begin" onclick="startClicked()">Start</button>
        <!-- wire:click.debounce="begin" -->
    </div>
    <div wire:stream="move">{{$move}}</div>
    <div>
        <div wire:loading wire:target="begin">CPU is thinking. . . </div>
        <button
            class="test-button"
            wire:click.debounce="begin"
            wire:loading.attr="disabled"
            wire:target="begin"
        >
            Start 2
        </button>
    </div>
    <div wire:init="init" wire:stream="test">{{$test}}</div>
    <!-- JavaScript Required -->
    <script type="text/javascript">
        // Items in Layout
        const b = document.getElementById('start-button');
        const p = document.getElementById('feedback');
        let c = 0;

        function startClicked()
        {
            c++;
            p.textContent = 'CPU is thinking';
            disable();
            setTimeout(enable, 7000);
        }

        function disable()
        {
            b.disabled = true;
        }

        function enable()
        {
            b.disabled = false;
        }


    </script>
    <!-- End JavaScript Requirement -->
</div>
