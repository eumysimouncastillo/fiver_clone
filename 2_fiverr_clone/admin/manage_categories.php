<?php require_once 'classloader.php'; ?>
<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if (!$userObj->isAdmin()) {
  header("Location: ../freelancer/index.php");
} 

$categoryObj = new Category();
$categories = $categoryObj->getAllCategoriesWithSubcategories();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <style>
      body { font-family: "Arial"; }
    </style>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container-fluid mt-4">
      <h2 class="text-center">Manage Categories</h2>

      <!-- Success/Error Messages -->
      <div class="text-center">
        <?php  
          if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
            if ($_SESSION['status'] == "200") {
              echo "<h5 style='color: green;'>{$_SESSION['message']}</h5>";
            } else {
              echo "<h5 style='color: red;'>{$_SESSION['message']}</h5>"; 
            }
          }
          unset($_SESSION['message']);
          unset($_SESSION['status']);
        ?>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-5">
          <!-- Add Category -->
          <div class="card shadow p-3 mb-4">
            <h4>Add New Category</h4>
            <form method="POST" action="core/handleforms.php">
              <div class="form-group">
                <input type="text" name="category_name" class="form-control" placeholder="Enter category name" required>
              </div>
              <input type="submit" name="addCategoryBtn" class="btn btn-primary" value="Add Category">
            </form>
          </div>
        </div>

        <div class="col-md-5">
          <!-- Add Subcategory -->
          <div class="card shadow p-3 mb-4">
            <h4>Add New Subcategory</h4>
            <form method="POST" action="core/handleforms.php">
              <div class="form-group">
                <select name="category_id" class="form-control" required>
                  <option value="">-- Select Category --</option>
                  <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['category_id']; ?>">
                      <?php echo htmlspecialchars($cat['category_name']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <input type="text" name="subcategory_name" class="form-control" placeholder="Enter subcategory name" required>
              </div>
              <input type="submit" name="addSubcategoryBtn" class="btn btn-success" value="Add Subcategory">
            </form>
          </div>
        </div>
      </div>

      <!-- Display Categories + Subcategories -->
      <div class="card shadow p-3 mt-4">
        <h4>All Categories & Subcategories</h4>
        <ul class="list-group">
          <?php foreach ($categories as $cat): ?>
            <li class="list-group-item">
              <strong><?php echo htmlspecialchars($cat['category_name']); ?></strong>
              <?php if (!empty($cat['subcategories'])): ?>
                <ul>
                  <?php foreach ($cat['subcategories'] as $sub): ?>
                    <li><?php echo htmlspecialchars($sub['subcategory_name']); ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php else: ?>
                <em>No subcategories yet</em>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </body>
</html>
