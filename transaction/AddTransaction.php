<?php
include("../database/dbconn.php");

$type = $_POST['type'];
$account_id = intval($_POST['account_id']);  // Pastikan integer
$category_id = intval($_POST['category_id']);
$nominal = intval($_POST['nominal']);
$date = isset($_POST['date']) ? $_POST['date'] : date("Y-m-d");

$response = []; // Array untuk menyimpan status response

try {
    // Insert transaksi ke tabel transactions
    $sql = "INSERT INTO transactions (tanggal, category_id, type, nominal, account_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisii", $date, $category_id, $type, $nominal, $account_id);

    if (!$stmt->execute()) {
        throw new Exception("Gagal menyimpan transaksi.");
    }

    // Update nominal di tabel accounts
    if ($type == "Income") {
        $update_sql = "UPDATE accounts SET nominal = nominal + ? WHERE id = ?";
    } else {
        $update_sql = "UPDATE accounts SET nominal = nominal - ? WHERE id = ?";
    }
    $stmt_update = $conn->prepare($update_sql);
    $stmt_update->bind_param("ii", $nominal, $account_id);

    if (!$stmt_update->execute()) {
        throw new Exception("Gagal memperbarui saldo akun.");
    }

    $response["status"] = "success";
} catch (Exception $e) {
    $response["status"] = "error";
    $response["message"] = $e->getMessage();
}

echo json_encode($response);
$conn->close();
