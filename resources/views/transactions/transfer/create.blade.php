<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Transfer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="w-full flex justify-end mt-4 mb-10">
                        <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Normal Transaction') }}
                        </a>
                    </div>
                    <form method="POST" action="{{ route('transactions.transfer.store') }}">
                        @csrf

                        <div class="mt-4">
                            <x-input-label for="value" :value="__('Value')" />

                            <x-text-input id="value"
                                type="text"
                                name="value"
                                required
                                autocomplete="value"
                                class="block mt-1 w-full"
                            />

                            <x-input-error :messages="$errors->get('value')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />

                            <textarea id="description" name="description" autocomplete="description" rows="4"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>

                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="date" :value="__('Date')" />

                            <x-text-input id="date"
                                type="datetime-local"
                                name="date"
                                autocomplete="date"
                                class="block mt-1 w-full" />

                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="paymentoption_origin_id" :value="__('Origin')" />

                            <select name="paymentoption_origin_id" required
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach ($paymentOptions as $paymentOption)
                                <option value="{{ $paymentOption->id }}"
                                    @selected(old('paymentOption')==$paymentOption)>
                                    {{ $paymentOption->name }} | {{'R$ ' . number_format($paymentOption->balance, 2, ',', '.')}}
                                </option>
                                @endforeach
                            </select>

                            <x-input-error :messages="$errors->get('paymentoption_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="paymentoption_destination_id" :value="__('Destination')" />

                            <select name="paymentoption_destination_id" required
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach ($paymentOptions as $paymentOption)
                                <option value="{{ $paymentOption->id }}"
                                    @selected(old('paymentOption')==$paymentOption)>
                                    {{ $paymentOption->name }} | {{'R$ ' . number_format($paymentOption->balance, 2, ',', '.')}}
                                </option>
                                @endforeach
                            </select>

                            <x-input-error :messages="$errors->get('paymentoption_id')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Create') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#value').on('input', function(e) {
                let value = $(this).val();
                let isNegative = value.startsWith('-');
                // Remove all non-digits (but keep minus sign if present)
                value = value.replace(/[^\d-]/g, '');

                if (!value || value === '-') {
                    $(this).val('0,00');
                    return;
                }

                // Remove any extra minus signs and ensure it's only at the start
                value = value.replace(/-/g, '');
                value = (parseInt(value) / 100).toFixed(2);

                // Format with thousand separators and comma decimal
                value = value.replace('.', ',');
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                // Add negative sign if needed
                if (isNegative) {
                    value = '-' + value;
                }

                $(this).val(value);
            });

            $('#value').on('keydown', function(e) {
                if (e.key === '-' || e.key === '+') {
                    e.preventDefault();
                    let currentValue = $(this).val();
                    if (currentValue.startsWith('-')) {
                        $(this).val(currentValue.substring(1));
                    } else {
                        $(this).val('-' + currentValue);
                    }
                }
            });

            $('form').on('submit', function(e) {
                let input = $('#value');
                let value = input.val();

                // Remove thousand separators and convert comma to dot
                value = value.replace(/\./g, '').replace(',', '.');
                // Create a hidden input with the formatted value
                $('<input>').attr({
                    type: 'hidden',
                    name: input.attr('name'),
                    value: value
                }).appendTo($(this));

                // Clear the original input so it doesn't send the formatted version
                input.removeAttr('name');
            });

            // Initialize with empty or existing value
            $('#value').trigger('input');
        });
    </script>
</x-app-layout>
