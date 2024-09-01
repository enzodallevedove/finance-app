<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="w-full flex justify-end mt-4 mb-10">
                        <x-danger-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-transaction-deletion')" class="mr-4">
                            {{ __('Delete') }}
                        </x-danger-button>

                        <x-modal name="confirm-transaction-deletion" focusable>
                            <form method="post"
                                action="{{ route('transactions.destroy', ['transaction' => $transaction->id]) }}"
                                class="p-6">
                                @csrf
                                @method('delete')

                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Are you sure you want to delete your transaction?') }}
                                </h2>

                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        {{ __('Cancel') }}
                                    </x-secondary-button>

                                    <x-danger-button class="ml-3">
                                        {{ __('Delete Transaction') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    </div>
                    <form method="POST"
                        action="{{ route('transactions.update', ['transaction' => $transaction->id]) }}">
                        @csrf
                        @method('put')

                        <div>
                            <x-text-input id="name" type="text" name="name" :value="$transaction->name" required
                                autofocus autocomplete="name" class="block mt-1 w-full" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="value" :value="__('Value')" />

                            <x-text-input id="value" type="number" name="value" step="0.01" required
                                autocomplete="value" :value="$transaction->value" class="block mt-1 w-full" />

                            <x-input-error :messages="$errors->get('value')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />

                            <textarea id="description" name="description" autocomplete="description" rows="4"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{$transaction->description}}</textarea>

                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="date" :value="__('Date')" />

                            <x-text-input id="date" type="date" name="date" autocomplete="date"
                                value="{{ $transaction->date }}" class="block mt-1 w-full" />

                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="paymentoption_id" :value="__('Payment Option')" />

                            <select name="paymentoption_id" required
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach ($paymentOptions as $paymentOption)
                                <option value="{{ $paymentOption->id }}"
                                    @selected($transaction->paymentoption_id==$paymentOption->id)>
                                    {{ $paymentOption->name }}
                                </option>
                                @endforeach
                            </select>

                            <x-input-error :messages="$errors->get('paymentoption_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="paymentoption_id" :value="__('Payment Option')" />

                            <select name="paymentoption_id" required
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach ($paymentOptions as $paymentOption)
                                <option value="{{ $paymentOption->id }}"
                                    @selected($transaction->paymentoption_id==$paymentOption->id)>
                                    {{ $paymentOption->name }}
                                </option>
                                @endforeach
                            </select>

                            <div class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach ($categories as $category)
                                    <span class="m-1 flex" style="line-height: 2rem">
                                        <span class="ml-4 mt-1">
                                            <input type="checkbox"
                                                name="categories[]"
                                                value="{{ $category['id'] }}"
                                                @checked(in_array($category['id'], $transactionCategoriesIds))
                                                />
                                        </span>
                                        <span class="ml-2 mt-1">{{ $category['name'] }}</span>
                                    </span>
                                @endforeach
                            </div>

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
