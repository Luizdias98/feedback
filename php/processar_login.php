<?php
session_start();

$servername = "localhost";
$username = "root"; // 
$password = ""; 
$dbname = "feedback_system"; // Nome do banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Coletar dados do formulário
$username = $_POST['username'];
$password = $_POST['password'];

// Buscar o hash da senha no banco de dados
$stmt = $conn->prepare("SELECT id, username, password_hash FROM admin WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $storedHash = $row['password_hash'];

    // Gerar o hash SHA-256 da senha fornecida
    $inputHash = hash('sha256', $password);

    // Verificar se os hashes coincidem
    if ($inputHash === $storedHash) {
        // Login bem-sucedido
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $row['username'];
        $_SESSION['id'] = $row['id'];
        header("Location: admin_panel.html");
        exit;
    } else {
        // Senha incorreta
        echo "Credenciais inválidas!";
    }
} else {
    // Usuário não encontrado
    echo "Credenciais inválidas!";
}

$stmt->close();
$conn->close();
?>