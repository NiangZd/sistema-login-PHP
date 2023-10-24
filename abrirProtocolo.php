<?php
    session_start();
    include_once "config.php";
    if (!isset($_SESSION["email"]) && !isset($_SESSION["senha"])) {
        unset($_SESSION["email"]);
        unset($_SESSION["senha"]);
        header("Location: login.php");
    }



    //############################################################################
                            //ABERTURA DE PROTOCOLO
    //############################################################################



    $nome_user = "J. Victor";
    $numero_telefone = "5584981749795";

    $id = 1;
    $data_protocol = date("Y-m-d");

    $sql = "SELECT MAX(id) as max_id FROM protocolos";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    $id = $resultado["max_id"] + 1;

    $data_protocol = date("Y-m-d");
    $status_protocol = "Ativo";

    $sql = "INSERT INTO `protocolos`(`id`, `data_protocol`, `status_protocol`, `numero_user`, `nome_user`) 
                VALUES ('$id', '$data_protocol', '$status_protocol', '$numero_telefone', '$nome_user')";

    $stmt = $conexao->prepare($sql);

    if ($stmt->execute()) {
        echo "Registro inserido com sucesso. <br>";
    } else {
        echo "Erro ao inserir registro: " . $stmt->errorInfo()[2];
    }



    //############################################################################
                            //INSERIR NO BANCO DE DADOS
    //############################################################################



   $logado = $_SESSION['email'];
   
   $sql = "SELECT * FROM usuarios ORDER BY id DESC";
   $stmt = $conexao->prepare($sql);
   $stmt->execute();
   
   $usuarios = array();
   
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       $usuario = array(
           'nome' => $row['nome'],
           'email' => $row['email']
       );
       array_push($usuarios, $usuario);
   }

   $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;
      
      $nomeUsuarioAtual = "";
      foreach ($usuarios as $usuario) {
         if ($usuario['email'] === $logado) {
            $nomeUsuarioAtual = $usuario['nome'];
            break;
         }
    }

    $message_to_user =
        "OLÁ, *" . $nome_user . "*, SEU PROTOCOLO DE NÚMERO " . $id . " FOI ABERTO";

    $remetente = $nomeUsuarioAtual;
    $destinatario = $nome_user;
    $mensagem = $message_to_user;
    $timestamp = $_POST["timestamp"];
    $protocolo = $_POST["protocolo"];
    $ativarProtocolo = "Ativo";

    $sql =
        "INSERT INTO msgbd (remetente, destinatario, mensagem, timestamp, protocolocvs, status_protocol_msg) VALUES (:remetente, :destinatario, :mensagem, :timestamp, :protocolo, :status_protocol_msg)";
    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(":remetente", $remetente);
    $stmt->bindValue(":destinatario", $destinatario);
    $stmt->bindValue(":mensagem", $mensagem);
    $stmt->bindValue(":timestamp", $timestamp);
    $stmt->bindValue(":protocolo", $id);
    $stmt->bindValue(":status_protocol_msg", $ativarProtocolo);
    $stmt->execute();



    //############################################################################
                            //ENVIAR MENSAGEN NO Z-API
    //############################################################################



    $curl = curl_init();

    $data = [
        "phone" => $numero_telefone,
        "message" => $message_to_user,
    ];

    $jsonData = json_encode($data);

    $headers = ["Content-Type: application/json"];

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.z-api.io/instances/3B8E9C8C194F40306F640A394DBBCDD9/token/3B8E9C8C197650ECCCE80A394DBBCDD9/send-text",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $jsonData,
        CURLOPT_HTTPHEADER => $headers,
    ]);

    $response = curl_exec($curl);
    $error = curl_error($curl);

    curl_close($curl);

    if ($error) {
        echo "Ocorreu um erro ao enviar a mensagem: " . $error;
    } else {
        echo "Mensagem enviada com sucesso!";
    }
?>
