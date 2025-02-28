<?php
include("../database/dbconn.php");

$query = "SELECT transactions.id, transactions.tanggal, categories.nama_kategori AS category, 
                 transactions.type, transactions.nominal
          FROM transactions
          JOIN categories ON transactions.category_id = categories.id
          ORDER BY transactions.tanggal DESC";

$result = mysqli_query($conn, $query);

$transactions = [];

while ($row = mysqli_fetch_assoc($result)) {
    $transactions[] = $row;
}

echo json_encode($transactions);
