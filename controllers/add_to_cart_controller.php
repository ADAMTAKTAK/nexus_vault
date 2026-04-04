<?php
session_start();
include "../model/conn.php";

if (!isset($_SESSION["id"])) {
    header("location: ../login.php");
    exit();
}

if (!empty($_POST["btn_add_cart"])) {
    $user_id = $_SESSION["id"];
    $product_id = $_POST["product_id"];
    $quantity = $_POST["quantity"];

    $check = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $check->bind_param("ii", $user_id, $product_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $update = $conn->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
        $update->bind_param("iii", $quantity, $user_id, $product_id);
        $update->execute();
    } else {
        $insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $insert->bind_param("iii", $user_id, $product_id, $quantity);
        $insert->execute();
    }

    header("location: ../cart.php");
    exit();
}
?>