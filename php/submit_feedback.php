<?php
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
$user_profile = $_POST['userProfile'];
$ease_of_use = $_POST['easeOfUse'];
$needs_fulfillment = $_POST['needsFulfillment'];
$problem_frequency = $_POST['problemFrequency'];
$problem_description = $_POST['problemDescription'];
$suggestions = $_POST['suggestions'];

// Inserir dados no banco de dados
$stmt = $conn->prepare("INSERT INTO feedbacks (user_profile, ease_of_use, needs_fulfillment, problem_frequency, problem_description, suggestions) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("siisss", $user_profile, $ease_of_use, $needs_fulfillment, $problem_frequency, $problem_description, $suggestions);

if ($stmt->execute()) {
    echo "Feedback enviado com sucesso!";
} else {
    echo "Erro ao enviar feedback: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>