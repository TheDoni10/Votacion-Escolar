<?php
$servername = "localhost";
$username = "root";
$password = "usbw";
$dbname = "votacion";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $candidato_id = $_POST['candidato'];

    $sql = "INSERT INTO votos (candidato_id) VALUES (?)"; // Nombre correcto de la tabla
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $candidato_id);
        if ($stmt->execute()) {
            echo "Voto registrado correctamente.";
        } else {
            echo "Error al registrar el voto: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }
}

$conn->close();
?>