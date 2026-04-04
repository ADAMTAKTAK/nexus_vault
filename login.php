<?php
    session_start();
    if(isset($_SESSION["id"])){ header("location: index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>LOGIN // NEXUS VAULT</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-container">
            <div class="brand-header">
                <div>>_ [ <span class="brand-text">NEXUS</span> <span class="slash">//</span> <span class="brand-text">VAULT</span> ]</div>
                <div style="font-size: 0.8rem; margin-top: 10px; color: #777;">USER_AUTH_SYS</div>
            </div>

            <?php
                include "model/conn.php";
                include "controllers/login_controller.php";
            ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label>>_ sys.email:</label>
                    <input type="email" name="email" required placeholder="user@domain.com">
                </div>
                <div class="form-group">
                    <label>>_ sys.password:</label>
                    <input type="password" name="password" required placeholder="********">
                </div>
                <button type="submit" name="btn_login" value="1" class="btn">>_ execute login</button>
            </form>
            
            <div class="toggle-form">
                ¿No tienes acceso? <a href="register.php" style="color: #00E5FF;">Inicializar registro</a>
            </div>
        </div>
    </div>
</body>
</html>