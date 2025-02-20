<?php
include("../database/dbconn.php");

$query = "SELECT * FROM accounts";
$result = mysqli_query($conn, $query);
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
