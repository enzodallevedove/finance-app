<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="p-4 bg-gray-800 rounded-lg shadow">
                            <h3 class="text-sm uppercase text-gray-400">Total spent this month</h3>
                            <p class="text-2xl font-semibold text-green-400">
                                R$ {{ number_format($totalSpentThisMonth, 2, ',', '.') }}
                            </p>
                        </div>

                        <div class="p-4 bg-gray-800 rounded-lg shadow">
                            <h3 class="text-sm uppercase text-gray-400">Daily average</h3>
                            <p class="text-2xl font-semibold text-blue-400">
                                R$ {{ number_format($dailyAverage, 2, ',', '.') }}
                            </p>
                        </div>

                        <div class="p-4 bg-gray-800 rounded-lg shadow">
                            <h3 class="text-sm uppercase text-gray-400">Top category</h3>
                            @if($topCategoryName)
                                <p class="text-xl font-medium text-yellow-400">{{ $topCategoryName }}</p>
                                <p class="text-lg">R$ {{ number_format($topCategoryTotal, 2, ',', '.') }}</p>
                            @else
                                <p class="text-lg text-gray-300">No data</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-10">
                        <h2 class="text-xl text-white mb-4">Gastos por Categoria</h2>
                        <canvas id="categoryChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(ctx, {
            type: 'pie', // ou 'bar' para barras
            data: {
                labels: {!! json_encode($categoryChartLabels) !!},
                datasets: [{
                    label: 'Gastos por categoria',
                    data: {!! json_encode($categoryChartValues) !!},
                    backgroundColor: [
                        '#ef4444', '#f97316', '#eab308', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: '#fff' // deixa o texto branco no gráfico
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
