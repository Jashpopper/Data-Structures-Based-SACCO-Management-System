<?php
require_once 'data_structures.php';
require_once 'config.php';

// Function to handle deposits
function makeDeposit($farmerId, $amount) {
    if ($amount <= 0) {
        return ['success' => false, 'message' => 'Amount must be greater than zero'];
    }
    
    // Update the linked list of deposits
    $deposits = getDeposits();
    $deposits->insert($farmerId, $amount);
    saveDeposits($deposits);
    
    // Update the stack of transactions
    $transactions = getTransactions();
    $transactions->push($farmerId, $amount, 'deposit');
    saveTransactions($transactions);
    
    // Update the hash map of balances
    $balances = getBalances();
    $balances->update($farmerId, $amount);
    saveBalances($balances);
    
    return ['success' => true, 'message' => 'Deposit of $' . number_format($amount, 2) . ' was successful'];
}

// Function to handle withdrawals
function makeWithdrawal($farmerId, $amount) {
    if ($amount <= 0) {
        return ['success' => false, 'message' => 'Amount must be greater than zero'];
    }
    
    // Check if sufficient balance
    $balances = getBalances();
    $currentBalance = $balances->get($farmerId);
    
    if ($currentBalance < $amount) {
        return ['success' => false, 'message' => 'Insufficient balance. Current balance: $' . number_format($currentBalance, 2)];
    }
    
    // Update the stack of transactions
    $transactions = getTransactions();
    $transactions->push($farmerId, -$amount, 'withdrawal');
    saveTransactions($transactions);
    
    // Update the hash map of balances
    $balances->update($farmerId, -$amount);
    saveBalances($balances);
    
    return ['success' => true, 'message' => 'Withdrawal of $' . number_format($amount, 2) . ' was successful'];
}

// Function to get account statement
function getAccountStatement($farmerId, $limit = 10, $startDate = null, $endDate = null) {
    $transactions = getTransactions();
    
    if ($startDate && $endDate) {
        return $transactions->getTransactionsByDateRange($farmerId, $startDate, $endDate);
    } else {
        return $transactions->getLastNTransactions($farmerId, $limit);
    }
}

// Function to check balance
function checkBalance($farmerId) {
    $balances = getBalances();
    return $balances->get($farmerId);
}

// Function to get farmer name
function getFarmerName($farmerId) {
    if (isset($_SESSION['farmers'][$farmerId])) {
        return $_SESSION['farmers'][$farmerId]['name'];
    }
    return 'Unknown Farmer';
}

// Simple login function
function loginFarmer($farmerId) {
    if (isset($_SESSION['farmers'][$farmerId])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['current_farmer_id'] = $farmerId;
        return true;
    }
    return false;
}

// Logout function
function logoutFarmer() {
    $_SESSION['logged_in'] = false;
    $_SESSION['current_farmer_id'] = null;
}

// Function to register a new farmer
function registerFarmer($name, $email, $password, $farmerId) {
    // Validate inputs
    if (empty($name) || empty($email) || empty($password) || empty($farmerId)) {
        return false; // Return false if any field is empty
    }

    // Check if farmer ID already exists
    if (isset($_SESSION['farmers'][$farmerId])) {
        return false; // Return false if farmer ID is already taken
    }

    // Store farmer data in session (for demonstration purposes)
    $_SESSION['farmers'][$farmerId] = [
        'name' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT), // Hash the password
        'balance' => 0, // Initialize balance
        'transactions' => [] // Initialize transaction history
    ];

    // Initialize data structures for the new farmer
    $deposits = getDeposits();
    $deposits->insert($farmerId, 0); // Initialize with zero deposit
    saveDeposits($deposits);

    $transactions = getTransactions();
    $transactions->push($farmerId, 0, 'initialization'); // Initialize with a zero transaction
    saveTransactions($transactions);

    $balances = getBalances();
    $balances->update($farmerId, 0); // Initialize with zero balance
    saveBalances($balances);

    return true; // Return true if registration is successful
}
?>