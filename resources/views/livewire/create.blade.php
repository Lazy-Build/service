<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75	"></div>
        </div>
        <div class=" bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl  mx-auto">
            <form>
                <div class="m-4">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Script creation
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            These scripts will be avilable at `https://lazy.build/&lt;slug>`
                        </p>
                    </div>
                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Name
                            </label>
                            <div class="mt-1">
                                <input wire:model="name" type="text" name="name" id="name" autocomplete="given-name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="first-name" class="block text-sm font-medium text-gray-700">
                                Slug
                            </label>
                            <div class="mt-1">
                                <input wire:model="slug" type="text" name="name" id="name" autocomplete="given-name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                @error('slug') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="sm:col-span-6">
                            <label for="about" class="block text-sm font-medium text-gray-700">
                                Script
                            </label>
                            <div class="mt-1">
                                <code><pre><textarea wire:model="contents" id="script" name="script" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea></pre></code>
                            </div>
                            <p class="mt-2 text-sm text-gray-500"></p>
                        </div>

                    </div>
                </div>


                <div class="m-4">
                    <div class="flex justify-end">
                        <button wire:click="closeModalPopover()" type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </button>
                        <button wire:click.prevent="store()" type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
