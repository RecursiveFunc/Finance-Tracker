<?php
include("../database/dbconn.php");

$id = $_POST['id'];
$new_nominal = $_POST['nominal'];

// Ambil transaksi lama
$sql = "SELECT nominal, type, account_id FROM transactions WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$transaction = $result->fetch_assoc();

$old_nominal = $transaction['nominal'];
$type = $transaction['type'];
$account_id = $transaction['account_id'];

// Hitung selisih perubahan nominal
$selisih = $new_nominal - $old_nominal;

// Update nominal di tabel transactions
$update_sql = "UPDATE transactions SET nominal = ? WHERE id = ?";
$stmt_update = $conn->prepare($update_sql);
$stmt_update->bind_param("ii", $new_nominal, $id);
$stmt_update->execute();

// Update saldo akun berdasarkan selisihnya
if ($type == "Income") {
    $update_account_sql = "UPDATE accounts SET nominal = nominal + ? WHERE id = ?";
} else {
    $update_account_sql = "UPDATE accounts SET nominal = nominal - ? WHERE id = ?";
}
$stmt_update_account = $conn->prepare($update_account_sql);
$stmt_update_account->bind_param("ii", $selisih, $account_id);
$stmt_update_account->execute();

echo json_encode(["status" => "success"]);
$conn->close();
