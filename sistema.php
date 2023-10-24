<?php
    session_start();
    include_once('config.php');
    require_once 'vendor/autoload.php';
    use GuzzleHttp\Client;

    if ((!isset($_SESSION['email'])) && (!isset($_SESSION['senha'])))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    } 

    $logado = $_SESSION['email'];

    $sql = "SELECT * FROM usuarios ORDER BY id DESC";

    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    $logado = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sistema.css">

    <title>Sistema</title>
    
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <p style="color: #fff;" class="navbar-brand parag-nav">Sistema VG</p>
    
      <a class="button-nav-vg" href="sair.php">Sair</a>

  </div>
</nav>

    <?php
    
        echo "<h1 class='h1-sis'>Bem vindo <u>$logado</u> </h1>";

    ?>

    <a class="button-chat" href="testechat.php">CHAT DO SISTEMA</a>

    <div>
        
    </div>

    <div class="m-5 table-bg">
                <table style="border-top: none;" class="table">
            <thead style="border-top: none;">
                <tr style="border-top: none;">
                    <th style="border-top: none;" scope="col">#</th>
                    <th style="border-top: none;" scope="col">Nome</th>
                    <th style="border-top: none;" scope="col">Email</th>
                    <th style="border-top: none;" scope="col">Senha</th>
                    <th style="border-top: none;" scope="col">Telefone</th>
                    <th style="border-top: none;" scope="col">Sexo</th>
                    <th style="border-top: none;" scope="col">Data de Nascimento</th>
                    <th style="border-top: none;" scope="col">Cidade</th>
                    <th style="border-top: none;" scope="col">Estado</th>
                    <th style="border-top: none;" scope="col">Endereço</th>
                    <th style="border-top: none;" scope="col">...</th>
                </tr>
            </thead>
            <tbody>
                
                <?php

                    while($user_data = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                        echo "<tr>";
                        echo "<td>" . $user_data['id'] . "</td>";
                        echo "<td>" . $user_data['nome'] . "</td>";
                        echo "<td>" . $user_data['email'] . "</td>";
                        echo "<td>" . $user_data['senha'] . "</td>";
                        echo "<td>" . $user_data['telefone'] . "</td>";
                        echo "<td>" . $user_data['sexo'] . "</td>";
                        echo "<td>" . $user_data['data_nasc'] . "</td>";
                        echo "<td>" . $user_data['cidade'] . "</td>";
                        echo "<td>" . $user_data['estado'] . "</td>";
                        echo "<td>" . $user_data['endereco'] . "</td>";
                        echo "<td>
                            <a class='btn btn-sm btn-primary' href='edit.php?id=$user_data[id]'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                    <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                </svg>
                            </a>

                            <a class='btn btn-sm btn-danger' style='margin: 3px;' href='delete.php?id=$user_data[id]'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                            </svg>
                            </a>

                        </td>";
                        echo "</tr>";
                    }

                ?>

            </tbody>

                    <main>

                        
                    </main>

            </table>
    </div>

</body>
</html>