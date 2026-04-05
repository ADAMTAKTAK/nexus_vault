<?php
session_start();
include "model/conn.php";
$query = isset($_GET['query']) ? $_GET['query'] : "";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INDEX // NEXUS VAULT</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <nav class="navbar">
        <div class="brand-header">
            <a href="index.php">>_ [ <span class="brand-text">NEXUS</span> <span class="slash">//</span> <span class="brand-text">VAULT</span> ]</a>
        </div>
        
        <form class="search-form" method="GET">
            <input type="text" name="query" class="search-input" placeholder=">_ query_catalog..." value="<?php echo htmlspecialchars($query); ?>">
            <button type="submit" class="search-btn">[EXE]</button>
        </form>

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
        <h2 style="color:#00E5FF; margin-bottom:25px; font-family:'Orbitron';">>_ INVENTARIO_GLOBAL</h2>
        <div class="product-grid">
            <?php
            $sql = "SELECT * FROM products";
            if(!empty($query)) $sql .= " WHERE product_name LIKE '%$query%'";
            $res = $conn->query($sql);
            while($p = $res->fetch_object()): ?>
                <div class="product-card">
                    <img src="<?php echo $p->product_image; ?>" class="product-img">
                    <pre class="code-block">
<span class="keyword">struct</span> <span class="variable">Item_<?php echo $p->id; ?></span> {
  name:  <span class="string">"<?php echo $p->product_name; ?>"</span>;
  price: <span class="keyword"><?php echo $p->product_price; ?>_USD</span>;
}</pre>
                    <a href="product_details.php?id=<?php echo $p->id; ?>" class="btn">>_ VIEW_SPECS</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>