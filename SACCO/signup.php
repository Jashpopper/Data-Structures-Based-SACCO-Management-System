<?php
require_once 'includes/config.php'; // Include config.php (which starts the session)
require_once 'includes/functions.php';

$error = ''; // Variable to store error messages

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $farmer_id = $_POST['farmer_id'];

    // Attempt to register the farmer
    if (registerFarmer($name, $email, $password, $farmer_id)) {
        // Log the farmer in automatically by setting session variables
        $_SESSION['logged_in'] = true;
        $_SESSION['current_farmer_id'] = $farmer_id; // Store the farmer's ID in session

        // Redirect to the farmer's dashboard after successful registration
        header('Location: dashboard.php');
        exit;
    } else {
        // Display an error message if registration fails
        $error = 'Registration failed. Please check your inputs or use a different Farmer ID.';
    }
}

require_once 'includes/header.php'; // Include the header
?>

<div class="form-container">
    <h2>Farmer Sign Up</h2>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="post" action="">
        <div class="form-group">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="farmer_id">Farmer ID:</label>
            <input type="text" id="farmer_id" name="farmer_id" class="form-control" required>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn">Sign Up</button>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; // Include the footer ?>
