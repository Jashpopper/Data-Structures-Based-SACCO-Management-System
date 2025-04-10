<?php
require_once 'includes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit;
}

$farmerId = $_SESSION['current_farmer_id'];
$balance = checkBalance($farmerId);
$recentTransactions = getAccountStatement($farmerId, 5);
$farmerName = getFarmerName($farmerId);

require_once 'includes/header.php';
?>

<h2>Welcome, <?php echo $farmerName; ?></h2>

<div class="dashboard">
    <div class="card">
        <div class="card-title">Current Balance</div>
        <div class="card-value">$<?php echo number_format($balance, 2); ?></div>
    </div>
    
    <div class="card">
        <div class="card-title">Farmer ID</div>
        <div class="card-value"><?php echo $farmerId; ?></div>
    </div>
</div>

<div class="form-container">
    <h3>Quick Actions</h3>
    
    <div style="display: flex; gap: 10px; margin-top: 20px;">
        <a href="deposit.php" class="btn">Make Deposit</a>
        <a href="withdraw.php" class="btn">Make Withdrawal</a>
        <a href="statement.php" class="btn">View Statement</a>
    </div>
</div>

<div class="form-container">
    <h3>Recent Transactions</h3>
    
    <?php if (empty($recentTransactions)): ?>
        <p>No recent transactions found.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Date/Time</th>
                    <th>Type</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentTransactions as $transaction): ?>
                    <tr>
                        <td><?php echo $transaction['timestamp']; ?></td>
                        <td><?php echo ucfirst($transaction['type']); ?></td>
                        <td>$<?php echo number_format(abs($transaction['amount']), 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <a href="statement.php" class="btn">View All Transactions</a>
    <?php endif; ?>
</div>

<!-- Button to View Performance Analysis -->
<div class="form-container">
    <h3>System Performance</h3>
    <p>View the efficiency of different data structures used in transaction management.</p>
    <a href="performance.html" class="btn">View Performance Analysis</a>
</div>

<?php require_once 'includes/footer.php'; ?>
