<h2>Hi {{ $order->user->name }},</h2>
<p>Your order #{{ $order->id }} has been refunded.</p>
<p>Refund Amount: ${{ number_format($order->total_amount, 2) }}</p>
<p>We’re sorry for the inconvenience.</p>
