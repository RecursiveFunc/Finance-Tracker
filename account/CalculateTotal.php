<?php
include("../database/dbconn.php"); // Pastikan koneksi database sudah ada

// Query untuk mendapatkan total Assets (nilai positif)
$query_assets = "SELECT SUM(nominal) AS total_assets FROM accounts WHERE nominal > 0";
$result_assets = mysqli_query($conn, $query_assets);
$row_assets = mysqli_fetch_assoc($result_assets);
$total_assets = $row_assets['total_assets'] ?? 0;

// Query untuk mendapatkan total Liabilities (nilai negatif)
$query_liabilities = "SELECT SUM(nominal) AS total_liabilities FROM accounts WHERE nominal < 0";
$result_liabilities = mysqli_query($conn, $query_liabilities);
$row_liabilities = mysqli_fetch_assoc($result_liabilities);
$total_liabilities = abs($row_liabilities['total_liabilities'] ?? 0); // Konversi negatif ke positif

// Hitung Total (Assets - Liabilities)
$total = $total_assets - $total_liabilities;

// Kembalikan data dalam format JSON
echo json_encode([
    "assets" => $total_assets,
    "liabilities" => $total_liabilities,
    "total" => $total
]);
