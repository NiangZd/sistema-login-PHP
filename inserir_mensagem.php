<?php
session_start();
include_once('config.php');

if ((!isset($_SESSION['email'])) && (!isset($_SESSION['senha']))) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: login.php');
} 

$logado = $_SESSION['email'];
$remetente = $_POST['remetente'];
$destinatario = $_POST['destinatario'];
$mensagem = $_POST['mensagem'];
$timestamp = $_POST['timestamp'];
$protocolo = $_POST['protocolo'];
$defineAtive = "Ativo";

// Verificar se já existe uma mensagem com o mesmo conteúdo e o mesmo timestamp
$sql = "SELECT COUNT(*) FROM msgbd WHERE remetente=:remetente AND mensagem=:mensagem AND timestamp=:timestamp";
$stmt = $conexao->prepare($sql);
$stmt->bindValue(':remetente', $remetente);
$stmt->bindValue(':mensagem', $mensagem);
$stmt->bindValue(':timestamp', $timestamp);
$stmt->execute();
$count = $stmt->fetchColumn();

if ($count == 0) {
    // Inserir a nova mensagem no banco de dados
    $sql = "INSERT INTO msgbd (remetente, destinatario, mensagem, timestamp, protocolocvs, status_protocol_msg) VALUES (:remetente, :destinatario, :mensagem, :timestamp, :protocolo, :statusProtocolo)";
$stmt = $conexao->prepare($sql);
$stmt->bindValue(':remetente', $remetente);
$stmt->bindValue(':destinatario', $destinatario);
$stmt->bindValue(':mensagem', $mensagem);
$stmt->bindValue(':timestamp', $timestamp);
$stmt->bindValue(':protocolo', $protocolo);
$stmt->bindValue(':statusProtocolo', $defineAtive);
$stmt->execute();

}

$conexao = null;
?>
