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
