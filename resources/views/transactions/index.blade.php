<!DOCTYPE html>
<html>
<head><title>Transactions</title></head>
<body>
    <h1>Transactions</h1>

    @if (session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    <a href="{{ route('transactions.create') }}">+ New Transaction</a>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Account</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Reference</th>
            <th>Date</th>
        </tr>
        @foreach ($transactions as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td>{{ $t->account->account_number }}</td>
                <td>{{ $t->type }}</td>
                <td>{{ $t->amount }}</td>
                <td>{{ $t->reference_number }}</td>
                <td>{{ $t->created_at }}</td>
            </tr>
        @endforeach
    </table>

    {{ $transactions->links() }}
</body>
</html>