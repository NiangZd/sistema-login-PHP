<?php
   session_start();
   include_once('config.php');
   require_once 'vendor/autoload.php';
   use GuzzleHttp\Client;
   
   if ((!isset($_SESSION['email'])) && (!isset($_SESSION['senha']))){
       unset($_SESSION['email']);
       unset($_SESSION['senha']);
       header('Location: login.php');
   } 
   
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
   
   ?>
<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>TESTE CHAT</title>
      <link rel="stylesheet" href="css/chatTeste.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"></script>
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
      <link rel="stylesheet" href="css/sistema.css">
   </head>
   <?php
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;
$protocolo = isset($_GET['user_id']) ? $_GET['user_id'] : null;

$nomeUsuarioAtual = "";
foreach ($usuarios as $usuario) {
   if ($usuario['email'] === $logado) {
      $nomeUsuarioAtual = $usuario['nome'];
      break;
   }
}

// Consultar o banco de dados para obter os protocolos ativos
$sql = "SELECT protocolos.id
        FROM protocolos
        WHERE protocolos.status_protocol = 'Ativo'";
$stmt = $conexao->prepare($sql);
$stmt->execute();
$protocolosAtivos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$protocolo_ids = array_column($protocolosAtivos, 'id');

// Consultar o banco de dados para obter as mensagens relacionadas aos protocolos ativos
$sql = "SELECT msgbd.remetente, msgbd.mensagem, msgbd.protocolocvs
        FROM msgbd
        WHERE msgbd.protocolocvs IN (" . implode(",", $protocolo_ids) . ")
          AND msgbd.status_protocol_msg = 'Ativo'";
$stmt = $conexao->prepare($sql);
$stmt->execute();

$mensagens = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
   $mensagem = array(
      'remetente' => $row['remetente'],
      'mensagem' => $row['mensagem'],
      'protocolocvs' => $row['protocolocvs']
   );
   array_push($mensagens, $mensagem);
}

echo "<h1 class='h1-sis'>Esta é a área de chat, $nomeUsuarioAtual <u></u> </h1>";
?>

<body>
   <script>
      chat.innerHTML = '';
   </script>
   <div class="container py-5 px-4">
      <div class="row rounded-lg overflow-hidden shadow">
         <!-- Users box-->
         <div class="col-5 px-0">
            <div class="bg-white">
               <div class="bg-gray px-4 py-2 bg-light">
                  <p class="h5 mb-0 py-1">MENSAGENS</p>
               </div>
               <div class="messages-box">
   <div class="list-group rounded-0">
      <?php
      foreach ($protocolosAtivos as $protocolo) {
         $protocolo_id = $protocolo['id'];
         $mensagens_protocolo = array_filter($mensagens, function ($mensagem) use ($protocolo_id) {
            return $mensagem['protocolocvs'] == $protocolo_id;
         });

         $usuario_protocolo = null;
         if (!empty($mensagens_protocolo)) {
            $mensagem_protocolo = reset($mensagens_protocolo);
            $remetente = $mensagem_protocolo['remetente'];

            foreach ($usuarios as $usuario) {
               if ($usuario['nome'] === $nomeUsuarioAtual) {
                  continue; // pular o usuário atual
               }
               if ($usuario['nome'] === $remetente) {
                  $usuario_protocolo = $usuario;
                  break;
               }
            }
         }

         echo '<a href="?user_id=' . $protocolo_id . '" class="list-group-item list-group-item-action rounded-0">
            <div class="media">
               <img src="https://bootstrapious.com/i/snippets/sn-chat/avatar.svg" alt="user" width="50" class="rounded-circle">
               <div class="media-body ml-4">
                  <div class="d-flex align-items-center justify-content-between mb-1">
                     <h6 class="mb-0">' . ($usuario_protocolo ? $usuario_protocolo['nome'] : 'Protocolo ' . $protocolo_id) . '</h6>
                     <small class="small font-weight-bold">25 Dec</small>
                  </div>
                  <p class="font-italic mb-0 text-small">' . (!empty($mensagens_protocolo) ? $mensagem_protocolo['mensagem'] : 'SEM MENSAGEM') . '</p>
               </div>
            </div>
         </a>';
      }
      ?>
   </div>
</div>

            </div>
         </div>
         <!-- Chat Box-->
         <div class="col-7 px-0">
   <div class="px-4 py-5 chat-box bg-white">
      <div id="chat">
         <?php
         if (isset($_GET['user_id'])) {
            $protocolo_id = $_GET['user_id'];
            $mensagens_protocolo = array_filter($mensagens, function($mensagem) use ($protocolo_id) {
               return $mensagem['protocolocvs'] == $protocolo_id;
            });

            if (!empty($mensagens_protocolo)) {
               foreach ($mensagens_protocolo as $mensagem) {
                  $class = ($mensagem['remetente'] == $nomeUsuarioAtual) ? "self" : "other";
                  echo "<div class='chat-message $class'><b class='height-name'>" . $mensagem['remetente'] . ":  </b>" . $mensagem['mensagem'] . "</div>";
               }
            } else {
               echo "<p>Não há mensagens para exibir.</p>";
            }
         }
         ?>
      </div>
   </div>
            <!-- Typing area -->
            <input class="form-control rounded-0 border-0 py-4 bg-light" id="input" type="text" placeholder="Sua mensagem"/>
         </div>
      </div>
   </div>

   <script>
         var css = document.createElement('link');
         css.setAttribute('rel', 'stylesheet');
         css.setAttribute('type', 'text/css');
         css.setAttribute('href', 'css/chatTeste.css');
         document.getElementsByTagName('head')[0].appendChild(css);
         
         
         let chat = document.getElementById('chat');
         let input = document.getElementById('input');
         const socket = new WebSocket('ws://localhost:9990/chat');
         
         socket.addEventListener('open', function (event) {
         console.log('Conexão do WebSocket aberta!');
         });
         
         socket.addEventListener('message', function (event) {
         const data = JSON.parse(event.data);
         let mensagemHTML = "<p class='no-margin'><b>" + data.remetente + ": </b>" + data.mensagem + "</p>";
         let mensagemElement = document.createElement('div');
         mensagemElement.innerHTML = mensagemHTML;
         if (data.remetente === "<?php echo $nomeUsuarioAtual; ?>") {
         mensagemElement.classList.add("chat-message", "self"); // adiciona a classe CSS "enviada"
         chat.scrollTop = chat.scrollHeight;
         } else {
         mensagemElement.classList.add("chat-message", "other");
         chat.scrollTop = chat.scrollHeight;
         }
         chat.appendChild(mensagemElement);
         });
         
         
         function enviarMensagem() {
          const mensagem = input.value.trim();
         
          if (mensagem) {
              const data = {
                  remetente: "<?php echo $nomeUsuarioAtual; ?>",
                  destinatario: "J. Victor",
                  protocolo: <?php echo $_GET['user_id']?>,
                  mensagem: mensagem
              };
         
              socket.send(JSON.stringify(data));
              
              // Insere a mensagem no banco de dados
              const xhr = new XMLHttpRequest();
               xhr.open("POST", "inserir_mensagem.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
               if (xhr.readyState === 4 && xhr.status === 200) {
                  console.log(xhr.responseText);
               }
            };
            xhr.send("remetente=" + encodeURIComponent(data.remetente) + "&destinatario=" + encodeURIComponent(data.destinatario) + "&mensagem=" + encodeURIComponent(data.mensagem) + "&protocolo=" + encodeURIComponent(data.protocolo));

              
              input.value = '';
          }
         }
         
         document.addEventListener('keydown', function(event) {
          if (event.code === 'Enter' || event.code === 'NumpadEnter') {
              event.preventDefault();
              enviarMensagem();
          }
      });
      </script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
   </body>
</html>