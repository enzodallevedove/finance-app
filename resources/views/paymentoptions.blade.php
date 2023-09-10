<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payment Options') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="w-full flex justify-end mt-4 mb-8">
                        <a href="{{ route('paymentoptions.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Add Payment Option') }}
                        </a>
                    </div>

                    <table class="payment-options-table">
                        <thead>
                            <tr>
                                <th>
                                    <h3>Name</h3>
                                </th>
                                <th>
                                    <h3>Balance</h3>
                                </th>
                                <th style="display: none">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paymentOptions as $paymentOption)
                            <tr>
                                <td class="wider-column">
                                    <h4>{{ $paymentOption->name }}</h4>
                                </td>
                                <td class="wider-column">
                                    <h4>{{ 'R$ ' . number_format($paymentOption->balance, 2, ',', '.') }}</h4>
                                </td>
                                <td class="crud-icons">
                                    <a href="{{ route('paymentoptions.show', ['paymentoption' => $paymentOption->id]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        {{ __('Details') }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>