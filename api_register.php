<?php
header('Content-Type: application/json');
require 'db.php'; // Gọi file kết nối database

// Lấy dữ liệu JSON từ Vue.js gửi lên
$data = json_decode(file_get_contents("php://input"));

if (isset($data->name) && isset($data->email) && isset($data->password)) {
    // 1. Kiểm tra xem email đã tồn tại chưa
    $stmt_check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt_check->bind_param("s", $data->email);
    $stmt_check->execute();
    if ($stmt_check->get_result()->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email đã tồn tại"]);
        exit();
    }

    // 2. Thêm user mới vào database
    // Lưu ý: Ở dự án thực tế, mật khẩu phải được mã hóa (VD: password_hash), ở đây ta dùng text thường cho dễ hiểu theo code cũ của bạn
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')");
    $stmt->bind_param("sss", $data->name, $data->email, $data->password);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Đăng ký thành công"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi hệ thống khi đăng ký"]);
    }
    $stmt->close();
}
$conn->close();
?>