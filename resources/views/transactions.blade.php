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
                    <table class="transactions-table">
                        <thead>
                            <tr>
                                <th><h3>Name</h3></th>
                                <th><h3>Value</h3></th>
                                <th><h3>Description</h3></th>
                                <th><h3>Date</h3></th>
                                <th style="display: none">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="wider-column"><h4>{{ $transaction->name }}</h4></td>
                                    <td class="wider-column"><h4>{{ $transaction->value }}</h4></td>
                                    <td class="wider-column"><h4>{{ date('H:i d-m-Y', strtotime($transaction->date)) }}</h4></td>
                                    <td class="crud-icons">
                                        <button>Edit</button>
                                        <button>Delete</button>
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