<?php
session_start();
include "model/conn.php";
if (!isset($_SESSION["id"])) { header("location: login.php"); exit(); }

$invoice_id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>INVOICE #<?php echo $invoice_id; ?> // NEXUS VAULT</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; color: black; }
            .invoice-box { border: 1px solid black; color: black; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="auth-container" style="width: 100%; max-width: 700px; margin: 40px auto; background: rgba(0,0,0,0.8);">
            <h1 style="color: #00E5FF; font-family: 'Orbitron'; text-align:center;">>_ RECEIPT_GENERATED</h1>
            <p style="text-align:center; margin-bottom: 20px;">ID_TRANSACCIÓN: #<?php echo sprintf('%06d', $invoice_id); ?></p>
            
            <div style="border-top: 1px dashed #FF007F; padding: 20px 0;">
                <p><strong>CLIENTE:</strong> <?php echo $_SESSION['user_name']; ?></p>
                <p><strong>FECHA:</strong> <?php echo date("d-m-Y H:i"); ?></p>
                <p><strong>ESTADO:</strong> <span style="color: #39FF14;">[PAID_SUCCESSFULLY]</span></p>
            </div>

            <div style="text-align: right; font-size: 1.5rem; border-top: 1px solid #333; padding-top: 20px;">
                <p style="color: #00E5FF;">TOTAL_FINAL: <span style="color: #FF007F;">VER_SISTEMA_LOG</span></p>
                <p style="font-size: 0.8rem; color: #777;">* Este documento es un comprobante digital de hardware.</p>
            </div>

            <div class="no-print" style="margin-top: 40px; display: flex; gap: 10px;">
                <button onclick="window.print()" class="btn">>_ PRINT_INVOICE</button>
                <a href="index.php" class="btn" style="border-color: #00E5FF; color: #00E5FF;">>_ RETURN_TO_VAULT</a>
            </div>
        </div>
    </div>
</body>
</html>