<?php 
session_start(); 
if (!isset($_SESSION["id"])) {
    header("location: login.php");
    exit();
}

include "model/conn.php";
$user_id = $_SESSION["id"];

if (isset($_GET['remove'])) {
    $cart_id_to_remove = $_GET['remove'];
    $del = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $del->bind_param("ii", $cart_id_to_remove, $user_id);
    $del->execute();
    header("location: cart.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CART // NEXUS VAULT</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <nav class="navbar">
        <div class="brand-header">
            <a href="index.php">>_ [ <span class="brand-text">NEXUS</span> <span class="slash">//</span> <span class="brand-text">VAULT</span> ]</a>
        </div>
        <div class="nav-links">
            <a href="index.php" style="color:#00E5FF;">>_ return_catalog</a>
            <a href="profile.php">>_ <?php echo $_SESSION['user_name']; ?></a>
        </div>
    </nav>

    <div class="container">
        <h2 style="color:#00E5FF; font-family:'Orbitron', sans-serif; margin-bottom: 20px;">>_ SYSTEM_CART</h2>
        
        <div style="border: 1px solid #333; background: rgba(0, 229, 255, 0.02); padding: 20px;">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>ITEM</th>
                        <th>QTY</th>
                        <th>SUBTOTAL</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT c.id AS cart_id, c.quantity, p.product_name, p.product_price 
                            FROM cart c 
                            INNER JOIN products p ON c.product_id = p.id 
                            WHERE c.user_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    $total_general = 0;

                    if ($result->num_rows > 0):
                        while ($row = $result->fetch_object()):
                            $subtotal = $row->product_price * $row->quantity;
                            $total_general += $subtotal;
                    ?>
                        <tr>
                            <td style="color: #E0E0E0;"><?php echo htmlspecialchars($row->product_name); ?></td>
                            <td style="color: #39FF14;"><?php echo $row->quantity; ?></td>
                            <td style="color: #E0E0E0;"><?php echo number_format($subtotal, 2); ?>_USD</td>
                            <td>
                                <a href="cart.php?remove=<?php echo $row->cart_id; ?>" style="color: #FF007F; text-decoration:none;">[DROP]</a>
                            </td>
                        </tr>
                    <?php 
                        endwhile; 
                    else: 
                    ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: #777; padding: 30px;">
                                [ EMPTY_VAULT ] - No hay hardware en tu carrito.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <div style="margin-top: 30px; text-align: right;">
                <h3 style="color: #00E5FF; font-family: 'Fira Code', monospace;">
                    >_ TOTAL: <span style="color:#FF007F;"><?php echo number_format($total_general, 2); ?>_USD</span>
                </h3>
                
                <?php if ($total_general > 0): ?>
                    <a href="controllers/checkout_controller.php" class="btn" style="margin-top: 20px; width: auto; padding: 10px 20px;">>_ execute_checkout</a>
                <?php else: ?>
                    <button class="btn" disabled style="margin-top: 20px; width: auto; padding: 10px 20px; border-color: #333; color: #777; cursor: not-allowed;">>_ execute_checkout</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>