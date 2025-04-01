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
$user_name = $_POST['userName'] ?? null; // Novo campo (opcional)
$ease_of_use = $_POST['easeOfUse'];
$satisfaction = $_POST['satisfaction'];
$module_used = $_POST['moduleUsed'] ?? null;
$problem_description = $_POST['problemDescription'] ?? null;
$suggestions = $_POST['suggestions'] ?? null;
$contact_email = $_POST['contactEmail'] ?? null;

// Preparar a declaração SQL com o novo campo
$stmt = $conn->prepare("INSERT INTO feedbacks 
    (user_profile, user_name, ease_of_use, satisfaction, module_used, problem_description, suggestions, contact_email) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

// Verificar se a preparação foi bem-sucedida
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Vincular parâmetros (note o novo "s" para user_name)
$stmt->bind_param("ssiissss", 
    $user_profile, 
    $user_name, 
    $ease_of_use, 
    $satisfaction, 
    $module_used, 
    $problem_description, 
    $suggestions, 
    $contact_email
);

// Executar a declaração
if ($stmt->execute()) {
    // Sucesso - você pode redirecionar ou enviar uma resposta JSON
    echo "Feedback enviado com sucesso!";
} else {
    // Erro
    echo "Erro ao enviar feedback: " . $stmt->error;
}

// Fechar conexões
$stmt->close();
$conn->close();
?>