<?php
header('Content-Type: application/json');
require 'db.php';
$sql = "SELECT * FROM tickets ORDER BY created_at DESC";
$result = $conn->query($sql);
$tickets = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $row['used'] = $row['used'] == 1 ? true : false;
        $row['price_paid'] = (int)$row['price_paid'];
        $tickets[] = $row;
    }
}
echo json_encode($tickets);
$conn->close();
?>