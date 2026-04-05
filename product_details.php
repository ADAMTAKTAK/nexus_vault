<?php
session_start();
include "model/conn.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: index.php");
    exit();
}

$product_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("<div style='background:#0D0D0D; color:#FF007F; font-family:monospace; padding:50px; text-align:center;'>
            <h1>[FATAL ERROR] 404_HARDWARE_NOT_FOUND</h1>
            <p>La referencia solicitada no existe en la bóveda.</p>
            <a href='index.php' style='color:#00E5FF;'>Volver al catálogo</a>
         </div>");
}

$product = $result->fetch_object();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>SPECS // <?php echo htmlspecialchars($product->product_name); ?></title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <nav class="navbar">
        <div class="brand-header">
            <a href="index.php">>_ [ <span class="brand-text">NEXUS</span> <span class="slash">//</span> <span class="brand-text">VAULT</span> ]</a>
        </div>
        <div class="nav-links">
            <a href="cart.php">>_ cart</a>
            <?php if(isset($_SESSION['id'])): ?>
                <a href="profile.php" style="color:#00E5FF;">>_ <?php echo $_SESSION['user_name']; ?></a>
                <?php if($_SESSION['user_role'] === 'admin'): ?>
                    <a href="admin/admin_dashboard.php" style="color:#FF007F; font-weight:bold;">[ADMIN_SYS]</a>
                <?php endif; ?>
                <a href="controllers/logout_controller.php" style="color:#FF007F; font-size: 0.85rem;">[LOGOUT]</a>
            <?php else: ?>
                <a href="login.php" style="color:#39FF14;">>_ sys.login</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container">
        <div style="margin-bottom: 20px;">
            <a href="index.php" style="color: #00E5FF; text-decoration: none; font-family: 'Fira Code', monospace;"><< return_catalog</a>
        </div>

        <div style="display: flex; gap: 40px; flex-wrap: wrap; align-items: flex-start;">
            
            <div style="flex: 1; min-width: 300px; border: 1px solid #333; background: rgba(0, 229, 255, 0.02); padding: 30px; text-align: center;">
                <img src="<?php echo htmlspecialchars($product->product_image); ?>" alt="<?php echo htmlspecialchars($product->product_name); ?>" style="width: 100%; max-width: 400px; height: auto; object-fit: contain; filter: drop-shadow(0 0 10px rgba(0, 229, 255, 0.2));">
            </div>

            <div style="flex: 1.5; min-width: 300px;">
                <h2 style="color: #00E5FF; font-family: 'Orbitron', sans-serif; font-size: 2rem; margin-bottom: 10px;">
                    <?php echo htmlspecialchars($product->product_name); ?>
                </h2>
                <p style="color: #FF007F; font-size: 1.5rem; font-weight: bold; margin-bottom: 20px;">
                    <?php echo number_format($product->product_price, 2); ?>_USD
                </p>

                <pre class="code-block" style="font-size: 1rem; margin-bottom: 30px;">
<span class="keyword">struct</span> <span class="variable">Hardware_Details</span> {
  id: <span class="keyword"><?php echo sprintf('%04d', $product->id); ?></span>;
  status: <span class="string">"IN_STOCK"</span>;
  description: <span class="string">"<?php echo htmlspecialchars($product->product_description); ?>"</span>;
}</pre>

               <form action="controllers/add_to_cart_controller.php" method="POST" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
                    <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                    
                    <div style="display: flex; flex-direction: column;">
                        <label style="color: #00E5FF; font-size: 0.8rem; margin-bottom: 5px;">>_ qty:</label>
                        <input type="number" name="quantity" value="1" min="1" max="10" style="width: 80px; text-align: center;">
                    </div>
                    
                    <button type="submit" name="btn_add_cart" value="1" class="btn" style="flex-grow: 1; padding: 15px; font-size: 1.2rem; background: rgba(57, 255, 20, 0.1);">
                        >_ ADD_TO_CART
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</body>
</html>