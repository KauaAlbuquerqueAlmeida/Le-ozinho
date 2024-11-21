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
    $new_balance = $_POST['saldo'];
    if ($new_balance > 0 && $new_balance <= 1000) {
        $update_query = "UPDATE usuarios SET saldo = $new_balance WHERE email = '$email'";
        mysqli_query($conn, $update_query);
    }
}
?>

<h1>Bem-vindo, <?php echo $user['email']; ?></h1>
<h2>Saldo: R$ <?php echo number_format($user['saldo'], 2, ',', '.'); ?></h2>

<form method="POST" action="home.php">
    <label for="saldo">Alterar Saldo:</label>
    <input type="number" id="saldo" name="saldo" value="<?php echo $user['saldo']; ?>" max="1000" min="0" required>
    <button type="submit">Alterar Saldo</button>
</form>

<a href="game.php">Ir para o Jogo</a>
