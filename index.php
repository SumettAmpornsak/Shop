<?php
// เชื่อมต่อฐานข้อมูล
include 'config.php';

// ดึงข้อมูลยอดขายรวมจากตาราง sales
$totalSalesResult = mysqli_query($conn, "SELECT SUM(amount) AS total_sales FROM sales");
$totalSalesData = mysqli_fetch_assoc($totalSalesResult);
$totalSales = $totalSalesData['total_sales'] !== null ? $totalSalesData['total_sales'] : 0; // ตรวจสอบให้แน่ใจว่ามีค่า
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลัก</title>
    <link
      rel="icon"
      href="image/warehouse_logo.png"
      type="image/x-icon"
    />
    <!-- Include AdminLTE CSS -->
    <link rel="stylesheet" href="AdminLTE/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    <style>
        /* ใช้ฟอนต์ Kanit */
        body {
            font-family: 'Kanit', sans-serif !important;
            /* กำหนดฟอนต์ให้เป็น Kanit */
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'navbar.php'; ?>
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>หน้าหลัก</h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <!-- Total Products -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT COUNT(*) AS total_products FROM products");
                                        $data = mysqli_fetch_assoc($result);
                                        echo $data['total_products'];
                                        ?>
                                    </h3>
                                    <p>จำนวนรายการสินค้า</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <a href="stock_report.php" class="small-box-footer">รายละเอียดเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- Total Categories -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT COUNT(*) AS total_categories FROM categories");
                                        $data = mysqli_fetch_assoc($result);
                                        echo $data['total_categories'];
                                        ?>
                                    </h3>
                                    <p>จำนวนรายการหมวดหมู่</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-tags"></i>
                                </div>
                                <a href="categories.php" class="small-box-footer">รายละเอียดเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- Total Sales -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>
                                        <?php echo number_format($totalSales, 2); ?> <!-- แสดงยอดขายรวม -->
                                    </h3>
                                    <p>จำนวนยอดขาย</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <a href="sales_report.php" class="small-box-footer">รายละเอียดเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Footer -->
        <?php include 'footer.php'; ?>
    </div>

    <script src="AdminLTE/plugins/jquery/jquery.min.js"></script>
    <script src="AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="AdminLTE/dist/js/adminlte.min.js"></script>
</body>

</html>