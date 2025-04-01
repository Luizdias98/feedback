<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_system";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Coletar dados do formulário
$username = $_POST['username'];
$password = $_POST['password'];

// Verificar credenciais
$stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Usar SHA-256 para hash da senha (parece ser o que está armazenado no banco)
    $hashed_password = hash('sha256', $password);
    
    if ($hashed_password === $user['password_hash']) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: admin_panel.php");
        exit();
    } else {
        echo "Senha incorreta!";
    }
} else {
    echo "Usuário não encontrado!";
}

$stmt->close();
$conn->close();
?>