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
					<canvas id="current-assets"></canvas>
				</div>
			</div>
		</div>
	</div>

	<script>
		const ctx = document.getElementById('current-assets');

		new Chart(ctx, {
			type: 'bar',
			data: {
				labels: [
					@foreach ($paymentOptions as $paymentOption)
						'{{$paymentOption->name}}',
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
	</script>
</x-app-layout>
