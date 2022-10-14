<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Lazy build</title>

        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

        <script defer src="{{ mix('/js/app.js') }}"></script>
        <script>
            function handler({ version, distro }, wasCopied) {
                console.log(arguments)
                // 1) Add the text to the DOM (usually achieved with a hidden input field)
                const input = document.createElement('input');
                document.body.appendChild(input);
                input.value = 'curl https://lazy.build/' + distro.package+ '@'+distro.distro + ':' + version+ ' | bash';
                console.log(version, distro);
                // 2) Select the text
                input.focus();
                input.select();

                // 3) Copy text to clipboard
                const isSuccessful = document.execCommand('copy');
                input.remove();
                // 4) Catch errors
                if (!isSuccessful) {
                    console.error('Failed to copy text.');
                }
                wasCopied()
            }

            async function fetchPreview({ version, distro }, closure) {
                const { data } = await axios.get('/' + distro.package + '@' + distro.distro + ':' + version)

                console.log(data);
                closure(data);
            }

        </script>
    </head>
    <body class="antialiased my-8">
        <div x-data="{ 'showModal': false, contents: null, packages: {{$files}} }" @keydown.escape="showModal = false" class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 dark:text-white sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="font-mono">
                    Greetings! This site exists because ultimately I'm lazy and install things on VMS too often. Feel free to use this as well.
                    The url scheme is https://lazy.build/&lt;package>@&lt;distro:&lt;script>
                </div>
                <div class="font-mono mt-4 mb-2">
                    Clicking "copy" will copy the install command using curl to your clip board. Clicking preview will open a modal to display the script's contents.
                </div>
                
                <div class="font-mono mt-4 mb-2">
                    If you're curious and would like to contribute, [this whole project](https://github.com/lazy-build/service) is open source [including the scripts](https://github.com/Lazy-Build/scripts). Contributions are always welcome, and multiple versions are not needed, but also welcome!
                </div>
                <!-- This example requires Tailwind CSS v2.0+ -->
                <ul role="list" class="w-full flex flex-wrap gap-4 dark:text-gray-200">
                    <template x-for="(pkg, pkgName) in packages">
                        <li class="w-full flex flex-col gap-2">
                            <h2 class="text-2xl text-gray-800 dark:text-gray-300" x-text="pkgName"></h2>
                            <div class="w-full grid grid-cols-1 lg:grid-cols-3 gap-4">
                                <template x-for="(distro, distroName) in pkg">
                                    <div x-data="{ version: distro[0].script }" class="bg-white dark:bg-gray-800 rounded-lg shadow divide-y divide-gray-200">
                                        <div class="w-full flex items-center justify-between p-6 space-x-6">
                                            <img class="w-10 h-10 flex-shrink-0" x-bind:src="distro[0].logo" alt="">
                                            <div class="flex-1 truncate">
                                                <div class="flex items-center space-x-3">
                                                    <h3 class="text-gray-900 dark:text-gray-200 text-sm font-medium truncate" x-text="pkgName"></h3>
                                                </div>
                                                <p class="mt-1 text-gray-500 dark:text-gray-400 text-sm truncate" x-text="distroName"></p>
                                            </div>
                                            <div class="flex-1 flex justify-end items-center">
                                                <select x-model="version" class="ml-auto w-20 text-xs m-0 py-2 pr-6 pl-2 bg-gray-100 dark:bg-gray-800 text-gray-800 dark:bg-gray-200 rounded-lg">
                                                    <template x-for="script in distro">
                                                        <option x-bind:value="script.script" x-text="script.script"></option>
                                                    </template>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="-mt-px flex divide-x divide-gray-200">
                                            <div class="w-0 flex-1 flex" x-data="{ wasCopied: false }">
                                                <button x-on:click="handler({ version, distro: distro.filter(d => d.script === version)[0] }, () => { wasCopied = true; setTimeout(() => wasCopied = false, 2000) })" class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 dark:text-gray-300 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                                    <svg x-show="!wasCopied" class="w-6 h-6 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                                    <span x-show="!wasCopied"  class="ml-3">Copy</span>
                                                    <svg x-show="wasCopied" class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                                    <span x-show="wasCopied"  class="ml-3">Copied</span>
                                                </button>
                                            </div>
                                            <div class="-ml-px w-0 flex-1 flex">
                                                <button x-on:click="() => fetchPreview({ version, distro: distro.filter(d => d.script === version)[0] }, (data) => { contents = data; showModal = true; } )" class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 dark:text-gray-300 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
                                                    <!-- Heroicon name: solid/phone -->
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                    <span class="ml-3">Preview</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </li>
                    </template>
                    <!-- More people... -->
                </ul>

                <div class="overflow-auto" x-show="showModal" :class="{ 'fixed h-screen inset-0 z-10 flex items-center justify-center': showModal }">
                    <button x-show="showModal" class="bg-gray-600 opacity-75 absolute h-screen w-full inset-0 z-0 flex items-center justify-center" @click="showModal=false"></button>
                    <div class="bg-gray-100 dark:bg-gray-800 text-gray-800 dark:bg-gray-200 align-bottom rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full sm:p-6">
                        <code><pre x-text="contents"></pre></code>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
