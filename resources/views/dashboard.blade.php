<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body>
    <h1>Bank Dashboard</h1>

    <p>Total Accounts: <span id="total-accounts">0</span></p>
    <p>Total Money: ₱<span id="total-money">0.00</span></p>
    <p>Transactions Today: <span id="transactions-today">0</span></p>
    <p><small>Auto-updates every 30 seconds.</small></p>

    <a href="/transactions/create">+ New Transaction</a>

    <script>
        function fetchStats() {
            fetch('/api/dashboard/stats')
                .then(res => res.json())
                .then(data => {
                    document.getElementById('total-accounts').textContent = data.total_accounts;
                    document.getElementById('total-money').textContent = data.total_money.toFixed(2);
                    document.getElementById('transactions-today').textContent = data.transactions_today;
                })
                .catch(err => console.error('Polling error:', err));
        }

        fetchStats();                    // unang load
        setInterval(fetchStats, 30000);  // bawat 30 seconds
    </script>
</body>
</html>