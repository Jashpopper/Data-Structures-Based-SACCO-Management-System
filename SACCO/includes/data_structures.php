<?php
// LinkedList implementation for deposits
class Node {
    public $farmerId;
    public $amount;
    public $timestamp;
    public $next;
    
    public function __construct($farmerId, $amount) {
        $this->farmerId = $farmerId;
        $this->amount = $amount;
        $this->timestamp = date('Y-m-d H:i:s');
        $this->next = null;
    }
}

class LinkedList {
    public $head;
    
    public function __construct() {
        $this->head = null;
    }
    
    public function insert($farmerId, $amount) {
        $newNode = new Node($farmerId, $amount);
        
        if ($this->head === null) {
            $this->head = $newNode;
            return;
        }
        
        $newNode->next = $this->head;
        $this->head = $newNode;
    }
    
    public function getTransactions($farmerId) {
        $transactions = array();
        $current = $this->head;
        
        while ($current !== null) {
            if ($current->farmerId === $farmerId) {
                $transactions[] = array(
                    'amount' => $current->amount,
                    'timestamp' => $current->timestamp
                );
            }
            $current = $current->next;
        }
        
        return $transactions;
    }
}

// Stack implementation for recent transactions
class Stack {
    private $stack;
    
    public function __construct() {
        $this->stack = array();
    }
    
    public function push($farmerId, $amount, $type, $timestamp = null) {
        $timestamp = $timestamp ?: date('Y-m-d H:i:s');
        array_push($this->stack, array(
            'farmerId' => $farmerId,
            'amount' => $amount,
            'type' => $type,
            'timestamp' => $timestamp
        ));
    }
    
    public function pop() {
        if (empty($this->stack)) {
            return null;
        }
        return array_pop($this->stack);
    }
    
    public function getLastNTransactions($farmerId, $n) {
        $result = array();
        $tempStack = $this->stack;
        
        // Reverse to get most recent first
        $tempStack = array_reverse($tempStack);
        
        foreach ($tempStack as $transaction) {
            if ($transaction['farmerId'] === $farmerId) {
                $result[] = $transaction;
                if (count($result) >= $n) {
                    break;
                }
            }
        }
        
        return $result;
    }
    
    public function getTransactionsByDateRange($farmerId, $startDate, $endDate) {
        $result = array();
        $tempStack = $this->stack;
        
        // Reverse to get most recent first
        $tempStack = array_reverse($tempStack);
        
        foreach ($tempStack as $transaction) {
            if ($transaction['farmerId'] === $farmerId) {
                $transactionDate = strtotime($transaction['timestamp']);
                $startDateTime = strtotime($startDate);
                $endDateTime = strtotime($endDate . ' 23:59:59');
                
                if ($transactionDate >= $startDateTime && $transactionDate <= $endDateTime) {
                    $result[] = $transaction;
                }
            }
        }
        
        return $result;
    }
}

// HashMap implementation for farmer balances
class HashMap {
    private $map;
    
    public function __construct() {
        $this->map = array();
    }
    
    public function put($key, $value) {
        $this->map[$key] = $value;
    }
    
    public function get($key) {
        return isset($this->map[$key]) ? $this->map[$key] : 0;
    }
    
    public function contains($key) {
        return isset($this->map[$key]);
    }
    
    public function remove($key) {
        if (isset($this->map[$key])) {
            unset($this->map[$key]);
        }
    }
    
    public function update($key, $amount) {
        if (isset($this->map[$key])) {
            $this->map[$key] += $amount;
        } else {
            $this->map[$key] = $amount;
        }
    }
}
?>