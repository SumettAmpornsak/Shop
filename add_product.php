<?php
include 'config.php';

$successMessage = ""; // ตัวแปรเพื่อเก็บข้อความสำเร็จ

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];

    $sql = "INSERT INTO products (name, category_id, price, stock_quantity) VALUES ('$name', '$category_id', '$price', '$stock_quantity')";
    if (mysqli_query($conn, $sql)) {
        $successMessage = "ระบบบันทึกสินค้าเรียบร้อยแล้ว";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      rel="icon"
      href="image/warehouse_logo.png"
      type="image/x-icon"
    />
    <title>เพิ่มสินค้าใหม่</title>
    <link rel="stylesheet" href="AdminLTE/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
    
    <!-- SweetAlert JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <style>
        /* ใช้ฟอนต์ Kanit */
        body {
            font-family: 'Kanit', sans-serif !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'navbar.php'; ?>

        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <h1>เพิ่มสินค้าใหม่</h1>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <form action="add_product.php" method="POST">
                        <div class="form-group">
                            <label for="name">ชื่อสินค้าใหม่</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="category_id">หมวดหมู่</label>
                            <select name="category_id" class="form-control">
                                <?php
                                $categories = mysqli_query($conn, "SELECT * FROM categories");
                                while ($row = mysqli_fetch_assoc($categories)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">ราคาสินค้า</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="stock_quantity">จำนวนสินค้านำเข้า</label>
                            <input type="number" name="stock_quantity" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">เพิ่มสินค้า</button>
                    </form>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <?php include 'footer.php'; ?>
    </div>

    <!-- Scripts -->
    <script src="AdminLTE/plugins/jquery/jquery.min.js"></script>
    <script src="AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="AdminLTE/dist/js/adminlte.min.js"></script>

    <script>
        // ถ้ามีข้อความสำเร็จให้แสดง SweetAlert
        <?php if ($successMessage): ?>
            $(document).ready(function() {
                swal("สำเร็จ!", "<?php echo $successMessage; ?>", "success")
                .then((value) => {
                    // เปลี่ยนเส้นทางไปที่หน้าอื่นถ้าต้องการ
                    window.location.href = "add_product.php"; // คุณสามารถเปลี่ยนเป็นหน้าที่คุณต้องการ
                });
            });
        <?php endif; ?>
    </script>
</body>

</html>
