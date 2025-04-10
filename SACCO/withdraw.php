<?php
require_once 'includes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit;
}

$farmerId = $_SESSION['current_farmer_id'];
$farmerName = getFarmerName($farmerId);
$balance = checkBalance($farmerId);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount'] ?? 0);
    $result = makeWithdrawal($farmerId, $amount);
    if ($result['success']) {
        $balance = checkBalance($farmerId); // Update balance after withdrawal
    }
}

require_once 'includes/header.php';
?>

<h2>Make a Withdrawal</h2>

<div class="form-container">
    <div class="card" style="margin-bottom: 20px;">
        <div class="card-title">Current Balance</div>
        <div class="card-value">$<?php echo number_format($balance, 2); ?></div>
    </div>
    
    <?php if (isset($result)): ?>
        <div class="alert <?php echo $result['success'] ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo $result['message']; ?>
        </div>
    <?php endif; ?>
    
    <form method="post" action="">
        <div class="form-group">
            <label for="amount">Withdrawal Amount (UGX):</label>
            <input type="number" id="amount" name="amount" min="0.01" step="0.01" max="<?php echo $balance; ?>" class="form-control" required>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn">Make Withdrawal</button>
            <a href="dashboard.php" class="btn btn-danger">Cancel</a>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>