<?php
include 'config.php';

// ตั้งค่า timezone
date_default_timezone_set('Asia/Bangkok'); // เปลี่ยนให้ตรงกับโซนเวลาที่ต้องการ

// ฟังก์ชันบันทึกการขาย
$saleRecorded = false; // ตัวแปรเพื่อตรวจสอบว่าบันทึกสำเร็จหรือไม่
$errorMessage = '';

if (isset($_POST['record_sale'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : 'unspecified'; // ตรวจสอบค่าชำระเงิน
    $sale_date = date('Y-m-d H:i:s'); // กำหนดวันที่และเวลา
    $customer_name = $_POST['customer_name'];


    // ดึงข้อมูลสินค้าจากตาราง products
    $productQuery = mysqli_query($conn, "SELECT price, stock_quantity FROM products WHERE id = '$product_id'");
    $productData = mysqli_fetch_assoc($productQuery);
    $price = $productData['price'];
    $stock_quantity = $productData['stock_quantity']; // จำนวนสินค้าคงเหลือในสต็อก

    // ตรวจสอบว่าสินค้าเพียงพอหรือไม่
    if ($stock_quantity >= $quantity) {
        // คำนวณยอดขายรวม
        $amount = $price * $quantity;

        // บันทึกการขาย
        $query = "INSERT INTO sales (product_id, sale_date, quantity, amount, payment_method, customer_name) VALUES ('$product_id', '$sale_date', '$quantity', '$amount', '$payment_method', '$customer_name')";

        if (mysqli_query($conn, $query)) {
            // อัปเดตจำนวนสินค้าในสต็อก
            $new_stock_quantity = $stock_quantity - $quantity;
            $updateStockQuery = "UPDATE products SET stock_quantity = '$new_stock_quantity' WHERE id = '$product_id'";
            if (mysqli_query($conn, $updateStockQuery)) {
                $saleRecorded = true;
            } else {
                $errorMessage = 'ไม่สามารถอัปเดตสต็อกสินค้าได้: ' . mysqli_error($conn);
            }
        } else {
            $errorMessage = 'ไม่สามารถบันทึกการขายได้: ' . mysqli_error($conn);
        }
    } else {
        $errorMessage = 'สินค้ามีจำนวนไม่เพียงพอในสต็อก';
    }
}


// ดึงข้อมูลสินค้าทั้งหมดสำหรับเลือก
$products = mysqli_query($conn, "SELECT * FROM products");

// ดึงยอดขายรวมจากตาราง sales
$totalSalesResult = mysqli_query($conn, "SELECT SUM(amount) AS total_sales FROM sales");
$totalSalesData = mysqli_fetch_assoc($totalSalesResult);
$totalSales = $totalSalesData['total_sales'] !== null ? $totalSalesData['total_sales'] : 0; // ตรวจสอบให้แน่ใจว่ามีค่า

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บันทึกยอดขาย</title>
    <link
        rel="icon"
        href="image/warehouse_logo.png"
        type="image/x-icon" />
    <link rel="stylesheet" href="AdminLTE/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <style>
        /* ใช้ฟอนต์ Kanit */
        body {
            font-family: 'Kanit', sans-serif !important;
            /* กำหนดฟอนต์ให้เป็น Kanit */
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'navbar.php'; ?>

        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="container">
                <h1>บันทึกยอดขาย</h1>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="customer_name">ชื่อลูกค้า:</label>
                        <input type="text" class="form-control" name="customer_name" required>
                    </div>
                    <div class="form-group">
                        <label for="product_id">เลือกสินค้าที่ขาย:</label>
                        <select class="form-control" name="product_id" required>
                            <?php while ($product = mysqli_fetch_assoc($products)): ?>
                                <option value="<?php echo $product['id']; ?>">
                                    <?php echo $product['name'] . ' | คงเหลือ =  [' . $product['stock_quantity'] . ']'; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="quantity">ขายไปกี่ชิ้น:</label>
                        <input type="number" class="form-control" name="quantity" required>
                    </div>

                    <!-- เพิ่มฟิลด์วิธีการชำระเงิน -->
                    <div class="form-group">
                        <label>วิธีการชำระเงิน:</label><br>
                        <input type="radio" name="payment_method" value="Cash"> เงินสด<br>
                        <input type="radio" name="payment_method" value="Credit Card"> บัตรเครดิต<br>
                        <input type="radio" name="payment_method" value="Online Transfer"> โอนเงินออนไลน์<br>
                        <input type="radio" name="payment_method" value="unspecified" checked> ไม่ระบุ<br>
                    </div>

                    <button type="submit" name="record_sale" class="btn btn-success">บันทึกรายการ</button>
                </form>

                <!-- แสดงยอดขายรวม -->
                <div class="mt-4">
                    <h3>ยอดขายรวมทั้งหมด: <span class="text-success"><?php echo number_format($totalSales, 2); ?> บาท</span></h3>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include 'footer.php'; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>

    <script>
        // ตรวจสอบว่าบันทึกสำเร็จหรือไม่
        <?php if ($saleRecorded): ?>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: 'บันทึกการขายเรียบร้อยแล้ว',
                confirmButtonText: 'ตกลง'
            });
        <?php elseif ($errorMessage): ?>
            Swal.fire({
                icon: 'error',
                title: 'ข้อผิดพลาด!',
                text: '<?php echo $errorMessage; ?>',
                confirmButtonText: 'ตกลง'
            });
        <?php endif; ?>
    </script>

</body>

</html>