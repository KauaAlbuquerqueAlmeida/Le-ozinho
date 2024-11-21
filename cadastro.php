<?php
session_start();
include('db.php'); // Inclui o arquivo de conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = mysqli_real_escape_string($conn, $_POST['senha']);

    // Criptografar a senha
    $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

    // Insere o novo usuário no banco de dados
    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha_criptografada')";

    if (mysqli_query($conn, $sql)) {
        // Obter o ID do usuário recém-criado
        $usuario_id = mysqli_insert_id($conn);

        // Configurar variáveis de sessão para login automático
        $_SESSION['usuario_id'] = $usuario_id;
        $_SESSION['usuario_nome'] = $nome;
        $_SESSION['usuario_email'] = $email;

        // Redirecionar para home.php
        header("Location: home.php");
        exit;
    } else {
        $_SESSION['erro'] = "Erro ao criar conta: " . mysqli_error($conn);
        header("Location: cadastro.php");
        exit;
    }
}

mysqli_close($conn); // Fecha a conexão com o banco de dados
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Leãozinho</title>
    <link rel="stylesheet" href="style.css"> <!-- seu arquivo CSS -->
</head>
<body>

    <header>
        <h1>Cadastro - Leãozinho</h1>
    </header>

    <div class="container">
        <form action="cadastro_process.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit">Cadastrar</button>
            <p>Já tem uma conta? <a href="login.php">Faça login aqui</a></p>
        </form>

    </div>

</body>
</html>
