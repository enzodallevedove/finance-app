<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="transactions-filters">
                        <form method="GET" action="{{ route('transactions.index') }}">
                            <div class="fieldsets">
                                <fieldset class="payment-options">
                                    <legend class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                        Payment Options
                                    </legend>

                                    <div class="payment-options">
                                        @foreach ($paymentOptions as $paymentOption)
                                            <div class="payment-option">
                                                <input type="checkbox"
                                                        name="payment_options[]"
                                                        value="{{ $paymentOption->id }}"
                                                        class="payment-option-checkbox"
                                                        {{ in_array($paymentOption->id,request()->payment_options ?? []) ? 'checked' : ''}}
                                                    >
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                                    {{ $paymentOption->name }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </fieldset>

                                <fieldset class="date-range">
                                    <legend class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                        Date Range
                                    </legend>
                                    <div class="date-range
                                        @if (request()->date_from || request()->date_to)
                                            active
                                        @endif
                                    ">
                                        <div class="date-from">
                                            <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                Start Date
                                            </label>
                                            <input type="date"
                                                name="date_from"
                                                id="date_from"
                                                value="{{ request()->date_from }}"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200"
                                            >
                                        </div>

                                        <div class="date-to">
                                            <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-200">End Date</label>
                                            <input type="date"
                                                name="date_to"
                                                id="date_to"
                                                value="{{ request()->date_to }}"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200"
                                            >
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="actions">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    {{ __('Filter') }}
                                </button>
                                <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    <a href="{{ route('transactions.index') }}" class="text-white
                                        dark:text-gray-800">{{ __('Clear') }}
                                    </a>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="w-full flex justify-end mt-4 mb-8">
                        <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Add Transaction') }}
                        </a>
                    </div>

                    <div class="transactions">
                        @foreach ($transactionsByDate as $date => $transactions)
                            <div class="block">
                                <span class="date">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y') }}</span>
                                <div class="transaction-list">
                                    @foreach ($transactions as $transaction)
                                        <div class="transaction">
                                            <span class="title">
                                                <span>{{ $transaction->name }}</span>
                                            </span>

                                            <span class="price @if ($transaction->value > 0) positive @else negative @endif">
                                                <span>{{ 'R$ ' . number_format($transaction->value, 2, ',', '.') }}</span>
                                            </span>

                                            <span class="date">
                                                <span>{{
                                                    \Carbon\Carbon::parse($transaction->date)
                                                        ->translatedFormat('j \\of F \\of Y \\ \\a\\t H:i')
                                                }}</span>
                                            </span>

                                            <span class="payment-option">
                                                <span style="color: {{ $transaction->paymentOption->color }}">{{ $transaction->paymentOption->name }}</span>
                                            </span>

                                            <span class="details">
                                                <a href="{{ route('transactions.show', ['transaction' => $transaction->id]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                    {{ __('Details') }}
                                                </a>
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
