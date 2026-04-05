<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION['user_role'] !== 'admin') {
    header("location: ../index.php");
    exit();
}
include "../model/conn.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER_MANAGEMENT // NEXUS VAULT</title>
    <link rel="stylesheet" href="../styles.css?v=<?php echo time(); ?>"> </head>
<body>
    <nav class="navbar" style="border-bottom-color: #39FF14;">
        <div class="brand-header">
            <a href="../index.php">>_ [ <span class="brand-text">NEXUS</span> <span class="slash">//</span> <span class="brand-text" style="color:#39FF14;">USER_SYS</span> ]</a>
        </div>
        <div class="nav-links">
            <a href="admin_dashboard.php" style="color:#FF007F;">>_ return_admin_hub</a>
            <a href="../profile.php">>_ <?php echo $_SESSION['user_name']; ?></a>
            <a href="../controllers/logout_controller.php" style="color:#FF007F; font-size: 0.85rem;">[LOGOUT]</a> </div>
    </nav>

    <div class="container">
        <h2 style="color:#39FF14; font-family:'Orbitron', sans-serif; margin-bottom: 20px;">>_ GESTIÓN DE USUARIOS</h2>
        
        <div style="border: 1px solid #39FF14; background: rgba(57, 255, 20, 0.05); padding: 20px; margin-bottom: 40px;">
            <h3 style="color: #39FF14; margin-bottom: 15px; font-size: 1.1rem;">[+] AGREGAR_NUEVO_REGISTRO</h3>
            
            <form action="../controllers/admin_user_controller.php" method="POST" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end;">
                <div style="flex: 1; min-width: 150px;">
                    <label style="color: #00E5FF; font-size: 0.8rem; margin-bottom: 5px;">>_ nombre:</label>
                    <input type="text" name="firstName" required style="border-color: #333;">
                </div>
                <div style="flex: 1; min-width: 150px;">
                    <label style="color: #00E5FF; font-size: 0.8rem; margin-bottom: 5px;">>_ apellido:</label>
                    <input type="text" name="lastName" required style="border-color: #333;">
                </div>
                <div style="flex: 1.5; min-width: 200px;">
                    <label style="color: #00E5FF; font-size: 0.8rem; margin-bottom: 5px;">>_ email:</label>
                    <input type="email" name="email" required style="border-color: #333;">
                </div>
                <div style="flex: 1; min-width: 150px;">
                    <label style="color: #00E5FF; font-size: 0.8rem; margin-bottom: 5px;">>_ password:</label>
                    <input type="password" name="password" required style="border-color: #333;">
                </div>
                <div style="flex: 0.5; min-width: 100px;">
                    <label style="color: #00E5FF; font-size: 0.8rem; margin-bottom: 5px;">>_ rol:</label>
                    <select name="role" style="width: 100%; padding: 12px; background: transparent; border: 1px solid #333; color: #E0E0E0; font-family: 'Fira Code';">
                        <option value="normal" style="background: #0D0D0D;">normal</option>
                        <option value="admin" style="background: #0D0D0D;">admin</option>
                    </select>
                </div>
                <button type="submit" name="action" value="add_user" class="btn" style="border-color: #39FF14; color: #39FF14; width: auto; padding: 12px 20px;">[EXECUTE]</button>
            </form>
        </div>

        <div style="border: 1px solid #333; background: rgba(0, 0, 0, 0.4); padding: 20px; width: 100%; box-sizing: border-box; overflow-x: auto;">
            <table class="cart-table" style="width: 100%; min-width: 800px;">
                <thead>
                    <tr>
                        <th style="color: #39FF14;">ID</th>
                        <th style="color: #39FF14;">USUARIO</th>
                        <th style="color: #39FF14;">EMAIL</th>
                        <th style="color: #39FF14;">ROL</th>
                        <th style="color: #39FF14;">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM users ORDER BY id ASC";
                    $result = $conn->query($sql);
                    while ($u = $result->fetch_object()):
                    ?>
                    <tr>
                        <td style="color: #E0E0E0;"><?php echo sprintf('%04d', $u->id); ?></td>
                        <td style="color: #E0E0E0;"><?php echo htmlspecialchars($u->first_name . ' ' . $u->last_name); ?></td>
                        <td style="color: #00E5FF;"><?php echo htmlspecialchars($u->email); ?></td>
                        <td style="color: <?php echo ($u->user_role === 'admin') ? '#FF007F' : '#E0E0E0'; ?>;">
                            [<?php echo strtoupper($u->user_role); ?>]
                        </td>
                        <td style="white-space: nowrap;">
                            <a href="admin_edit_user.php?id=<?php echo $u->id; ?>" style="color: #00E5FF; text-decoration: none; margin-right: 15px;">[EDIT]</a>
                            
                            <?php if ($u->user_role === 'normal'): ?>
                                <a href="../controllers/admin_user_controller.php?action=ascend&id=<?php echo $u->id; ?>" style="color: #39FF14; text-decoration: none; margin-right: 15px;">[MAKE_ADMIN]</a>
                            <?php else: ?>
                                <?php if ($u->id != $_SESSION['id']): ?>
                                    <a href="../controllers/admin_user_controller.php?action=demote&id=<?php echo $u->id; ?>" style="color: #777; text-decoration: none; margin-right: 15px;">[REVOKE_ADMIN]</a>
                                <?php else: ?>
                                    <span style="color: #333; margin-right: 15px;" title="No puedes revocar tus propios poderes">[REVOKE_ADMIN]</span>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php if ($u->id != $_SESSION['id']): ?>
                                <a href="../controllers/admin_user_controller.php?action=delete&id=<?php echo $u->id; ?>" style="color: #FF007F; text-decoration: none;">[DROP]</a>
                            <?php else: ?>
                                <span style="color: #333;">[DROP]</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>