<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Payment Option') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="w-full flex justify-end mt-4 mb-10">
                        <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-paymentoption-deletion')" class="mr-4">
                            {{ __('Delete') }}
                        </x-danger-button>

                        <x-modal name="confirm-paymentoption-deletion" focusable>
                            <form method="post" action="{{ route('paymentoptions.destroy', ['paymentoption' => $paymentOption->id]) }}" class="p-6">
                                @csrf
                                @method('delete')
                    
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Are you sure you want to delete your payment option?') }}
                                </h2>
                    
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Once your payment option is deleted, all of its transactions and data will be permanently deleted.') }}
                                </p>

                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        {{ __('Cancel') }}
                                    </x-secondary-button>
                    
                                    <x-danger-button class="ml-3">
                                        {{ __('Delete Payment Option') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    </div>
                    <form method="POST" action="{{ route('paymentoptions.update', ['paymentoption' => $paymentOption->id]) }}">
                        @csrf
                        @method('put')

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" type="text" name="name" :value="$paymentOption->name" required autocomplete="name" class="block mt-1 w-full" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Return') }}
                            </a>

                            <x-primary-button class="ml-4">
                                {{ __('Save') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>