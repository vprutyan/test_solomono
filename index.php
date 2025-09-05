<?php
require_once 'autoload.php';
require_once 'migrations.php';

// Read current GET parameters for state
$category_id = isset($_GET['category']) ? intval($_GET['category']) : null;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'cheapest';

// Get all categories (with counts)
$category = new Category();
$categories = $category->getAllWithCounts();

// Get products for initial view
$productModel = new Product();
$products = $productModel->getProducts($category_id, $sort);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Catalog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <h5>Categories</h5>
            <ul class="list-group" id="category-list">
                <?php foreach ($categories as $cat): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center category-item<?php if ($category_id == $cat['id']) echo ' active'; ?>"
                        data-category="<?= $cat['id'] ?>">
                        <?= htmlspecialchars($cat['name']) ?>
                        <span class="badge bg-secondary"><?= $cat['product_count'] ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Products</h5>
                <select id="sort-select" class="form-select w-auto">
                    <option value="cheapest"<?= $sort === 'cheapest' ? ' selected' : '' ?>>Cheapest first</option>
                    <option value="alphabetical"<?= $sort === 'alphabetical' ? ' selected' : '' ?>>Alphabetically</option>
                    <option value="newest"<?= $sort === 'newest' ? ' selected' : '' ?>>Newest first</option>
                </select>
            </div>
            <div id="product-list" class="row">
                <!-- Products loaded here by JS -->
            </div>
        </div>
    </div>
</div>

<!-- Modal for Buy -->
<div class="modal fade" id="buyModal" tabindex="-1" aria-labelledby="buyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="buyModalLabel">Buy Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="buy-modal-body">
        <!-- Product details loaded here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Confirm Purchase</button>
      </div>
    </div>
  </div>
</div>

<script>
    // Pass PHP data to JS as JSON
    const initialProducts = <?php echo json_encode($products) ?>;
    const initialCategory = <?php echo json_encode($category_id) ?>;
    const initialSort = <?php echo json_encode($sort) ?>;
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/app.js"></script>
</body>
</html>