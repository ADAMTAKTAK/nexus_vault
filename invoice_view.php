<?php
session_start();
include "model/conn.php";
if (!isset($_SESSION["id"])) { header("location: login.php"); exit(); }

$invoice_id = $_GET['id'];

$stmt = $conn->prepare("SELECT total_price FROM invoices WHERE id = ?");
$stmt->bind_param("i", $invoice_id);
$stmt->execute();
$invoice_data = $stmt->get_result()->fetch_object();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <div class="auth-container" style="width: 100%; max-width: 700px; margin: 20px auto; padding: 25px; background: rgba(0,0,0,0.8); box-sizing: border-box;">
            <h1 style="color: #00E5FF; font-family: 'Orbitron'; text-align:center; word-break: break-word; font-size: clamp(1.5rem, 6vw, 2.5rem);">>_ RECEIPT_GENERATED</h1>
            <p style="text-align:center; margin-bottom: 20px;">ID_TRANSACCIÓN: #<?php echo sprintf('%06d', $invoice_id); ?></p>
            
            <div style="border-top: 1px dashed #FF007F; padding: 20px 0;">
                <p><strong>CLIENTE:</strong> <?php echo $_SESSION['user_name']; ?></p>
                <p><strong>FECHA:</strong> <?php echo date("d-m-Y H:i"); ?></p>
                <p><strong>ESTADO:</strong> <span style="color: #39FF14;">[PAID_SUCCESSFULLY]</span></p>
            </div>

            <div style="text-align: right; font-size: 1.5rem; border-top: 1px solid #333; padding-top: 20px;">
                <p style="color: #00E5FF;">TOTAL_FINAL: <span style="color: #FF007F;"><?php echo number_format($invoice_data->total_price, 2); ?>_USD</span></p>
                <p style="font-size: 0.8rem; color: #777;">* Este documento es un comprobante digital de hardware.</p>
            </div>

            <div class="no-print" style="margin-top: 40px; display: flex; gap: 10px; flex-wrap: wrap; align-items: stretch;">
                <button onclick="window.print()" class="btn" style="flex: 1; display: flex; justify-content: center; align-items: center; margin: 0; min-width: 200px;">>_ PRINT_INVOICE</button>
                <a href="index.php" class="btn" style="flex: 1; border-color: #00E5FF; color: #00E5FF; display: flex; justify-content: center; align-items: center; margin: 0; min-width: 200px;">>_ RETURN_TO_VAULT</a>
            </div>
        </div>
    </div>
</body>
</html>