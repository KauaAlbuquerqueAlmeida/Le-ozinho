<?php
session_start();
include('db.php'); // Conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = mysqli_real_escape_string($conn, $_POST['senha']);

    // Busca o e-mail no banco de dados
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verifica a senha usando password_verify
        if (password_verify($senha, $row['senha'])) {
            // Login bem-sucedido
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['usuario_nome'] = $row['nome'];
            $_SESSION['usuario_email'] = $row['email'];

            // Redireciona para home.php
            header("Location: home.php");
            exit;
        } else {
            // Senha incorreta
            $_SESSION['erro'] = "Senha incorreta!";
            header("Location: login.php");
            exit;
        }
    } else {
        // E-mail não encontrado
        $_SESSION['erro'] = "E-mail não encontrado!";
        header("Location: login.php");
        exit;
    }
}

mysqli_close($conn); // Fecha a conexão
?>



<form method="POST" action="login.php">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Senha:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Entrar</button>
</form>
