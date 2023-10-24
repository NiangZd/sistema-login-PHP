<?php

    session_start();


    if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha']))
    {

            //ACESSA O SISTEMA

            include_once('config.php');

            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $sql = "SELECT * FROM usuarios WHERE email = :email and senha = :senha";

            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount() < 1)
            {   
                unset($_SESSION['email']);
                unset($_SESSION['senha']);
                header('Location: login.php');
            }else{    
                $_SESSION['email'] = $email;
                $_SESSION['senha'] = $senha;

                header('Location: sistema.php');
                    }

            }else{
                header('Location: login.php');
    }


?>