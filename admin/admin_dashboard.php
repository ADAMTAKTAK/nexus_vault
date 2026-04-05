<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION['user_role'] !== 'admin') {
    header("location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN_SYS // NEXUS VAULT</title>
    <link rel="stylesheet" href="../styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <nav class="navbar" style="border-bottom-color: #FF007F;">
        <div class="brand-header">
            <a href="../index.php">>_ [ <span class="brand-text">NEXUS</span> <span class="slash">//</span> <span class="brand-text" style="color:#FF007F;">ADMIN_SYS</span> ]</a>
        </div>
        <div class="nav-links">
            <a href="../index.php" style="color:#00E5FF;">>_ return_vault</a>
            <a href="../profile.php">>_ <?php echo $_SESSION['user_name']; ?></a>
            <a href="../controllers/logout_controller.php" style="color:#FF007F; font-size: 0.85rem;">[LOGOUT]</a>
        </div>
    </nav>

    <div class="container">
        <h2 style="color:#FF007F; font-family:'Orbitron', sans-serif; margin-bottom: 30px; text-align: center; word-break: break-word; font-size: clamp(1.5rem, 5vw, 2rem);">>_ ROOT_ACCESS_GRANTED</h2>
        
        <div style="display: flex; gap: 30px; justify-content: center; flex-wrap: wrap;">
            
            <div class="auth-container" style="flex: 1; min-width: 280px; max-width: 100%; box-sizing: border-box; border-color: #00E5FF; background: rgba(0, 229, 255, 0.05);">
                <h3 style="color: #00E5FF; margin-bottom: 15px; text-align: center;">>_ GESTIÓN DE HARDWARE</h3>
                <p style="color: #E0E0E0; font-size: 0.9rem; margin-bottom: 20px; text-align: center;">Añadir, editar o eliminar componentes del catálogo principal.</p>
                <a href="admin_products.php" class="btn" style="border-color: #00E5FF; color: #00E5FF;">>_ init_product_sys</a>
            </div>

            <div class="auth-container" style="flex: 1; min-width: 280px; max-width: 100%; box-sizing: border-box; border-color: #39FF14; background: rgba(57, 255, 20, 0.05);">
                <h3 style="color: #39FF14; margin-bottom: 15px; text-align: center;">>_ GESTIÓN DE USUARIOS</h3>
                <p style="color: #E0E0E0; font-size: 0.9rem; margin-bottom: 20px; text-align: center;">Ver registros, eliminar cuentas o ascender usuarios a administradores.</p>
                <a href="admin_users.php" class="btn" style="border-color: #39FF14; color: #39FF14;">>_ init_user_sys</a>
            </div>

        </div>
    </div>
</body>
</html>