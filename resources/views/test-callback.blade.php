<!DOCTYPE html>
<html>
<head>
    <title>Test Faspay Callback</title>
</head>
<body>
    <h2>Test Callback Faspay</h2>
    <form action="{{ route('payment.callback') }}" method="POST">
        @csrf
        <label>Bill No:</label>
        <input type="text" name="bill_no" value="test-bill-123"><br><br>
        
        <label>Payment Status Code:</label>
        <input type="text" name="payment_status_code" value="2"><br><br>
        
        <label>TRX ID:</label>
        <input type="text" name="trx_id" value="test-trx-456"><br><br>
        
        <label>Payment Channel:</label>
        <input type="text" name="payment_channel_name" value="Virtual Account BCA"><br><br>
        
        <button type="submit">Send Test Callback</button>
    </form>
</body>
</html>