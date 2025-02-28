<?php
include("../database/dbconn.php");

$id = $_POST['id'];
$nominal = $_POST['nominal'];
$type = $_POST['type'];

// Ambil akun terkait
$sql = "SELECT account_id FROM transactions WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$transaction = $result->fetch_assoc();
$account_id = $transaction['account_id'];

// Hapus transaksi
$delete_sql = "DELETE FROM transactions WHERE id = ?";
$stmt_delete = $conn->prepare($delete_sql);
$stmt_delete->bind_param("i", $id);
$stmt_delete->execute();

// Kembalikan saldo akun
if ($type == "Income") {
    $update_sql = "UPDATE accounts SET nominal = nominal - ? WHERE id = ?";
} else {
    $update_sql = "UPDATE accounts SET nominal = nominal + ? WHERE id = ?";
}
$stmt_update = $conn->prepare($update_sql);
$stmt_update->bind_param("ii", $nominal, $account_id);
$stmt_update->execute();

echo json_encode(["status" => "success"]);
$conn->close();
