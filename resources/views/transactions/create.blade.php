<!DOCTYPE html>
<html>
<head><title>New Transaction</title></head>
<body>
    <h1>New Transaction</h1>

    @if ($errors->any())
        <div style="color:red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('transactions.store') }}">
        @csrf

        <label>Account:</label>
        <select name="account_id">
            @foreach ($accounts as $account)
                <option value="{{ $account->id }}">
                    {{ $account->account_number }} (Balance: {{ $account->balance }})
                </option>
            @endforeach
        </select><br><br>

        <label>Type:</label>
        <select name="type">
            <option value="deposit">Deposit</option>
            <option value="withdrawal">Withdrawal</option>
        </select><br><br>

        <label>Amount:</label>
        <input type="number" step="0.01" name="amount" value="{{ old('amount') }}"><br><br>

        <label>Notes:</label>
        <textarea name="notes">{{ old('notes') }}</textarea><br><br>

        <button type="submit">Submit</button>
    </form>

    <br><a href="{{ route('transactions.index') }}">View Transactions</a>
</body>
</html>