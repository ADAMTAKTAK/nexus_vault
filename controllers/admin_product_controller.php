<?php
session_start();

if (!isset($_SESSION["id"]) || $_SESSION['user_role'] !== 'admin') {
    header("location: ../index.php");
    exit();
}

include "../model/conn.php";

if (isset($_POST['action']) && $_POST['action'] === 'add_product') {
    $p_name = trim($_POST['product_name']);
    $p_price = $_POST['product_price'];
    $p_image = trim($_POST['product_image']);
    $p_desc = trim($_POST['product_description']);

    $stmt = $conn->prepare("INSERT INTO products (product_name, product_price, product_image, product_description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $p_name, $p_price, $p_image, $p_desc);
    $stmt->execute();

    header("location: ../admin/admin_products.php");
    exit();
}

if (isset($_POST['action']) && $_POST['action'] === 'edit_product') {
    $target_id = $_POST['target_id'];
    $p_name = trim($_POST['product_name']);
    $p_price = $_POST['product_price'];
    $p_image = trim($_POST['product_image']);
    $p_desc = trim($_POST['product_description']);

    $upd = $conn->prepare("UPDATE products SET product_name = ?, product_price = ?, product_image = ?, product_description = ? WHERE id = ?");
    $upd->bind_param("sdssi", $p_name, $p_price, $p_image, $p_desc, $target_id);
    $upd->execute();

    header("location: ../admin/admin_products.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $target_id = $_GET['id'];

    $del_cart = $conn->prepare("DELETE FROM cart WHERE product_id = ?");
    $del_cart->bind_param("i", $target_id);
    $del_cart->execute();

    $del_prod = $conn->prepare("DELETE FROM products WHERE id = ?");
    $del_prod->bind_param("i", $target_id);
    $del_prod->execute();

    header("location: ../admin/admin_products.php");
    exit();
}
?>