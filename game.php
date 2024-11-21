<?php
session_start();
include('db.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$email = $_SESSION['user'];
$query = "SELECT * FROM usuarios WHERE email = '$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bet = $_POST['bet'];

    if ($bet <= $user['saldo'] && $bet > 0) {
        $result = rand(0, 1);  // 0 -> Perde, 1 -> Ganha
        $new_balance = ($result == 1) ? $user['saldo'] + $bet : $user['saldo'] - $bet;
        
        // Atualiza saldo no banco de dados
        $update_query = "UPDATE usuarios SET saldo = $new_balance WHERE email = '$email'";
        mysqli_query($conn, $update_query);
        header("Location: game.php");  // Redireciona após a aposta
    } else {
        echo "Valor de aposta inválido!";
    }
}
?>

<h1>Bem-vindo ao Cassino, <?php echo $user['email']; ?></h1>
<h2>Saldo: R$ <?php echo number_format($user['saldo'], 2, ',', '.'); ?></h2>

<form method="POST" action="game.php">
    <label for="bet">Escolha seu valor para apostar:</label>
    <input type="number" id="bet" name="bet" max="<?php echo $user['saldo']; ?>" min="1" required>
    <button type="submit">Apostar</button>
</form>

<div>
    <h3>Resultado:</h3>
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <?php if ($result == 1): ?>
            <p>Você ganhou!</p>
        <?php else: ?>
            <p>Você perdeu!</p>
        <?php endif; ?>
    <?php endif; ?>
</div>
