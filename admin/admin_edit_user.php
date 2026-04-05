<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION['user_role'] !== 'admin') {
    header("location: ../index.php");
    exit();
}
include "../model/conn.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: admin_users.php");
    exit();
}

$target_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $target_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("location: admin_users.php");
    exit();
}

$u = $result->fetch_object();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT_USER // NEXUS VAULT</title>
    <link rel="stylesheet" href="../styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-container" style="border-color: #00E5FF; width: 100%; max-width: 500px; box-sizing: border-box; margin: 0 auto;">
            <h2 style="color:#00E5FF; font-family:'Orbitron'; text-align:center; margin-bottom:20px; word-break: break-word; font-size: clamp(1.5rem, 5vw, 2rem);">>_ EDITAR_USUARIO</h2>
            <p style="text-align: center; color: #777; margin-bottom: 20px;">ID_SYS: <?php echo sprintf('%04d', $u->id); ?></p>
            
            <form action="../controllers/admin_user_controller.php" method="POST">
                <input type="hidden" name="target_id" value="<?php echo $u->id; ?>">
                
                <div class="form-group">
                    <label style="color: #00E5FF;">>_ nombre:</label>
                    <input type="text" name="firstName" value="<?php echo htmlspecialchars($u->first_name); ?>" required>
                </div>
                <div class="form-group">
                    <label style="color: #00E5FF;">>_ apellido:</label>
                    <input type="text" name="lastName" value="<?php echo htmlspecialchars($u->last_name); ?>" required>
                </div>
                <div class="form-group">
                    <label style="color: #00E5FF;">>_ email:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($u->email); ?>" required>
                </div>
                
                <?php if ($u->id != $_SESSION['id']): ?>
                    <div class="form-group">
                        <label style="color: #00E5FF;">>_ rol:</label>
                        <select name="role" style="width: 100%; padding: 12px; background: transparent; border: 1px solid #333; color: #E0E0E0; font-family: 'Fira Code';">
                            <option value="normal" <?php if($u->user_role === 'normal') echo 'selected'; ?> style="background: #0D0D0D;">normal</option>
                            <option value="admin" <?php if($u->user_role === 'admin') echo 'selected'; ?> style="background: #0D0D0D;">admin</option>
                        </select>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="role" value="<?php echo $u->user_role; ?>">
                    <p style="color: #FF007F; font-size: 0.8rem; text-align: center; margin-bottom: 15px;">[ PROTECCIÓN: No puedes alterar tu propio rol aquí ]</p>
                <?php endif; ?>

                <button type="submit" name="action" value="edit_user" class="btn" style="border-color: #00E5FF; color: #00E5FF;">>_ OVERWRITE_DATA</button>
            </form>
            <div class="toggle-form"><a href="admin_users.php" style="color: #777;">[CANCELAR_OPERACIÓN]</a></div>
        </div>
    </div>
</body>
</html>