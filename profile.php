<?php
    session_start();
    if(!isset($_SESSION["id"])){
        header("location: login.php");
        exit();
    }

    include "model/conn.php";

    $user_id = $_SESSION["id"];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_object();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PROFILE // NEXUS VAULT</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <nav class="navbar">
        <div class="brand-header">
            <a href="index.php">>_ [ <span class="brand-text">NEXUS</span> <span class="slash">//</span> <span class="brand-text">VAULT</span> ]</a>
        </div>
        <div class="nav-links">
            <a href="index.php" style="color:#00E5FF;">>_ return_catalog</a>
           <?php if($_SESSION['user_role'] === 'admin'): ?>
                    <a href="admin/admin_dashboard.php" style="color:#FF007F; font-weight:bold;">[ADMIN_SYS]</a>
            <?php endif; ?>
            <a href="controllers/logout_controller.php" style="color:#FF007F; font-size: 0.85rem;">[LOGOUT]</a>
        </div>
    </nav>

    <div class="container" style="display: flex; justify-content: center; align-items: center; min-height: 70vh;">
        
        <div class="auth-wrapper" style="padding: 20px;">
        <div class="auth-container" style="border-color: #00E5FF; width: 100%; max-width: 500px; box-sizing: border-box; margin: 0 auto;">
            <h2 style="color:#00E5FF; font-family:'Orbitron', sans-serif; margin-bottom: 20px; text-align: center;">>_ USER_PROFILE</h2>
            
            <div style="border: 1px solid #333; background: rgba(0, 0, 0, 0.4); padding: 20px; margin-bottom: 20px;">
                <p style="margin-bottom: 10px; color: #E0E0E0;">
                    <span style="color: #FF007F;">ID_SYS:</span> <?php echo sprintf('%04d', $userData->id); ?>
                </p>
                <p style="margin-bottom: 10px; color: #E0E0E0;">
                    <span style="color: #FF007F;">NOMBRE:</span> <?php echo htmlspecialchars($userData->first_name); ?>
                </p>
                <p style="margin-bottom: 10px; color: #E0E0E0;">
                    <span style="color: #FF007F;">APELLIDO:</span> <?php echo htmlspecialchars($userData->last_name); ?>
                </p>
                <p style="margin-bottom: 10px; color: #E0E0E0;">
                    <span style="color: #FF007F;">EMAIL:</span> <?php echo htmlspecialchars($userData->email); ?>
                </p>
                <p style="color: #E0E0E0;">
                    <span style="color: #FF007F;">PRIVILEGIOS:</span> 
                    <span style="color: <?php echo ($userData->user_role === 'admin') ? '#FF007F' : '#39FF14'; ?>;">
                        [<?php echo strtoupper($userData->user_role); ?>]
                    </span>
                </p>
            </div>

            <div style="text-align: center;">
                <a href="edit_profile.php" class="btn">>_ edit_profile_data</a>
            </div>
        </div>

    </div>
</body>
</html>