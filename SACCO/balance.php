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

require_once 'includes/header.php';
?>

<h2>Account Balance</h2>

<div class="form-container">
    <div style="text-align: center; padding: 30px 0;">
        <h3>Current Balance for <?php echo $farmerName; ?></h3>
        <div style="font-size: 48px; color: #27ae60; margin: 20px 0;">
            $<?php echo number_format($balance, 2); ?>
        </div>
        <p>Farmer ID: <?php echo $farmerId; ?></p>
    </div>
    
    <div style="display: flex; gap: 10px; justify-content: center;">
        <a href="deposit.php" class="btn">Make Deposit</a>
        <a href="withdraw.php" class="btn">Make Withdrawal</a>
        <a href="dashboard.php" class="btn btn-danger">Back to Dashboard</a>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>