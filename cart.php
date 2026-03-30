<?php session_start(); ?>
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
                        <th>PRICE</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="color: #E0E0E0;">GeForce RTX 5090 Gigabyte</td>
                        <td style="color: #39FF14;">1</td>
                        <td style="color: #FF007F;">1,999.99_USD</td>
                        <td><a href="#" style="color: #FF007F; text-decoration:none;">[DROP]</a></td>
                    </tr>
                </tbody>
            </table>
            
            <div style="margin-top: 30px; text-align: right;">
                <h3 style="color: #00E5FF; font-family: 'Fira Code', monospace;">>_ TOTAL: <span style="color:#FF007F;">1,999.99_USD</span></h3>
                <a href="#" class="btn" style="margin-top: 20px; width: auto; padding: 10px 20px;">>_ execute_checkout</a>
            </div>
        </div>
    </div>
</body>
</html>