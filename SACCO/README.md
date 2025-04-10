# Data Structures-Based SACCO Management System

## Project Overview
This is a web-based SACCO (Savings and Credit Cooperative Organization) Management System for rural farmers. The system utilizes efficient data structures to manage financial transactions, maintaining high performance for deposits, withdrawals, and statement retrieval operations.

## Features
- User authentication for farmers
- Deposit money into accounts
- Withdraw money with balance validation
- View transaction history with filtering options
- Check account balance
- Performance analysis of various data structures

## Technical Implementation
The system implements the following data structures:
- **Linked List**: For maintaining deposit history
- **Stack**: For transaction history with LIFO (Last In First Out) access
- **Hash Map**: For efficient balance lookup and updates

## Installation Instructions
1. Clone this repository to your web server directory
2. Ensure PHP 7.4+ is installed on your server
3. No database setup is required as this uses session-based storage (for demonstration purposes)
4. Access the application via web browser

## Usage
1. Login using one of the demo farmer IDs (1001, 1002, 1003)
2. Navigate through the system using the menu options
3. Make deposits and withdrawals
4. View your transaction history and account balance
5. Check the performance analysis page to see data structure benchmarks

## Performance Considerations
- The system uses in-memory data structures for high-speed transaction processing
- A performance analysis page demonstrates the efficiency of different data structures
- For a production environment, persistent storage would be implemented

## Future Enhancements
- Database integration for persistent storage
- Report generation features
- Admin panel for SACCO management
- Mobile-responsive design improvements
- Two-factor authentication for enhanced security

## Credits
Developed as part of a data structures course project.