<?php
// เชื่อมต่อฐานข้อมูล
include 'config.php';

// ดึงข้อมูลยอดขายจากตาราง sales
$salesQuery = "
    SELECT p.name, s.amount, s.quantity, s.sale_date, s.payment_method, s.customer_name 
    FROM sales s 
    JOIN products p ON s.product_id = p.id
    ORDER BY s.sale_date DESC
";

$salesResult = mysqli_query($conn, $salesQuery);

// ดึงยอดขายรวมจากตาราง sales
$totalSalesResult = mysqli_query($conn, "SELECT SUM(amount) AS total_sales FROM sales");
$totalSalesData = mysqli_fetch_assoc($totalSalesResult);
$totalSales = $totalSalesData['total_sales'] !== null ? $totalSalesData['total_sales'] : 0;
 // ตรวจสอบให้แน่ใจว่ามีค่า
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จำนวนยอดขายทั้งหมด</title>
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

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.1/css/buttons.bootstrap4.min.css">

    <!-- Scripts via CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.1/js/buttons.print.min.js"></script>

    <style>
        /* ใช้ฟอนต์ Kanit */
        body {
            font-family: 'Kanit', sans-serif !important;
        }

        .table th,
        .table td {
            text-align: center;
        }

        .dt-buttons {
            margin: 20px 0;
            /* เพิ่มช่องว่างด้านบนและล่าง */
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
                            <h1>รายงานยอดขาย</h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">ตารางยอดขาย</h3>
                                    <div class="card-tools">

                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="salesTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>วันที่ขาย</th>
                                                <th>ชื่อลูกค้า</th>
                                                <th>ชื่อสินค้า</th>
                                                <th>จำนวนสินค้าที่ขาย</th>
                                                <th>ยอดขายรวม</th>
                                                <th>วิธีการชำระเงิน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = mysqli_fetch_assoc($salesResult)): ?>
                                                <tr>
                                                    <td><?php echo date('Y-m-d H:i:s', strtotime($row['sale_date'])); ?></td>
                                                    <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                                    <td><?php echo $row['name']; ?></td>
                                                    <td><?php echo number_format($row['quantity']); ?> ชิ้น</td>
                                                    <td><?php echo number_format($row['amount'], 2); ?> บาท</td>
                                                    <td><?php echo translatePaymentMethod($row['payment_method']); ?></td> <!-- แปลงค่าวิธีการชำระเงินเป็นภาษาไทย -->
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                    <!-- แสดงยอดขายรวม -->
                                    <div class="mt-4">
                                        <h3>ยอดขายรวมทั้งหมด: <span class="text-success"><?php echo number_format($totalSales, 2); ?> บาท</span></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

    <?php
    function translatePaymentMethod($method) {
        switch ($method) {
            case 'Online Transfer':
                return 'โอนเงินออนไลน์';
            case 'Credit Card':
                return 'บัตรเครดิต';
            case 'Cash':
                return 'เงินสด';
            case 'unspecified':
            default:
                return 'ไม่ระบุ';
        }
    }
    
    ?>

    

    <!-- Initialize DataTable -->
    <script>
        $(document).ready(function() {
            $('#salesTable').DataTable({
                dom: 'Bfrtip', // เปิดการใช้ปุ่มที่ด้านบนของตาราง
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> Export to Excel',
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fas fa-file-csv"></i> Export to CSV',
                        className: 'btn btn-info'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> Export to PDF',
                        className: 'btn btn-danger'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-primary'
                    }
                ],
                paging: false, // ปิดการแบ่งหน้าเพื่อให้ตารางทั้งหมดถูกดาวน์โหลด/พิมพ์
                ordering: false, // ปิดการจัดเรียงข้อมูล
                searching: false, // ปิดการค้นหา
                info: false, // ปิดการแสดงข้อมูลจำนวนรายการ
                autoWidth: false // ปิดการตั้งค่าความกว้างอัตโนมัติ
            });
        });
    </script>
</body>

</html>
