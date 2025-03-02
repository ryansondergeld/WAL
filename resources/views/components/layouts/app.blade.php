<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Winners and Losers' }}</title>
        @livewireStyles
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    </head>
    <body background="bg.jpg">
    <div class="flex flex-col border border-black justify-center items-center h-screen w-screen">
        <div class="flex flex-col justify-center items-center bg-slate-100 border border-slate-600 rounded-2xl w-[360px] h-[640px] max-w-sm max-h-sm">
            {{ $slot }}
        </div>
    </div>
        @livewireScripts
    </body>
</html>
