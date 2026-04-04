<?php
session_start();
include "../model/conn.php";

if (!isset($_SESSION["id"])) { header("location: ../login.php"); exit(); }

$user_id = $_SESSION["id"];

$sql = "SELECT SUM(p.product_price * c.quantity) as total 
        FROM cart c 
        INNER JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$data = $res->fetch_object();
$total_final = $data->total;

if ($total_final > 0) {
    $ins = $conn->prepare("INSERT INTO invoices (total_price) VALUES (?)");
    $ins->bind_param("d", $total_final);
    $ins->execute();
    $invoice_id = $conn->insert_id;

    $del = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $del->bind_param("i", $user_id);
    $del->execute();

    header("location: ../invoice_view.php?id=" . $invoice_id);
} else {
    header("location: ../cart.php");
}
?>