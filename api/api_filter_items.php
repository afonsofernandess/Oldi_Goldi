<?php 
session_start();
require_once('../database/connection.php');
require_once('../database/categories.php');
$db = getDatabaseConnection();


$brand_ids = isset($_GET['brand_ids']) ? json_decode($_GET['brand_ids']) : null;
$size_ids = isset($_GET['size_ids']) ? json_decode($_GET['size_ids']) : null;
$condition_ids = isset($_GET['condition_ids']) ? json_decode($_GET['condition_ids']) : null;
$category_ids = isset($_GET['category_ids']) ? json_decode($_GET['category_ids']) : null;
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : null;
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : null;
$search_term = isset($_GET['search']) ? $_GET['search'] : null;
$conditions = [];
$params = [];

if ($brand_ids) {
    $placeholders = str_repeat('?,', count($brand_ids) - 1) . '?';
    $conditions[] = "brand_id IN ($placeholders)";
    $params = array_merge($params, $brand_ids);
}

if ($size_ids) {
    $placeholders = str_repeat('?,', count($size_ids) - 1) . '?';
    $conditions[] = "size_id IN ($placeholders)";
    $params = array_merge($params, $size_ids);
}

if ($condition_ids) {
    $placeholders = str_repeat('?,', count($condition_ids) - 1) . '?';
    $conditions[] = "condition_id IN ($placeholders)";
    $params = array_merge($params, $condition_ids); //it adds parameters to the end of the array withourt having to use a loop
}
if($category_ids){
    $placeholders = str_repeat('?,', count($category_ids) - 1) . '?';
    $conditions[] = "category_id IN ($placeholders)";
    $params = array_merge($params, $category_ids);
}
if($min_price){
    $conditions[] = "price >= ?";
    $params[] = $min_price;
}
if($max_price){
    $conditions[] = "price <= ?";
    $params[] = $max_price;
}

if($search_term){
    $conditions[] = "item_name LIKE ?";
    $params[] = '%' . $search_term . '%';
}

if ($conditions) {
    $sql = "SELECT * FROM Item WHERE " . implode(' AND ', $conditions) . "AND is_sold = 0";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $items = $stmt->fetchAll();
} else {
    $items = getAllItems($db);
}

echo display_items($db, $items);