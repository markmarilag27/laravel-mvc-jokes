<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel Jokes') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">

    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow">
        <main class="flex w-full flex-col lg:max-w-4xl">

            <div
                class="p-6 pb-12 lg:p-20 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-lg">

                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-xl font-medium mb-1">Programmer Jokes</h1>
                        <p class="text-[13px] text-[#706f6c] dark:text-[#A1A09A]">Fetching 3 random laughs for you.</p>
                    </div>

                    <button id="refresh-btn"
                        class="inline-block px-5 py-1.5 dark:text-[#1C1C1A] bg-[#1b1b18] dark:bg-[#eeeeec] text-white rounded-sm text-sm font-medium transition-all hover:opacity-90 disabled:opacity-50">
                        Refresh
                    </button>
                </div>

                <div id="joke-list" class="flex flex-col gap-4">
                    <div id="loader" class="text-[13px] text-[#706f6c] animate-pulse">
                        Loading initial jokes...
                    </div>
                </div>

            </div>
        </main>
    </div>

    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </footer>
</body>

</html>
