<?php
    if(!empty($_GET['id']))
    {
        include_once('config.php');

        $id = $_GET['id'];

        $sqlSelect = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $conexao->prepare($sqlSelect);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            $sqlDelete = "DELETE FROM usuarios WHERE id=:id";
            $stmt = $conexao->prepare($sqlDelete);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
    }
        
    header('Location: sistema.php');
?>