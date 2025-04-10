
<?php
// Include the file that defines the data structures
require_once 'data_structures.php';

// Start the session
session_start();

// Initialize our data structures if they don't exist in the session
if (!isset($_SESSION['deposits'])) {
    $_SESSION['deposits'] = serialize(new LinkedList());
}

if (!isset($_SESSION['transactions'])) {
    $_SESSION['transactions'] = serialize(new Stack());
}

if (!isset($_SESSION['balances'])) {
    $_SESSION['balances'] = serialize(new HashMap());
}

// Add some sample data if none exists
if (getBalances()->get('1001') == 0 && getBalances()->get('1002') == 0 && getBalances()->get('1003') == 0) {
    // Add sample transactions for farmer 1001
    makeDeposit('1001', 5000);
    makeDeposit('1001', 2500);
    makeWithdrawal('1001', 1200);
    makeDeposit('1001', 1000);
    
    // Add sample transactions for farmer 1002
    makeDeposit('1002', 7500);
    makeDeposit('1002', 3000);
    makeWithdrawal('1002', 2000);
    
    // Add sample transactions for farmer 1003
    makeDeposit('1003', 10000);
    makeWithdrawal('1003', 4500);
    makeDeposit('1003', 2000);
}

// Helper function to get our data structures from the session
function getDeposits() {
    return unserialize($_SESSION['deposits']);
}

function getTransactions() {
    return unserialize($_SESSION['transactions']);
}

function getBalances() {
    return unserialize($_SESSION['balances']);
}

// Helper function to save our data structures back to the session
function saveDeposits($deposits) {
    $_SESSION['deposits'] = serialize($deposits);
}

function saveTransactions($transactions) {
    $_SESSION['transactions'] = serialize($transactions);
}

function saveBalances($balances) {
    $_SESSION['balances'] = serialize($balances);
}

// For simplicity, we'll use a simple array to store farmer information
if (!isset($_SESSION['farmers'])) {
    $_SESSION['farmers'] = [
        '1001' => ['name' => 'NALUNKUMA ANISHA', 'phone' => '0712345678'],
        '1002' => ['name' => 'DELMA SERUGGO', 'phone' => '0723456789'],
        '1003' => ['name' => 'KEMYLINE ERIKA', 'phone' => '0734567890']
    ];
}

// For a real application, you would validate user login
if (!isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in'] = false;
    $_SESSION['current_farmer_id'] = null;
}

// Constants
define('SITE_NAME', 'Farmers SACCO Management System');
?> 