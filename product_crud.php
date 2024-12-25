<?php
// เชื่อมต่อฐานข้อมูล
include 'config.php';

// ฟังก์ชันการลบสินค้า
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // ลบข้อมูลในตาราง sales ที่เกี่ยวข้องกับ product นี้
    $delete_sales_query = "DELETE FROM sales WHERE product_id=$id";
    mysqli_query($conn, $delete_sales_query);

    // จากนั้นลบสินค้า
    $query = "DELETE FROM products WHERE id=$id";
    mysqli_query($conn, $query);
}

// ฟังก์ชันการแก้ไขสินค้า
if (isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $stock_quantity = $_POST['stock_quantity'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id']; // เพิ่มสำหรับหมวดหมู่

    $query = "UPDATE products SET name='$name', stock_quantity='$stock_quantity', price='$price', category_id='$category_id' WHERE id=$id";
    
    if (mysqli_query($conn, $query)) {
        $success = true; // ใช้สำหรับ SweetAlert
    } else {
        $error = true; // ใช้สำหรับ SweetAlert
    }
}

// ตรวจสอบว่ามีการแก้ไขหรือไม่
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
    $product = mysqli_fetch_assoc($result);
} else {
    $product = null; // ไม่มีการแก้ไข
}

// ดึงข้อมูลสินค้าทั้งหมด
$result = mysqli_query($conn, "SELECT * FROM products");

// ดึงข้อมูลหมวดหมู่ทั้งหมด
$categories = mysqli_query($conn, "SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>อัพเดทสินค้า</title>
    <link
      rel="icon"
      href="image/warehouse_logo.png"
      type="image/x-icon"
    />
    <link rel="stylesheet" href="AdminLTE/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
        <!-- AdminLTE CSS via CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Scripts via CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
    
    <!-- SweetAlert CSS & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

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
            <h1>อัพเดทสินค้า</h1>

            <!-- Form for updating product -->
            <form method="POST" id="updateForm" action="">
                <input type="hidden" name="id" value="<?php echo $product ? $product['id'] : ''; ?>">
                <div class="form-group">
                    <label for="name">ชื่อสินค้า:</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $product ? $product['name'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="category_id">หมวดหมู่:</label>
                    <select class="form-control" name="category_id" required>
                        <option value="">Select Category</option>
                        <?php while ($category = mysqli_fetch_assoc($categories)): ?>
                            <option value="<?php echo $category['id']; ?>" <?php echo ($product && $product['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                <?php echo $category['name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="stock_quantity">จำนวนสินค้าในคลัง:</label>
                    <input type="number" class="form-control" name="stock_quantity" value="<?php echo $product ? $product['stock_quantity'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="price">ราคา:</label>
                    <input type="number" class="form-control" name="price" value="<?php echo $product ? $product['price'] : ''; ?>" step="0.01" required>
                </div>
                <?php if ($product): ?>
                    <button type="submit" name="update_product" class="btn btn-warning mt-3">อัพเดทสินค้า</button>
                <?php endif; ?>
            </form>

            <hr>

            <h2>Product List</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ชื่อสินค้า</th>
                        <th>หมวดหมู่</th>
                        <th>จำนวนสินค้าในคลัง</th>
                        <th>ราคา</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo $product['name']; ?></td>
                            <td>
                                <?php 
                                    // ดึงชื่อหมวดหมู่จาก ID
                                    $category_query = mysqli_query($conn, "SELECT name FROM categories WHERE id=".$product['category_id']);
                                    $category = mysqli_fetch_assoc($category_query);
                                    echo $category['name'];
                                ?>
                            </td>
                            <td><?php echo $product['stock_quantity']; ?></td>
                            <td><?php echo number_format($product['price'], 2); ?></td>
                            <td>
                                <a href="?edit=<?php echo $product['id']; ?>" class="btn btn-warning">แก้ไข</a>
                                <button class="btn btn-danger" onclick="confirmDelete(<?php echo $product['id']; ?>)">ลบ</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</div>

<script>
function confirmDelete(productId) {
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: "คุณจะไม่สามารถกู้คืนข้อมูลนี้ได้!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            // เปลี่ยนเส้นทางไปยัง URL ที่ต้องการลบ
            window.location.href = '?delete=' + productId;
        }
    });
}

// แสดง SweetAlert หลังการอัปเดทสำเร็จ
<?php if (isset($success)): ?>
    Swal.fire({
        icon: 'success',
        title: 'อัพเดทสำเร็จ!',
        text: 'ข้อมูลสินค้าได้รับการอัพเดทเรียบร้อยแล้ว!',
        confirmButtonText: 'ตกลง'
    }).then(() => {
        // ใช้ setTimeout เพื่อให้แน่ใจว่าฟอร์มจะถูกรีเซ็ตหลังจาก SweetAlert ถูกปิด
        setTimeout(() => {
            document.getElementById("updateForm").reset();
        }, 500); // หน่วงเวลา 500ms
    });
<?php elseif (isset($error)): ?>
    Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด!',
        text: 'ไม่สามารถอัพเดทข้อมูลสินค้าได้!',
        confirmButtonText: 'ตกลง'
    });
<?php endif; ?>

</script>

</body>
</html>
