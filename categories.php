<?php
include 'config.php';

// ฟังก์ชันการลบหมวดหมู่
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM categories WHERE id = $id");
    header("Location: categories.php");
}

if (isset($_POST['add_category'])) {
    $name = $_POST['name'];
    mysqli_query($conn, "INSERT INTO categories (name) VALUES ('$name')");
    header("Location: categories.php");
    exit(); // แนะนำให้เพิ่ม exit() หลัง header
}

if (isset($_POST['edit_category'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    mysqli_query($conn, "UPDATE categories SET name = '$name' WHERE id = $id");
    header("Location: categories.php");
    exit(); // แนะนำให้เพิ่ม exit() หลัง header
}


// ดึงข้อมูลหมวดหมู่ทั้งหมด
$result = mysqli_query($conn, "SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หมวดหมู่สินค้า</title>
    <link
      rel="icon"
      href="image/warehouse_logo.png"
      type="image/x-icon"
    />
    <link rel="stylesheet" href="AdminLTE/dist/css/adminlte.min.css">

    <!-- AdminLTE CSS via CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <!-- Scripts via CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>


  <style>
        body {
            font-family: 'Kanit', sans-serif !important;
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
                    <h1>หมวดหมู่สินค้า</h1>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">เพิ่มหมวดหมู่</button>
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อหมวดหมู่</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $index = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $index++ . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>
                                        <button class='btn btn-warning' data-toggle='modal' data-target='#editCategoryModal{$row['id']}'>แก้ไข</button>
                                        <a href='categories.php?action=delete&id={$row['id']}' class='btn btn-danger' onclick=\"return confirm('Are you sure you want to delete this category?');\">ลบ</a>
                                      </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <!-- Modal Add Category -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" action="">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCategoryModalLabel">เพิ่มหมวดหมู่</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">ชื่อหมวดหมู่</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                            <button type="submit" name="add_category" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modals for editing categories -->
        <?php
        mysqli_data_seek($result, 0); // Reset result pointer for editing modals
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
            <div class='modal fade' id='editCategoryModal{$row['id']}' tabindex='-1' role='dialog' aria-labelledby='editCategoryModalLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <form method='POST' action=''>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='editCategoryModalLabel'>Edit Category</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                <div class='form-group'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <label for='name'>Category Name</label>
                                    <input type='text' class='form-control' id='name' name='name' value='{$row['name']}' required>
                                </div>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                <button type='submit' name='edit_category' class='btn btn-warning'>Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            ";
        }
        ?>

        <?php include 'footer.php'; ?>
    </div>

    <script src="AdminLTE/plugins/jquery/jquery.min.js"></script>
    <script src="AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="AdminLTE/dist/js/adminlte.min.js"></script>
</body>
</html>
