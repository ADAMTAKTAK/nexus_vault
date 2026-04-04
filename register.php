<?php
    session_start();
    if(isset($_SESSION["id"])){ header("location: index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>REGISTER // NEXUS VAULT</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-container">
            <div class="brand-header">
                <div>>_ [ <span class="brand-text">NEXUS</span> <span class="slash">//</span> <span class="brand-text">VAULT</span> ]</div>
                <div style="font-size: 0.8rem; margin-top: 10px; color: #777;">NEW_USER_SYS</div>
            </div>

            <?php
                include "model/conn.php";
                include "controllers/create_user_controller.php";
            ?>

            <form method="POST" action="">
                <div style="display: flex; gap: 10px;">
                    <div class="form-group" style="flex: 1;">
                        <label>>_ first_name:</label>
                        <input type="text" name="firstName" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>>_ last_name:</label>
                        <input type="text" name="lastName" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>>_ set.email:</label>
                    <input type="email" name="newEmail" required>
                </div>
                <div class="form-group">
                    <label>>_ set.password:</label>
                    <input type="password" name="newPassword" required>
                </div>
                <div class="form-group">
                    <label>>_ confirm.password:</label>
                    <input type="password" name="newRepeatPassword" required>
                </div>
                <button type="submit" name="btn_register" value="1" class="btn" style="border-color: #00E5FF; color: #00E5FF;">>_ execute register</button>
            </form>
            
            <div class="toggle-form">
                ¿Ya tienes credenciales? <a href="login.php" style="color: #FF007F;">Volver al login</a>
            </div>
        </div>
    </div>
</body>
</html>