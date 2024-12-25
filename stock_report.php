<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>คลังสินค้า</title>
    <link
      rel="icon"
      href="image/warehouse_logo.png"
      type="image/x-icon"
    />

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="AdminLTE/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.1/css/buttons.bootstrap4.min.css">

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.1/js/buttons.print.min.js"></script>
    <style>
        body {
            font-family: 'Kanit', sans-serif !important;
        }
        .dt-buttons {
            margin: 20px 0;
            /* เพิ่มช่องว่างด้านบนและล่าง */
        }
    </style>


</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'navbar.php'; ?>
        <?php include 'sidebar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <h1>รายการคลังสินค้า</h1>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <table id="stockTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อสินค้า</th>
                                <th>หมวดหมู่</th>
                                <th>ราคา(ต่อชิ้น)</th>
                                <th>จำนวนสินค้าในคลังคงเหลือ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($conn, "SELECT p.name, c.name AS category, p.price, p.stock_quantity FROM products p JOIN categories c ON p.category_id = c.id");
                            $index = 1; // ตัวแปรเก็บลำดับ
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $index++ . "</td>"; // แสดงลำดับ
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['category'] . "</td>";
                                echo "<td>" . $row['price']. " บาท". "</td>";
                                echo "<td>" . $row['stock_quantity'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <script>
                $(document).ready(function() {
                    $('#stockTable').DataTable({
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
        </div>

        <?php include 'footer.php'; ?>
    </div>

</body>

</html>