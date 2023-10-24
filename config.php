<?php

    $db_host = 'localhost';
    $db_userName = 'root';
    $db_password = '';
    $db_name = 'formpdo';

     try {
        $conexao = new PDO("mysql:host=$db_host;dbname=" . $db_name, $db_userName, $db_password); 
       //echo ("Conexão feita com sucesso");
    } catch (PDOException $err) {
        echo ("Conexão falhou");
    }

?>