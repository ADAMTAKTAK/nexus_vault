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
    <title>HARDWARE_SYS // NEXUS VAULT</title>
    <link rel="stylesheet" href="../styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <nav class="navbar" style="border-bottom-color: #00E5FF;">
        <div class="brand-header">
            <a href="../index.php">>_ [ <span class="brand-text">NEXUS</span> <span class="slash">//</span> <span class="brand-text" style="color:#00E5FF;">HARDWARE_SYS</span> ]</a>
        </div>
        <div class="nav-links">
            <a href="admin_dashboard.php" style="color:#FF007F;">>_ return_admin_hub</a>
            <a href="../profile.php">>_ <?php echo $_SESSION['user_name']; ?></a>
            <a href="../controllers/logout_controller.php" style="color:#FF007F; font-size: 0.85rem;">[LOGOUT]</a>
        </div>
    </nav>

    <div class="container">
        <h2 style="color:#00E5FF; font-family:'Orbitron', sans-serif; margin-bottom: 20px;">>_ GESTIÓN DE HARDWARE</h2>
        
        <div style="border: 1px solid #00E5FF; background: rgba(0, 229, 255, 0.05); padding: 20px; margin-bottom: 40px;">
            <h3 style="color: #00E5FF; margin-bottom: 15px; font-size: 1.1rem;">[+] INGRESAR_NUEVO_COMPONENTE</h3>
            
            <form action="../controllers/admin_product_controller.php" method="POST" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end;">
                <div style="flex: 2; min-width: 200px;">
                    <label style="color: #39FF14; font-size: 0.8rem; margin-bottom: 5px;">>_ nombre_producto:</label>
                    <input type="text" name="product_name" required style="border-color: #333;">
                </div>
                <div style="flex: 1; min-width: 100px;">
                    <label style="color: #39FF14; font-size: 0.8rem; margin-bottom: 5px;">>_ precio (USD):</label>
                    <input type="number" step="0.01" name="product_price" required style="border-color: #333;">
                </div>
                <div style="flex: 2; min-width: 200px;">
                    <label style="color: #39FF14; font-size: 0.8rem; margin-bottom: 5px;">>_ ruta_imagen (ej: assets/products/rtx.png):</label>
                    <input type="text" name="product_image" value="assets/products/placeholder.png" required style="border-color: #333;">
                </div>
                <div style="flex: 3; min-width: 100%; margin-top: 10px;">
                    <label style="color: #39FF14; font-size: 0.8rem; margin-bottom: 5px;">>_ descripcion_tecnica:</label>
                    <textarea name="product_description" rows="2" required style="width: 100%; background: transparent; border: 1px solid #333; color: #E0E0E0; padding: 10px; font-family: 'Fira Code', monospace;"></textarea>
                </div>
                <button type="submit" name="action" value="add_product" class="btn" style="border-color: #00E5FF; color: #00E5FF; width: 100%; padding: 12px 20px; margin-top: 10px;">[EXECUTE_INSERT]</button>
            </form>
        </div>

        <div style="border: 1px solid #333; background: rgba(0, 0, 0, 0.4); padding: 20px; width: 100%; box-sizing: border-box; overflow-x: auto;">
            <table class="cart-table" style="width: 100%; min-width: 800px;">
                <thead>
                    <tr>
                        <th style="color: #00E5FF;">ID</th>
                        <th style="color: #00E5FF;">IMAGEN</th>
                        <th style="color: #00E5FF;">COMPONENTE</th>
                        <th style="color: #00E5FF;">PRECIO</th>
                        <th style="color: #00E5FF;">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM products ORDER BY id ASC";
                    $result = $conn->query($sql);
                    while ($p = $result->fetch_object()):
                    ?>
                    <tr>
                        <td style="color: #E0E0E0; vertical-align: middle;"><?php echo sprintf('%04d', $p->id); ?></td>
                        
                        <td style="vertical-align: middle;">
                            <img src="../<?php echo htmlspecialchars($p->product_image); ?>" alt="img" style="width: 50px; height: 50px; object-fit: contain; vertical-align: middle;">
                        </td>
                        
                        <td style="color: #E0E0E0; vertical-align: middle;"><?php echo htmlspecialchars($p->product_name); ?></td>
                        <td style="color: #39FF14; vertical-align: middle;"><?php echo number_format($p->product_price, 2); ?>_USD</td>
                        
                        <td style="vertical-align: middle;">
                            <a href="admin_edit_product.php?id=<?php echo $p->id; ?>" style="color: #00E5FF; text-decoration: none; margin-right: 15px;">[EDIT]</a>
                            <a href="../controllers/admin_product_controller.php?action=delete&id=<?php echo $p->id; ?>" style="color: #FF007F; text-decoration: none;" onclick="return confirm('¿Seguro que deseas purgar este hardware del catálogo?');">[DROP]</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>