<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Entrada Rápida de Transações') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class=" batch-container text-white">
                        <form class="batch-form" action="{{ route('transactions.batch.store') }}" method="POST">
                            @csrf

                            <table class="table table-dark table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Valor (positivo ou negativo)</th>
                                        <th>Data e hora</th>
                                        <th>Categoria</th>
                                        <th>Payment Option</th>
                                        <th style="width: 20%">Ação</th>
                                    </tr>
                                </thead>
                                <tbody id="transactions-body">
                                    @for ($i = 0; $i < 3; $i++)
                                        <tr>
                                            <td>
                                                <x-text-input name="transactions[{{ $i }}][name]" required
                                                    class="block mt-1 w-full" />
                                            </td>
                                            <td>
                                                <x-text-input name="transactions[{{ $i }}][value]" required
                                                    class="block mt-1 w-full transaction-value" />
                                            </td>
                                            <td>
                                                <x-text-input id="date" type="datetime-local"
                                                    name="transactions[{{ $i }}][date]" autocomplete="date"
                                                    class="block mt-1 w-full" required />
                                            </td>
                                            <td>
                                                <select name="transactions[{{ $i }}][category_id]" class="form-control">
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="transactions[{{ $i }}][payment_option_id]"
                                                    class="form-control">
                                                    @foreach ($paymentOptions as $option)
                                                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="removeRow(this)">🗑</button>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>

                            <div class="flex items-center justify-end mt-4">
                                <button type="button" class="btn btn-secondary mb-3" onclick="addRow()">
                                    + Adicionar linha
                                </button>
                                <x-primary-button class="ml-4">
                                    {{ __('Salvar Transações') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let rowCount = {{ $i }};

        function addRow() {
            const tbody = document.getElementById('transactions-body');
            const row = document.createElement('tr');

            row.innerHTML = `
                <td>
                    <x-text-input
                        name="transactions[${rowCount}][name]"
                        required
                        class="block mt-1 w-full"
                    />
                </td>
                <td>
                    <x-text-input
                        name="transactions[${rowCount}][value]"
                        required
                        class="block mt-1 w-full transaction-value"
                    />
                </td>
                <td>
                    <x-text-input id="date"
                        type="datetime-local"
                        name="transactions[${rowCount}][date]"
                        autocomplete="date"
                        class="block mt-1 w-full"
                        required
                    />
                </td>
                <td>
                    <select name="transactions[${rowCount}][category_id]" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="transactions[${rowCount}][payment_option_id]" class="form-control">
                        @foreach ($paymentOptions as $option)
                            <option value="{{ $option->id }}">{{ $option->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">🗑</button></td>
            `;
            tbody.appendChild(row);
            rowCount++;
        }

        function removeRow(button) {
            button.closest('tr').remove();
        }
    </script>

    <script>
        $(document).ready(function () {
            $('.transaction-value').on('input', function (e) {
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

            $('.transaction-value').on('keydown', function (e) {
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

            $('form').on('submit', function (e) {
                let inputs = $('.transaction-value');

                $.each(inputs,function(){
                    let input = $(this);
                    // Get the value from the input
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
            });

            // Initialize with empty or existing value
            $('.transaction-value').trigger('input');
        });
    </script>
</x-app-layout>
