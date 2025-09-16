<h2>Hi {{ $order->user->name }},</h2>
<p>Thank you for your order #{{ $order->id }}.</p>
<p>Total Amount: ${{ number_format($order->total_amount, 2) }}</p>
<p>We’ll notify you once it’s shipped.</p>
