<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de login</title>
    <link rel="stylesheet" href="css/style-login.css">
</head>
<body>
    
        <a class="a-exit" href="home.php">Voltar</a>

    <div>
        
        <h1>Login</h1>
        <form action="testelogin.php" method="post">
        <input type="text" name="email" placeholder="Email" required>
        <br><br>
        <input type="password" name="senha" placeholder="Senha" required>
        <br><br>
        <input class="input-submit" type="submit" name="submit" value="Enviar">
        </form>
    </div>
</body>
</html>