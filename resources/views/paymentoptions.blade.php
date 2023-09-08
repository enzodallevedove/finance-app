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
                    <table class="payment-options-table">
                        <thead>
                            <tr>
                                <th>
                                    <h3>Name</h3>
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