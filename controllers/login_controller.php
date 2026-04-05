<?php
    if(!empty($_POST['btn_login'])){
        if(!empty($_POST['email']) and !empty($_POST['password'])){

            $email = trim($_POST['email']);
            $pass = $_POST['password'];

            $stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->bind_param('s', $email);
            $stmt->execute();

            $result = $stmt->get_result();
            $usuario = $result->fetch_object();

            if($usuario && password_verify($pass, $usuario->password)){
                
                $_SESSION["id"] = $usuario->id;
                $_SESSION["user_name"] = $usuario->first_name;
                $_SESSION["user_role"] = $usuario->user_role; 

                header("location: index.php");
                exit();
            } else {
                echo "<div class='sys-msg error'>[ERROR] Credenciales denegadas. Acceso restringido.</div>";
            }
        }
    }
?>