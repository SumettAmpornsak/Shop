<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "warehouse_system";

// สร้างการเชื่อมต่อ
$conn = mysqli_connect($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error()); // แสดงข้อผิดพลาดการเชื่อมต่อ
}

// ตั้งค่าชุดอักขระเป็น UTF-8 เพื่อรองรับภาษาไทย
mysqli_set_charset($conn, "utf8");

// แสดงข้อความว่าการเชื่อมต่อสำเร็จ
echo "Connected successfully";

// เมื่อไม่ใช้งานการเชื่อมต่อ สามารถปิดการเชื่อมต่อได้
// mysqli_close($conn);
?>
