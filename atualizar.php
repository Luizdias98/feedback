<?php
$password = "ccom2025!.."; // Senha em texto plano
$hash = password_hash($password, PASSWORD_DEFAULT); // Gera o hash da senha
echo $hash; // Use esse hash no banco de dados
?>