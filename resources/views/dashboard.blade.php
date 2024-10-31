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
					{{ __("You're logged in!") }}
				</div>
				<div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3>{{ __('Total balance by Payment Option') }}</h3>
					<canvas id="current-assets"></canvas>
				</div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3>{{ __('Total expenses per Category in the current month') }}</h3>
					<canvas id="expenses-per-category"></canvas>
				</div>
			</div>
		</div>
	</div>

	<script>
		const currentAssetsChart = document.getElementById('current-assets');
        const expensesPerCategoryThisMonth = document.getElementById('expenses-per-category');

		new Chart(currentAssetsChart, {
			type: 'bar',
			data: {
				labels: [
					@foreach ($paymentOptions as $paymentOption)
						'{{
                            strlen($paymentOption->name) > 22
                            ? substr($paymentOption->name, 0, 22) . "..."
                            : $paymentOption->name
                        }}',
					@endforeach
				],
				datasets: [{
					label: 'Current Assets',
					data: [
						@foreach ($paymentOptions as $paymentOption)
                            '{{$paymentOption->balance}}',
						@endforeach
					],
					backgroundColor: [
						@foreach ($paymentOptions as $paymentOption)
                            '{{$paymentOption->color ?? "#FFFFFF" }}',
						@endforeach

					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});

        new Chart(expensesPerCategoryThisMonth, {
			type: 'bar',
			data: {
				labels: [
					@foreach ($expensesPerCategoryThisMonth as $expensePerCategory)
						'{{$expensePerCategory->name}}',
					@endforeach
				],
				datasets: [{
					label: 'Current Assets',
					data: [
						@foreach ($expensesPerCategoryThisMonth as $expensePerCategory)
                            '{{$expensePerCategory->total_value}}',
						@endforeach
					],
					backgroundColor: [
						@foreach ($expensesPerCategoryThisMonth as $expensePerCategory)
                            '{{ "#FFFFFF" }}',
						@endforeach

					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});
	</script>
</x-app-layout>
