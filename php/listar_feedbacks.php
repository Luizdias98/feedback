<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "feedback_system"; // Nome do banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Buscar feedbacks com o campo user_name
$sql = "SELECT id, user_name, user_profile, ease_of_use, needs_fulfillment, problem_frequency, problem_description, suggestions, created_at, satisfaction, module_used, contact_email FROM feedbacks ORDER BY created_at DESC";
$result = $conn->query($sql);

$feedbacks = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Garantir que ease_of_use seja um número inteiro
        $row['ease_of_use'] = (int) $row['ease_of_use'];  // Converte para inteiro, se necessário

        // Se user_name ou user_profile for null, substituir por uma string padrão
        $row['user_name'] = $row['user_name'] ?? 'Desconhecido';
        $row['user_profile'] = $row['user_profile'] ?? 'Desconhecido';

        $feedbacks[] = $row;
    }
}

echo json_encode($feedbacks);

$conn->close();
?>
