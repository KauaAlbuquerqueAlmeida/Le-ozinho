<?php
if (mysqli_query($conn, $sql)) {
    // Obter o ID do usuário recém-criado
    $usuario_id = mysqli_insert_id($conn);

    // Configurar as variáveis de sessão
    $_SESSION['usuario_id'] = $usuario_id;
    $_SESSION['usuario_nome'] = $nome;
    $_SESSION['usuario_email'] = $email;

    // Redirecionar para home.php
    header("Location: home.php");
    exit;
}
?>
