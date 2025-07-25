<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🗳️ Resultados de la Votación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
            background-image: url('img/Azul.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        #resultado {
            font-size: 1.5em;
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        #contenedorTabla{
            padding: 20px;
        }
        .ganador {
            font-weight: bold;
            background-color: #e0f7fa; /* Resalta al ganador */
        }
    </style>
</head>
<body>
    <h1>🗳️ Votación Contraloria 2025</h1>
    <div id="resultado">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "usbw";
        $dbname = "votosContraloria"; // Nombre correcto de la base de datos

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        $sql = "SELECT c.nombre, COUNT(v.candidato_id) AS votos FROM candidatos c LEFT JOIN votos v ON c.id = v.candidato_id GROUP BY c.id";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                $total_votos = 0;
                $resultados = array();

                while ($row = $result->fetch_assoc()) {
                    $total_votos += $row['votos'];
                    $resultados[] = $row;
                }

                echo "<h2>Total de Votos: " . $total_votos . "</h2>";
                echo "<div id='contenedorTabla'>";
                echo "<table><thead><tr><th>Candidato</th><th>Votos Recibidos</th></tr></thead><tbody>";

                $ganador = null;
                $max_votos = -1;

                foreach ($resultados as $row) {
                    echo "<tr" . ($row['votos'] > $max_votos ? " class='ganador'" : "") . ">";
                    echo "<td>" . $row['nombre'] . "</td><td>" . $row['votos'] . "</td></tr>";
                    if ($row['votos'] > $max_votos) {
                        $max_votos = $row['votos'];
                        $ganador = $row;
                    }
                }

                echo "</tbody></table></div>";

                if ($ganador) {
                    echo "<div id='ganador'><h2>Ganador: " . $ganador['nombre'] . "</h2>";
                    $segundo_lugar_votos = 0;
                    foreach ($resultados as $row) {
                        if ($row['nombre'] != $ganador['nombre'] && $row['votos'] > $segundo_lugar_votos) {
                            $segundo_lugar_votos = $row['votos'];
                        }
                    }
                    $diferencia_votos = $ganador['votos'] - $segundo_lugar_votos;
                    echo "<p>Ganó por " . $diferencia_votos . " votos.</p></div>";
                }
            } else {
                echo "No hay votos registrados.";
            }
        } else {
            echo "Error en la consulta: " . $conn->error;
        }

        $conn->close();
        ?>
    </div>
</body>
</html>