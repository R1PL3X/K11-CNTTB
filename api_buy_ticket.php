<?php
header('Content-Type: application/json');
require 'db.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($data->code)) {
    $stmt = $conn->prepare("INSERT INTO tickets (code, customer_name, customer_email, event_name, ticket_type, price_paid, seat, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("sssssiss", 
        $data->code, $data->customerName, $data->customerEmail, 
        $data->eventName, $data->ticketTypeName, $data->pricePaid, 
        $data->seat, $data->paymentMethod
    );
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
    $stmt->close();
}
$conn->close();
?>