<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Bill') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('bills.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus
                                autocomplete="name" class="block mt-1 w-full" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="value" :value="__('Value')" />

                            <x-text-input id="value" type="number" name="value" step="0.01" required
                                autocomplete="value" class="block mt-1 w-full" />

                            <x-input-error :messages="$errors->get('value')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />

                            <textarea id="description" name="description" autocomplete="description" rows="4"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>

                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="paymentoption_id" :value="__('Payment Option')" />

                            <select name="paymentoption_id" required
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach ($paymentOptions as $paymentOption)
                                <option value="{{ $paymentOption->id }}"
                                    @selected(old('paymentOption')==$paymentOption)>
                                    {{ $paymentOption->name }}
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
</x-app-layout>