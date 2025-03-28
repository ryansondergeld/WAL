<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Winners and Losers' }}</title>
        @livewireStyles
        <link href="/css/app.css" rel="stylesheet">
    </head>
    <body background="bg.jpg">
    <div class="flex flex-col justify-center items-center w-screen">
        <div class="flex flex-col justify-center items-center bg-slate-100 border border-slate-600 rounded-2xl min-w-[360px] min-h-[640px] max-w-sm h-fit">
            {{ $slot }}
        </div>
    </div>
        @livewireScripts
    </body>
</html>
