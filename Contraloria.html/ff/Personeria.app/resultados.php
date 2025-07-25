<?php
$servername = "localhost";
$username = "root";
$password = "usbw";
$dbname = "votacion";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para contar votos por candidato
$sql = "SELECT c.nombre, COUNT(v.candidato_id) AS votos 
        FROM candidatos c 
        LEFT JOIN votos v ON c.id = v.candidato_id 
        GROUP BY c.id";

$result = $conn->query($sql);

// Consulta para contar los votos en blanco
$sql_votos_blanco = "SELECT COUNT(*) AS votos FROM votos WHERE candidato_id = 0";
$result_votos_blanco = $conn->query($sql_votos_blanco);
$votos_blanco = ($result_votos_blanco && $result_votos_blanco->num_rows > 0) ? $result_votos_blanco->fetch_assoc()['votos'] : 0;

if ($result) {
    if ($result->num_rows > 0 || $votos_blanco > 0) { // Asegura que haya datos que mostrar
        $total_votos = $votos_blanco;
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

        // Mostrar resultados de los candidatos
        foreach ($resultados as $row) {
            echo "<tr" . ($row['votos'] > $max_votos ? " class='ganador'" : "") . ">";
            echo "<td>" . $row['nombre'] . "</td><td>" . $row['votos'] . "</td></tr>";

            if ($row['votos'] > $max_votos) {
                $max_votos = $row['votos'];
                $ganador = $row;
            }
        }

        // Agregar fila del voto en blanco
        echo "<tr><td><strong>Voto en Blanco</strong></td><td><strong>" . $votos_blanco . "</strong></td></tr>";

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
