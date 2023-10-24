<?php

    include_once('config.php');

    if(isset($_POST['update']))
    {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $telefone = $_POST['telefone'];
        $sexo = $_POST['genero'];
        $data_nasc = $_POST['data_nascimento'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $endereco = $_POST['endereco'];

        $sqlUpdate = "UPDATE usuarios SET nome=:nome, email=:email, senha=:senha, telefone=:telefone, sexo=:sexo, data_nasc=:data_nasc, cidade=:cidade, estado=:estado, endereco=:endereco WHERE id = :id";
        
        $stmt = $conexao->prepare($sqlUpdate);

        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
        $stmt->bindParam(':sexo', $sexo, PDO::PARAM_STR);
        $stmt->bindParam(':data_nasc', $data_nasc, PDO::PARAM_STR);
        $stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':endereco', $endereco, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);

        $stmt->execute();
    } else
    {
        header("Location: sistema.php");
    }
    
    header("Location: sistema.php");

?>