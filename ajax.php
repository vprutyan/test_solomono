<?php
require_once 'autoload.php';
header('Content-Type: application/json');

$productModel = new Product();
if (isset($_GET['product_id'])) {
    $product = $productModel->getById(intval($_GET['product_id']));
    echo json_encode($product);
    exit;
}

$category_id = isset($_GET['category']) ? intval($_GET['category']) : null;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'cheapest';

$products = $productModel->getProducts($category_id, $sort);

echo json_encode($products);
exit;