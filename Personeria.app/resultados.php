<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de la Votación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
            background-image: url('img/Azul.png'); /* Agrega la imagen de fondo */
            background-size: cover; /* Ajusta la imagen al tamaño de la ventana */
            background-repeat: no-repeat; /* Evita que la imagen se repita */
            background-attachment: fixed; /* Mantiene la imagen fija al hacer scroll */
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
    </style>
</head>
<body>
    <h1>Resultados de la Votación</h1>
    <div id="resultado">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "usbw";
        $dbname = "votacion";

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar conexión
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Consulta para obtener el total de votos por cada candidato
        $sql = "SELECT c.nombre, COUNT(v.candidato_id) AS votos
                FROM candidatos c
                LEFT JOIN votos v ON c.id = v.candidato_id
                GROUP BY c.id";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Mostrar el total de votos
            $total_votos = 0;
            echo "<h2>Total de Votos: ";
            
            // Sumar todos los votos
            while ($row = $result->fetch_assoc()) {
                $total_votos += $row['votos'];
            }

            echo $total_votos . "</h2>";

            // Volver a realizar la consulta para mostrar cada candidato con sus votos
            $result->data_seek(0);
            echo "<table>
                    <thead>
                        <tr>
                            <th>Candidato</th>
                            <th>Votos Recibidos</th>
                        </tr>
                    </thead>
                    <tbody>";
            
            // Mostrar cada candidato y los votos que recibió
            $ganador = null;
            $max_votos = -1;
            $resultados = array();

            while ($row = $result->fetch_assoc()) {
                $resultados[] = $row;
                if ($row['votos'] > $max_votos) {
                    $max_votos = $row['votos'];
                    $ganador = $row;
                }
            }

            foreach ($resultados as $row) {
                echo "<tr>
                        <td>" . $row['nombre'] . "</td>
                        <td>" . $row['votos'] . "</td>
                    </tr>";
            }

            echo "</tbody></table>";

            // Mostrar el ganador y por cuántos votos ganó
            if ($ganador) {
                echo "<div id='ganador'>";
                echo "<h2>Ganador: " . $ganador['nombre'] . "</h2>";
                
                // Encontrar el segundo lugar (o empate)
                $segundo_lugar_votos = 0;
                foreach ($resultados as $row) {
                    if ($row['nombre'] != $ganador['nombre'] && $row['votos'] > $segundo_lugar_votos) {
                        $segundo_lugar_votos = $row['votos'];
                    }
                }
                
                $diferencia_votos = $ganador['votos'] - $segundo_lugar_votos;
                echo "<p>Ganó por " . $diferencia_votos . " votos.</p>";
                echo "</div>";
            }
        } else {
            echo "No hay votos registrados.";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>