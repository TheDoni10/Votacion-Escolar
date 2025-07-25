<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🗳️ Votación Escolar Contraloría</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('img/Azul.png') no-repeat center center fixed;
            background-size: cover;
            color: white;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7); /* Fondo oscuro translúcido */
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5);
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .message {
            font-size: 1.2em;
            margin-top: 15px;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px;
            border-radius: 10px;
        }

        /* Botón de Regresar */
        .btn-regresar {
            background: #d32f2f;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.2em;
            margin-top: 20px;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s ease;
        }

        .btn-regresar:hover {
            background: #b71c1c;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Votación Escolar Contraloría</h1>

    <?php
    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "usbw";
    $dbname = "votosContraloria";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("<div class='message'>❌ Error de conexión: " . $conn->connect_error . "</div>");
    }

    // Verificar si el formulario fue enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $candidato_id = filter_input(INPUT_POST, 'candidato', FILTER_VALIDATE_INT);

        if ($candidato_id !== null && $candidato_id !== false) {
            // Insertar el voto en la base de datos
            $sql = "INSERT INTO votos (candidato_id) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $candidato_id);

            if ($stmt->execute()) {
                echo "<div class='message'>✅ ¡Voto registrado correctamente!</div>";
            } else {
                echo "<div class='message'>⚠️ Error al registrar el voto. Inténtalo de nuevo.</div>";
            }
        } else {
            echo "<div class='message'>⚠️ Por favor, selecciona un candidato o el voto en blanco.</div>";
        }
    }

    $conn->close();
    ?>

    <!-- Botón para regresar -->
    <a href="index.html" class="btn-regresar">⬅ Regresar</a>

</div>

</body>
</html>
