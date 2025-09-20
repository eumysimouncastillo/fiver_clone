<?php
require_once 'classloader.php';

// Fetch categories WITH their subcategories in one call
$categories = $categoryObj->getAllCategoriesWithSubcategories();
?>

<nav class="navbar navbar-expand-lg navbar-dark p-4" style="background-color: #023E8A;">
  <a class="navbar-brand" href="index.php">Admin Panel</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">

      <!-- Existing Items -->
      <li class="nav-item">
        <a class="nav-link" href="manage_categories.php">Manage Categories</a>
      </li>

      <!-- New Categories Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Browse
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php foreach ($categories as $cat): ?>
            <div class="dropdown-submenu">
              <a class="dropdown-item d-flex justify-content-between align-items-center" href="browse.php?category_id=<?php echo $cat['category_id']; ?>" data-toggle="submenu">
                <?php echo htmlspecialchars($cat['category_name']); ?>
                <?php if (!empty($cat['subcategories'])): ?>
                  <span class="submenu-arrow">▶</span>
                <?php endif; ?>
              </a>
              <?php if (!empty($cat['subcategories'])): ?>
                <ul class="dropdown-menu">
                  <?php foreach ($cat['subcategories'] as $sub): ?>
                    <li>
                      <a class="dropdown-item" href="browse.php?subcategory_id=<?php echo $sub['subcategory_id']; ?>">
                        <?php echo htmlspecialchars($sub['subcategory_name']); ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="core/handleForms.php?logoutUserBtn=1">Logout</a>
      </li>
    </ul>
  </div>
</nav>

<!-- Extra CSS for nested dropdowns -->
<style>
.dropdown-submenu {
  position: relative;
}
.dropdown-submenu > .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -1px;
  display: none; /* hidden by default */
}
.dropdown-submenu.show > .dropdown-menu {
  display: block;
}
.submenu-arrow {
  font-size: 0.8rem;
  margin-left: auto;
}
.dropdown-submenu.show > a .submenu-arrow {
  content: "▼";
}
</style>

<!-- JS to handle nested dropdowns -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll('[data-toggle="submenu"]').forEach(function (el) {
    el.addEventListener("click", function (e) {
      // If category has subcategories, prevent immediate navigation
      if (this.nextElementSibling && this.nextElementSibling.classList.contains("dropdown-menu")) {
        e.preventDefault();
        e.stopPropagation();
        let parent = this.closest(".dropdown-submenu");
        parent.classList.toggle("show");

        // Toggle arrow
        let arrow = this.querySelector(".submenu-arrow");
        if (arrow) {
          arrow.textContent = parent.classList.contains("show") ? "▼" : "▶";
        }
      }
    });
  });
});
</script>
