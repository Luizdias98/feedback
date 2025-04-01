<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root"; // Substitua pelo seu usuário do MySQL
$password = ""; // Substitua pela sua senha do MySQL
$dbname = "feedback_system"; // Nome do banco de dados

// Dados do administrador
$adminUsername = "admin";
$adminPassword = "ccom2025!..";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Gerar o hash da senha usando SHA-256
$hashedPassword = hash('sha256', $adminPassword);

// Inserir o administrador no banco de dados
$stmt = $conn->prepare("INSERT INTO admin (username, password_hash) VALUES (?, ?)");
$stmt->bind_param("ss", $adminUsername, $hashedPassword);

if ($stmt->execute()) {
    echo "Administrador criado com sucesso!<br>";
    echo "Usuário: " . $adminUsername . "<br>";
    echo "Senha: " . $adminPassword . "<br>";
    echo "Hash da senha: " . $hashedPassword . "<br>";
} else {
    echo "Erro ao criar administrador: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>