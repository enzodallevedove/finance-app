@props(['paymentOption'])

<li>
    <span class="payment-option-name {{ $paymentOption['children'] ? 'caret' : '' }}">
        <a href="{{
            route(
                'paymentoptions.show',
                ['paymentoption' => $paymentOption['id']]
            )
        }}">
            <span class="name"
                style="color: {{ $paymentOption['color'] }}">
                {{ $paymentOption['name'] }}
            </span>

            @if ($paymentOption['balance'] != 0)
                <span class="balance price-amount {{ $paymentOption['balance'] >= 0 ? 'positive' : 'negative' }}">
                    R$ {{ $paymentOption['balance'] }}
                </span>
            @endif
        </a>
    </span>
    @if (!empty($paymentOption['children']))
        <ul>
            @foreach ($paymentOption['children'] as $child)
                <x-payment-option-item :paymentOption="$child" />
            @endforeach
        </ul>
    @endif
</li>
