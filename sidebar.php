<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ระบบคลังสินค้า</title>

  <!-- นำเข้าฟอนต์ Kanit -->
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
    /* ใช้ฟอนต์ Kanit ใน Sidebar */
    .main-sidebar,
    .nav-link,
    .brand-text {
      font-family: 'Kanit', sans-serif !important;
      /* กำหนดฟอนต์ให้เป็น Kanit */
    }

    /* ปรับแต่งโลโก้ */
    .brand-link img {
      max-height: 50px;
      /* ความสูงสูงสุดของโลโก้ */
      margin-right: 10px;
      /* ระยะห่างด้านขวาของโลโก้ */
    }
  </style>

  <!-- สไตล์และสคริปต์อื่นๆ ของคุณ -->
  <link rel="stylesheet" href="AdminLTE/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="image/Sumett_logo.jpg" alt=Sumett_logo" class="brand-image"> <!-- เปลี่ยน path ให้ตรงกับที่ตั้งของโลโก้ -->
      <span class="brand-text font-weight-light">ระบบคลังสินค้า</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-home"></i> <!-- เปลี่ยนไอคอนเป็นบ้าน -->
              <p>หน้าหลัก</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="record_sale.php" class="nav-link">
              <i class="nav-icon fas fa-receipt"></i> <!-- เปลี่ยนไอคอนเป็นใบเสร็จ -->
              <p>บันทึกยอดขาย</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="sales_report.php" class="nav-link">
              <i class="nav-icon fas fa-money-bill-wave"></i> <!-- ใช้ไอคอนเงิน -->
              <p>ยอดขายทั้งหมด</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="stock_report.php" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i> <!-- เปลี่ยนไอคอนเป็นคลังสินค้า -->
              <p>คลังสินค้า</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="categories.php" class="nav-link">
              <i class="nav-icon fas fa-th-list"></i> <!-- เปลี่ยนไอคอนเป็นรายการ -->
              <p>รายการหมวดหมู่สินค้า</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="product_crud.php" class="nav-link">
              <i class="nav-icon fas fa-edit"></i> <!-- เปลี่ยนไอคอนเป็นแก้ไข -->
              <p>อัพเดทสินค้า</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="add_product.php" class="nav-link">
              <i class="nav-icon fas fa-plus-circle"></i> <!-- เปลี่ยนไอคอนเป็นเพิ่ม -->
              <p>เพิ่มสินค้าใหม่</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
</body>

</html>