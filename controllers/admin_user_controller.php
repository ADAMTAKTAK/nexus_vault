<?php
session_start();

if (!isset($_SESSION["id"]) || $_SESSION['user_role'] !== 'admin') {
    header("location: ../index.php");
    exit();
}

include "../model/conn.php";

if (isset($_POST['action']) && $_POST['action'] === 'add_user') {
    $fn = trim($_POST['firstName']);
    $ln = trim($_POST['lastName']);
    $em = trim($_POST['email']);
    $pw = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $role = $_POST['role'];

    try {
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, user_role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fn, $ln, $em, $pw, $role);
        $stmt->execute();
    } catch (mysqli_sql_exception $e) {
    }
    
    header("location: ../admin/admin_users.php");
    exit();
}

if (isset($_POST['action']) && $_POST['action'] === 'edit_user') {
    $target_id = $_POST['target_id'];
    $fn = trim($_POST['firstName']);
    $ln = trim($_POST['lastName']);
    $em = trim($_POST['email']);
    $role = $_POST['role'];

    $upd = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, user_role = ? WHERE id = ?");
    $upd->bind_param("ssssi", $fn, $ln, $em, $role, $target_id);
    $upd->execute();

    if ($target_id == $_SESSION['id']) {
        $_SESSION['user_name'] = $fn;
    }

    header("location: ../admin/admin_users.php");
    exit();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $target_id = $_GET['id'];
    $current_admin_id = $_SESSION['id'];

    if ($action === 'ascend') {
        $upd = $conn->prepare("UPDATE users SET user_role = 'admin' WHERE id = ?");
        $upd->bind_param("i", $target_id);
        $upd->execute();

    } elseif ($action === 'demote') {
        if ($target_id != $current_admin_id) {
            $upd = $conn->prepare("UPDATE users SET user_role = 'normal' WHERE id = ?");
            $upd->bind_param("i", $target_id);
            $upd->execute();
        }

    } elseif ($action === 'delete') {
        if ($target_id != $current_admin_id) {
            $del_cart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
            $del_cart->bind_param("i", $target_id);
            $del_cart->execute();

            $del_user = $conn->prepare("DELETE FROM users WHERE id = ?");
            $del_user->bind_param("i", $target_id);
            $del_user->execute();
        }
    }

    header("location: ../admin/admin_users.php");
    exit();
}
?>