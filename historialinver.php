<?php
// profe es en esta parte donde el codigo no me muestra la fecha ni la hora en la base de datos si la muestra bien.
// Conexión a la base de datos
$servidor = "localhost";
$usuario = "root";
$clave = "";
$bd = "ambicontrol";
$conexion = mysqli_connect($servidor, $usuario, $clave, $bd);

if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Inicializar variables
$mensaje = '';
$elementos = [];

// Verificar si se ha enviado el formulario de búsqueda
if ($_SERVER['REQUEST_METHOD'] == 'GET' && (isset($_GET['fecha']) || isset($_GET['numero_documento']))) {
    $fecha = $_GET['fecha'] ?? '';
    $numero_documento = $_GET['numero_documento'] ?? '';
    
    // Crear la consulta con los filtros
    $query = "SELECT * FROM inventario WHERE 1=1";
    $params = [];
    $types = '';
    
    if (!empty($fecha)) {
        $query .= " AND DATE(fecha_hora) = ?";
        $params[] = $fecha;
        $types .= 's';
    }
    if (!empty($numero_documento)) {
        $query .= " AND Numero_Documento = ?";
        $params[] = $numero_documento;
        $types .= 's';
    }
    
    $query .= " ORDER BY fecha_hora ASC"; // Ordenar por fecha y hora
    
    $stmt = mysqli_prepare($conexion, $query);
    
    if ($stmt) {
        if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }
        
        mysqli_stmt_execute($stmt);
        $resultadoInventario = mysqli_stmt_get_result($stmt);
        
        // Verificar si la consulta devolvió resultados
        if ($resultadoInventario) {
            $elementos = mysqli_fetch_all($resultadoInventario, MYSQLI_ASSOC);
        } else {
            $mensaje = "Error al recuperar los datos del inventario: " . mysqli_error($conexion);
        }
    } else {
        $mensaje = "Error en la preparación de la consulta: " . mysqli_error($conexion);
    }
} else {
    // Consulta por defecto si no se ha realizado ninguna búsqueda
    $query = "SELECT * FROM inventario ORDER BY fecha_hora ASC"; // Ordenar por fecha y hora
    $resultadoInventario = mysqli_query($conexion, $query);
    
    if ($resultadoInventario) {
        $elementos = mysqli_fetch_all($resultadoInventario, MYSQLI_ASSOC);
    } else {
        $mensaje = "Error al ejecutar la consulta por defecto: " . mysqli_error($conexion);
    }
}

// Cerrar la conexión
mysqli_close($conexion);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Ambiente</title>
    <link rel="stylesheet" href="../CSS/historialinver.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>
<body>
    <div class="container">
        <img src="../img/logosena.png" alt="Logo SENA" class="logo">
        <h1 class="title">Historial De Ambiente</h1>

        <!-- Formulario de búsqueda -->
        <form method="GET" action="">
            <label for="fecha">Buscar por Fecha:</label>
            <input type="date" id="fecha" name="fecha">
            
            <label for="numero_documento">Buscar por Número de Documento:</label>
            <input type="text" id="numero_documento" name="numero_documento" placeholder="Numero_Documento">
            
            <button type="submit">Buscar</button>
        </form>

        <!-- Mostrar mensajes aquí -->
        <div class="message">
            <?php if (isset($mensaje)) echo htmlspecialchars($mensaje); ?>
        </div>

        <!-- Tabla de resultados agrupada por fecha -->
        <table class="form-table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Numero_Documento</th>
                    <th>Elemento</th>
                    <th>Disponibilidad</th>
                    <th>Cantidad</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            if (isset($elementos)) {
                foreach ($elementos as $elemento): 
                    $fecha = isset($elemento['fecha_hora']) ? date('d-m-Y', strtotime($elemento['fecha_hora'])) : 'Sin Fecha';
                    $hora = isset($elemento['fecha_hora']) ? date('H:i:s', strtotime($elemento['fecha_hora'])) : 'Sin Hora';
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($fecha); ?></td>
                    <td><?php echo htmlspecialchars($hora); ?></td>
                    <td><?php echo htmlspecialchars($elemento['Numero_Documento']); ?></td>
                    <td><?php echo htmlspecialchars($elemento['Elemento']); ?></td>
                    <td><?php echo htmlspecialchars($elemento['Disponibilidad']); ?></td>
                    <td><?php echo htmlspecialchars($elemento['Cantidad']); ?></td>
                    <td><?php echo htmlspecialchars($elemento['descripcion']); ?></td>
                </tr>
            <?php endforeach; } ?>
            </tbody>
        </table>

        <div class="button-container">
            <button id="printButton" type="button" onclick="window.print();">Imprimir</button>
            <button id="downloadButton" type="button" onclick="downloadData();">Descargar</button>
        </div>
    </div>

    <script>
    // Función para descargar el PDF
    function downloadData() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.setFontSize(18);
        doc.text("Historial De Ambiente", 20, 20);

        doc.setFontSize(12);
        let y = 40; // Posición inicial en el eje Y

        const formElements = document.querySelectorAll(".form-table tbody tr");
        formElements.forEach((row) => {
            const tds = row.querySelectorAll("td");
            const fecha = tds[0].textContent;
            const hora = tds[1].textContent;
            const numeroDocumento = tds[2].textContent;
            const elemento = tds[3].textContent;
            const disponibilidad = tds[4].textContent;
            const cantidad = tds[5].textContent;
            const descripcion = tds[6].textContent;

            doc.text(`Fecha: ${fecha}`, 20, y);
            doc.text(`Hora: ${hora}`, 20, y + 10);
            doc.text(`Numero_Documento: ${numeroDocumento}`, 20, y + 20);
            doc.text(`Elemento: ${elemento}`, 20, y + 30);
            doc.text(`Disponibilidad: ${disponibilidad}`, 20, y + 40);
            doc.text(`Cantidad: ${cantidad}`, 20, y + 50);
            doc.text(`Descripción: ${descripcion}`, 20, y + 60);

            y += 70; // Incrementar la posición en Y para la próxima entrada

            // Verificar si se necesita agregar una nueva página
            if (y > 250) {
                doc.addPage();
                y = 20; // Reiniciar la posición Y
            }
        });

        doc.save("Historial_De_Ambiente.pdf");
    }
    </script>
</body>
</html>
