<?php
    if(!empty($_POST["btn_register"])){
        if($_POST['newPassword'] === $_POST['newRepeatPassword']){

            $firstName = trim($_POST['firstName']);
            $lastName = trim($_POST['lastName']);
            $email = trim($_POST['newEmail']);
            $pass = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
            
            try {
                $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $firstName, $lastName, $email, $pass);               
                $stmt->execute();
                
                echo "<div class='sys-msg success'>[SYS] Usuario registrado exitosamente. Procede al login.</div>";
                
            } catch (mysqli_sql_exception $e) {

                if ($e->getCode() == 1062) {
                    echo "<div class='sys-msg error'>[ERROR] Este correo electrónico ya está registrado en la bóveda.</div>";
                } else {
                    echo "<div class='sys-msg error'>[ERROR] Fallo en la base de datos: " . $e->getMessage() . "</div>";
                }
            }
            
        } else {
            echo "<div class='sys-msg error'>[ERROR] Las contraseñas no coinciden. Verifique la sintaxis.</div>";
        }
    }
?>