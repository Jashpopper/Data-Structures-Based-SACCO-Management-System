<?php
require_once 'includes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit;
}

$farmerId = $_SESSION['current_farmer_id'];
$farmerName = getFarmerName($farmerId);

// Get filter parameters
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

// Get transactions
if ($startDate && $endDate) {
    $transactions = getAccountStatement($farmerId, null, $startDate, $endDate);
} else {
    $transactions = getAccountStatement($farmerId, $limit);
}

require_once 'includes/header.php';
?>

<h2>Account Statement</h2>

<div class="form-container">
    <h3>Filter Transactions</h3>
    
    <form method="get" action="">
        <div style="display: flex; gap: 10px; margin-bottom: 15px;">
            <div class="form-group" style="flex: 1;">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="<?php echo $startDate; ?>">
            </div>
            
            <div class="form-group" style="flex: 1;">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="<?php echo $endDate; ?>">
            </div>
            
            <div class="form-group" style="flex: 1;">
                <label for="limit">Limit:</label>
                <select id="limit" name="limit" class="form-control">
                    <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>Last 10</option>
                    <option value="20" <?php echo $limit == 20 ? 'selected' : ''; ?>>Last 20</option>
                    <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>Last 50</option>
                    <option value="100" <?php echo $limit == 100 ? 'selected' : ''; ?>>Last 100</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn">Filter</button>
            <a href="statement.php" class="btn btn-danger">Reset</a>
        </div>
    </form>
</div>

<div class="form-container">
    <h3>Transactions</h3>
    
    <?php if (empty($transactions)): ?>
        <p>No transactions found for the selected period.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Date/Time</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Balance Impact</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <td><?php echo $transaction['timestamp']; ?></td>
                        <td><?php echo ucfirst($transaction['type']); ?></td>
                        <td>$<?php echo number_format(abs($transaction['amount']), 2); ?></td>
                        <td style="color: <?php echo $transaction['amount'] > 0 ? 'green' : 'red'; ?>">
                            <?php echo $transaction['amount'] > 0 ? '+' : '-'; ?>$<?php echo number_format(abs($transaction['amount']), 2); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    
    <a href="dashboard.php" class="btn">Back to Dashboard</a>
</div>

<?php require_once 'includes/footer.php'; ?>