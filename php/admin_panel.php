<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

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

// Buscar feedbacks
$sql = "SELECT * FROM feedbacks";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilos do painel administrativo */
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Painel Administrativo - Feedbacks</h1>
            <button id="logoutBtn">Sair</button>
        </div>
        
        <div class="admin-content">
            <h2>Lista de Feedbacks</h2>
            <div class="feedback-list">
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='feedback-item'>";
                        echo "<div class='feedback-header'>";
                        echo "<div class='feedback-profile'>" . $row['user_profile'] . "</div>";
                        echo "<div class='feedback-date'>" . $row['created_at'] . "</div>";
                        echo "</div>";
                        echo "<div class='feedback-stars'>";
                        for ($i = 0; $i < $row['ease_of_use']; $i++) {
                            echo "<i class='fas fa-star'></i>";
                        }
                        echo "</div>";
                        echo "<p><strong>Problemas:</strong> " . $row['problem_frequency'] . "</p>";
                        echo "<p><strong>Descrição:</strong> " . $row['problem_description'] . "</p>";
                        echo "<p><strong>Sugestões:</strong> " . $row['suggestions'] . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Nenhum feedback encontrado.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('logoutBtn').addEventListener('click', function() {
            window.location.href = 'logout.php';
        });
    </script>
</body>
</html>
<?php
$conn->close();
?>