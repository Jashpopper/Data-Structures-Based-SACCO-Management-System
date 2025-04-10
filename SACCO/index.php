<?php
require_once 'includes/functions.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $farmerId = $_POST['farmer_id'] ?? '';
    
    if (loginFarmer($farmerId)) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid Farmer ID';
    }
}

require_once 'includes/header.php';
?>

<div class="form-container">
    <h2>Farmer Login</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="post" action="">
        <div class="form-group">
            <label for="farmer_id">Farmer ID:</label>
            <input type="text" id="farmer_id" name="farmer_id" class="form-control" required>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn">Login</button>
        </div>
    </form>
    
    <div class="signup-link">
        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>
    
    <div class="test-ids">
        <p>For testing, use any of these IDs: 1001, 1002 , 1003</p>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>