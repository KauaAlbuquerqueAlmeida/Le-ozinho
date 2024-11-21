<?php
// Configurações do banco de dados
$host = 'localhost'; // ou o IP do servidor de banco de dados, geralmente 'localhost'
$user = 'root';      // substitua com o nome de usuário do seu banco de dados (por padrão, 'root' no XAMPP)
$password = '';       // substitua com a senha do banco de dados (se houver, no XAMPP a senha geralmente é vazia)
$dbname = 'leaozinho'; // substitua com o nome do seu banco de dados

// Estabelecendo a conexão com o banco de dados
$conn = mysqli_connect($host, $user, $password, $dbname);

// Verificando se a conexão foi bem-sucedida
if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}
?>
