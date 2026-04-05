<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION['user_role'] !== 'admin') {
    header("location: ../index.php");
    exit();
}
include "../model/conn.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: admin_products.php");
    exit();
}

$target_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $target_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("location: admin_products.php");
    exit();
}

$p = $result->fetch_object();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT_HARDWARE // NEXUS VAULT</title>
    <link rel="stylesheet" href="../styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="auth-wrapper" style="padding: 20px;">
        <div class="auth-container" style="border-color: #00E5FF; width: 100%; max-width: 500px; box-sizing: border-box; margin: 0 auto;">
            <h2 style="color:#00E5FF; font-family:'Orbitron'; text-align:center; margin-bottom:20px; word-break: break-word; font-size: clamp(1.5rem, 5vw, 2rem);">>_ EDITAR_COMPONENTE</h2>
            <p style="text-align: center; color: #777; margin-bottom: 20px;">ID_SYS: <?php echo sprintf('%04d', $p->id); ?></p>
            
            <form action="../controllers/admin_product_controller.php" method="POST">
                <input type="hidden" name="target_id" value="<?php echo $p->id; ?>">
                
                <div class="form-group">
                    <label style="color: #00E5FF;">>_ nombre_producto:</label>
                    <input type="text" name="product_name" value="<?php echo htmlspecialchars($p->product_name); ?>" required>
                </div>
                
                <div class="form-group">
                    <label style="color: #00E5FF;">>_ precio (USD):</label>
                    <input type="number" step="0.01" name="product_price" value="<?php echo $p->product_price; ?>" required>
                </div>

                <div class="form-group">
                    <label style="color: #00E5FF;">>_ ruta_imagen (ej: assets/products/img.png):</label>
                    <input type="text" name="product_image" value="<?php echo htmlspecialchars($p->product_image); ?>" required>
                </div>

                <div class="form-group">
                    <label style="color: #00E5FF;">>_ descripcion_tecnica:</label>
                    <textarea name="product_description" rows="4" required style="width: 100%; background: transparent; border: 1px solid #333; color: #E0E0E0; padding: 12px; font-family: 'Fira Code', monospace; resize: vertical;"><?php echo htmlspecialchars($p->product_description); ?></textarea>
                </div>

                <button type="submit" name="action" value="edit_product" class="btn" style="border-color: #00E5FF; color: #00E5FF; margin-top: 15px;">>_ OVERWRITE_DATA</button>
            </form>
            
            <div class="toggle-form"><a href="admin_products.php" style="color: #777;">[CANCELAR_OPERACIÓN]</a></div>
        </div>
    </div>
</body>
</html>