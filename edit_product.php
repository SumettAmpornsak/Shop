<?php
include 'config.php';

$product_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $category_id = $_POST['category_id'];
  $price = $_POST['price'];
  $stock_quantity = $_POST['stock_quantity'];

  $sql = "UPDATE products SET name='$name', category_id='$category_id', price='$price', stock_quantity='$stock_quantity' WHERE id='$product_id'";
  if (mysqli_query($conn, $sql)) {
    header('Location: dashboard.php');
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
} else {
  $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id='$product_id'"));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product - Warehouse System</title>
  <link rel="stylesheet" href="AdminLTE/dist/css/adminlte.min.css">
  <!-- AdminLTE CSS via CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<!-- Scripts via CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <?php include 'navbar.php'; ?>
  <?php include 'sidebar.php'; ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <h1>Edit Product</h1>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <form action="edit_product.php?id=<?= $product_id ?>" method="POST">
          <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" class="form-control" value="<?= $product['name'] ?>" required>
          </div>
          <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" class="form-control">
              <?php
              $categories = mysqli_query($conn, "SELECT * FROM categories");
              while ($row = mysqli_fetch_assoc($categories)) {
                $selected = ($row['id'] == $product['category_id']) ? 'selected' : '';
                echo "<option value='" . $row['id'] . "' $selected>" . $row['name'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" value="<?= $product['price'] ?>" required>
          </div>
          <div class="form-group">
            <label for="stock_quantity">Stock Quantity</label>
            <input type="number" name="stock_quantity" class="form-control" value="<?= $product['stock_quantity'] ?>" required>
          </div>
          <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
      </div>
    </section>
  </div>

  <?php include 'footer.php'; ?>
</div>

<script src="AdminLTE/plugins/jquery/jquery.min.js"></script>
<script src="AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="AdminLTE/dist/js/adminlte.min.js"></script>
</body>
</html>
