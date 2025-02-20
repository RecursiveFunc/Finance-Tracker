<?php
include("../database/dbconn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jenisTabungan = $_POST['savingsType'];
    $nominal = $_POST['savingsAmount'];

    // Query insert data
    $query = "INSERT INTO accounts (jenis_tabungan, nominal) VALUES ('$jenisTabungan', '$nominal')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "success";
    } else {
        echo "error";
    }
}
