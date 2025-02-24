<?php
include("../database/dbconn.php"); // Koneksi database

// Pastikan `account_id` didapatkan, misalnya dari session user atau input request
$account_id = isset($_GET['account_id']) ? intval($_GET['account_id']) : 1; // Default ke akun pertama

// Query total income untuk akun tertentu
$sql_income = "SELECT SUM(nominal) AS total_income FROM transactions WHERE type = 'Income' AND account_id = ?";
$stmt_income = $conn->prepare($sql_income);
$stmt_income->bind_param("i", $account_id);
$stmt_income->execute();
$result_income = $stmt_income->get_result()->fetch_assoc();
$total_income = $result_income['total_income'] ?? 0;

// Query total expense untuk akun tertentu
$sql_expense = "SELECT SUM(nominal) AS total_expense FROM transactions WHERE type = 'Expense' AND account_id = ?";
$stmt_expense = $conn->prepare($sql_expense);
$stmt_expense->bind_param("i", $account_id);
$stmt_expense->execute();
$result_expense = $stmt_expense->get_result()->fetch_assoc();
$total_expense = $result_expense['total_expense'] ?? 0;

// Hitung total balance
$total_balance = $total_income - $total_expense;

// Query untuk mendapatkan total aset berdasarkan account_id
$sql_assets = "SELECT SUM(nominal) AS total_assets FROM accounts WHERE id = ?";
$stmt_assets = $conn->prepare($sql_assets);
$stmt_assets->bind_param("i", $account_id);
$stmt_assets->execute();
$result_assets = $stmt_assets->get_result()->fetch_assoc();
$total_assets = $result_assets['total_assets'] ?? 0;

// Kirim response JSON
echo json_encode([
    'total_income' => $total_income,
    'total_expense' => $total_expense,
    'total_balance' => $total_balance
]);

$conn->close();
