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
                        <x-danger-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-bill-deletion')" class="mr-4">
                            {{ __('Delete') }}
                        </x-danger-button>

                        <form method="POST" action="{{ route('bills.markaspaid', ['id' => $bill->id]) }}">
                            @csrf
                            @method('post')
                            <x-primary-button class="ml-4">
                                {{ __('Mark as paid!') }}
                            </x-primary-button>
                        </form>

                        <x-modal name="confirm-bill-deletion" focusable>
                            <form method="post"
                                action="{{ route('bills.destroy', ['bill' => $bill->id]) }}"
                                class="p-6">
                                @csrf
                                @method('delete')

                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Are you sure you want to delete your bill?') }}
                                </h2>

                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        {{ __('Cancel') }}
                                    </x-secondary-button>

                                    <x-danger-button class="ml-3">
                                        {{ __('Delete Bill') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    </div>
                    <form method="POST"
                        action="{{ route('bills.update', ['bill' => $bill->id]) }}">
                        @csrf
                        @method('put')

                        <div>
                            <x-text-input id="name" type="text" name="name" :value="$bill->name" required
                                autofocus autocomplete="name" class="block mt-1 w-full" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="value" :value="__('Value')" />

                            <x-text-input id="value" type="number" name="value" step="0.01" required
                                autocomplete="value" :value="$bill->value" class="block mt-1 w-full" />

                            <x-input-error :messages="$errors->get('value')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />

                            <textarea id="description" name="description" autocomplete="description" rows="4"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{$bill->description}}</textarea>

                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="paymentoption_id" :value="__('Payment Option')" />

                            <select name="paymentoption_id" required
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach ($paymentOptions as $paymentOption)
                                <option value="{{ $paymentOption->id }}"
                                    @selected($bill->paymentoption_id==$paymentOption->id)>
                                    {{ $paymentOption->name }}
                                </option>
                                @endforeach
                            </select>

                            <x-input-error :messages="$errors->get('paymentoption_id')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ url()->previous() }}"
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
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