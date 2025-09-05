<?php
/**
 * Build category tree from a flat list of categories.
 * Usage:
 * 1. Import the .sql file to your database.
 * 2. Configure DB connection below.
 * 3. Run this script.
 */

$start = round(microtime(true) * 1000);
echo "Start: " . $start . "<br />";

$dbHost = 'localhost';
$dbName = 'categories'; // Change this to your imported database name
$dbUser = 'root';       // Change if needed
$dbPass = '';           // Change if needed

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('DB connection error: ' . $e->getMessage());
}

// --- FETCH CATEGORIES ---
$sql = "SELECT categories_id, parent_id FROM categories ORDER BY parent_id, categories_id";
try {
    $stmt = $pdo->query($sql);
} catch (Exception $e) {
    echo $e->getMessage();
}

$categories = [];
$refs = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $categories[$row['categories_id']] = $row;
    // Prepare references for all categories
    $refs[$row['categories_id']] = [
        'id' => $row['categories_id']
    ];
}

// --- BUILD TREE ---
function buildCategoryTree($categories, $refs) {
    $tree = [];

    foreach ($refs as $catId => &$node) {
        $parentId = $categories[$catId]['parent_id'];
        if ($parentId && isset($refs[$parentId])) {
            // Add as child to parent
            if (!isset($refs[$parentId]['children'])) {
                $refs[$parentId]['children'] = [];
            }
            $refs[$parentId]['children'][$catId] = &$node;
        } else {
            // Top-level category
            $tree[$catId] = &$node;
        }
    }
    unset($node); // break reference

    // Format as requested: key = category id, value = array of child ids or duplicate key if leaf
    return formatTree($tree);
}

// Format tree as: key = id, value = [subcategories] or key = id (leaf)
function formatTree($tree) {
    $result = [];
    foreach ($tree as $id => $node) {
        if (!empty($node['children'])) {
            $result[$id] = formatTree($node['children']);
        } else {
            $result[$id] = $id;
        }
    }
    return $result;
}

// --- OUTPUT ---
$catTree = buildCategoryTree($categories, $refs);
echo "<pre>";
print_r($catTree);
echo "</pre>";

$finish = round(microtime(true) * 1000);
echo "Finish: " . $finish . "<br />";
echo "Execution time: " . ($finish - $start);

/*
Example output:
Array
(
    [1] => Array
        (
            [2] => Array
                (
                    [5] => 5
                    [6] => 6
                )
            [3] => 3
        )
    [4] => 4
)
*/
?>