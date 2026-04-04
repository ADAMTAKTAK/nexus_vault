<?php
session_start();
if (!isset($_SESSION["id"])) { header("location: login.php"); exit(); }
include "model/conn.php";
$user_id = $_SESSION["id"];
$res = $conn->query("SELECT * FROM users WHERE id = $user_id");
$u = $res->fetch_object();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EDIT_PROFILE // NEXUS VAULT</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-container">
            <h2 style="color:#00E5FF; font-family:'Orbitron'; text-align:center; margin-bottom:20px;">>_ UPDATE_DATA</h2>
            
            <?php include "controllers/edit_profile_controller.php"; ?>

            <form method="POST">
                <div class="form-group">
                    <label>>_ nombre:</label>
                    <input type="text" name="firstName" value="<?php echo $u->first_name; ?>" required>
                </div>
                <div class="form-group">
                    <label>>_ apellido:</label>
                    <input type="text" name="lastName" value="<?php echo $u->last_name; ?>" required>
                </div>
                <hr style="border: 0; border-top: 1px solid #333; margin: 20px 0;">
                <div class="form-group">
                    <label>>_ nueva_password (dejar vacío para no cambiar):</label>
                    <input type="password" name="newPass">
                </div>
                <div class="form-group">
                    <label>>_ confirmar_password:</label>
                    <input type="password" name="confirmPass">
                </div>
                <button type="submit" name="btn_update" value="1" class="btn">>_ commit_changes</button>
            </form>
            <div class="toggle-form"><a href="profile.php">Cancelar</a></div>
        </div>
    </div>
</body>
</html>