<?php
if (!empty($_POST["btn_update"])) {
    $fn = trim($_POST['firstName']);
    $ln = trim($_POST['lastName']);
    $p1 = $_POST['newPass'];
    $p2 = $_POST['confirmPass'];
    $uid = $_SESSION['id'];

    $upd = $conn->prepare("UPDATE users SET first_name = ?, last_name = ? WHERE id = ?");
    $upd->bind_param("ssi", $fn, $ln, $uid);
    $upd->execute();
    $_SESSION['user_name'] = $fn;

    if (!empty($p1)) {
        if ($p1 === $p2) {
            $upd_p = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $upd_p->bind_param("si", $p1, $uid);
            $upd_p->execute();
            echo "<div class='sys-msg success'>[SYS] Perfil y password actualizados.</div>";
        } else {
            echo "<div class='sys-msg error'>[ERROR] Las contraseñas no coinciden.</div>";
        }
    } else {
        echo "<div class='sys-msg success'>[SYS] Datos básicos actualizados.</div>";
    }
}
?>