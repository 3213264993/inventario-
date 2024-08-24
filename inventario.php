<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "ambicontrol");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Inicializar el mensaje
$mensaje = "";

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener la fecha y hora actual
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');

    // Capturar el número de documento
    $Numero_Documento = $conexion->real_escape_string($_POST['documento'] ?? '');

    // Validar que el campo Número de Documento no esté vacío
    if (!empty($Numero_Documento)) {
        $datosGuardados = false; // Variable para verificar si al menos un dato ha sido guardado

        // Guardar cada elemento en la base de datos
        $elementos = [
            'monitores' => 'Monitores',
            'torres' => 'Torres',
            'teclados' => 'Teclados',
            'mouses' => 'Mouses',
            'sillas' => 'Sillas',
            'mesas' => 'Mesas',
            'tablero' => 'Tablero',
            'aireAcondicionado' => 'Aire Acondicionado',
            'televisor' => 'Televisor',
            'proyector' => 'Proyector',
            'modeloDeInternet' => 'Modelo De Internet',
            'cortinas' => 'Cortinas',
            'conectoresElectricos' => 'Conectores Eléctricos',
            'extension' => 'Extensión',
            'marcadores' => 'Marcadores',
            'borradorDeTablero' => 'Borrador De Tablero',
            'muebles' => 'Muebles'
        ];

        // Preparar la consulta
        $stmt = $conexion->prepare("INSERT INTO inventario (Numero_Documento, elemento, disponibilidad, cantidad, descripcion, fecha, hora) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");

        $registroHecho = false; // Variable para verificar si se ha hecho al menos un registro

        foreach ($elementos as $key => $elemento) {
            $disponibilidad = $conexion->real_escape_string($_POST[$key . 'Disponibilidad'] ?? '');
            $cantidad = $conexion->real_escape_string($_POST[$key . 'Cantidad'] ?? 0);
            $descripcion = $conexion->real_escape_string($_POST[$key . 'Descripcion'] ?? '');

            // Validar que la cantidad sea un número entero y mayor o igual a 0
            $cantidad = is_numeric($cantidad) ? intval($cantidad) : 0;

            if (!empty($disponibilidad) || $cantidad > 0 || !empty($descripcion)) {
                // Bind de parámetros y ejecución
                $stmt->bind_param("sssssss", $Numero_Documento, $elemento, $disponibilidad, $cantidad, $descripcion, $fecha, $hora);
                
                if ($stmt->execute()) {
                    $registroHecho = true; // Marcar que al menos un registro se hizo
                }
            }
        }
        $stmt->close();

        if ($registroHecho) {
            $mensaje = "Datos guardados exitosamente.";
        } else {
            $mensaje = "No se guardaron datos. Asegúrese de que al menos un campo tenga información.";
        }
    } else {
        $mensaje = "Por favor, ingrese un Número de Documento válido.";
    }
}

// Cerrar la conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Ambiente</title>
    <link rel="stylesheet" href="../CSS/inver.css">
    <style>
        body {
            background-image: url("../img/SENA4.jpg");
        }
        
        .form-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .button {
            padding: 10px 50px;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .start-btn {
            background-color: green;
        }

        .save-btn {
            background-color: black;
            color: #fff;
        }

        .historial-btn {
            background-color: green;
        }

        .form-table th, .form-table td {
            border: -41px solid black; 
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="../img/logosena.png" alt="Logo SENA" class="logo">
        <h1 class="title">Inventario De Ambiente</h1>

        <?php if (isset($mensaje) && !empty($mensaje)): ?>
            <div class="alert">
                <?= htmlspecialchars($mensaje) ?>
            </div>
        <?php endif; ?>

        <form id="inventoryForm" method="POST" action="">
            <div class="form-group">
                <label for="documento">Numero_Documento:</label>
                <input type="text" id="documento" name="documento">
            </div>
            <table class="form-table">
                <thead>
                    <tr>
                        <th>Elemento</th>
                        <th>Disponibilidad</th>
                        <th>Cantidad</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Monitores</td>
                        <td class="options">
                            <label><input type="radio" name="monitoresDisponibilidad" value="sí"> Sí</label>
                            <label><input type="radio" name="monitoresDisponibilidad" value="no"> No</label>
                        </td>
                        <td><input type="number" name="monitoresCantidad" min="0"></td>
                        <td><input type="text" name="monitoresDescripcion"></td>
                    </tr>
                    <tr>
                        <td>Torres</td>
                        <td class="options">
                            <label><input type="radio" name="torresDisponibilidad" value="sí"> Sí</label>
                            <label><input type="radio" name="torresDisponibilidad" value="no"> No</label>
                        </td>
                        <td><input type="number" name="torresCantidad" min="0"></td>
                        <td><input type="text" name="torresDescripcion"></td>
                    </tr>
                    <tr>
                        <td>Teclados</td>
                        <td class="options">
                            <label><input type="radio" name="tecladosDisponibilidad" value="sí"> Sí</label>
                            <label><input type="radio" name="tecladosDisponibilidad" value="no"> No</label>
                        </td>
                        <td><input type="number" name="tecladosCantidad" min="0"></td>
                        <td><input type="text" name="tecladosDescripcion"></td>
                    </tr>
                    <tr>
                        <td>Mouses</td>
                        <td class="options">
                            <label><input type="radio" name="mousesDisponibilidad" value="sí"> Sí</label>
                            <label><input type="radio" name="mousesDisponibilidad" value="no"> No</label>
                        </td>
                        <td><input type="number" name="mousesCantidad" min="0"></td>
                        <td><input type="text" name="mousesDescripcion"></td>
                    </tr>
                    <tr>
                        <td>Sillas</td>
                        <td class="options">
                            <label><input type="radio" name="sillasDisponibilidad" value="sí"> Sí</label>
                            <label><input type="radio" name="sillasDisponibilidad" value="no"> No</label>
                        </td>
                        <td><input type="number" name="sillasCantidad" min="0"></td>
                        <td><input type="text" name="sillasDescripcion"></td>
                    </tr>
                    <tr>
                        <td>Mesas</td>
                        <td class="options">
                            <label><input type="radio" name="mesasDisponibilidad" value="sí"> Sí</label>
                            <label><input type="radio" name="mesasDisponibilidad" value="no"> No</label>
                        </td>
                        <td><input type="number" name="mesasCantidad" min="0"></td>
                        <td><input type="text" name="mesasDescripcion"></td>
                    </tr>
                    <tr>
                        <td>Tablero</td>
                        <td class="options">
                            <label><input type="radio" name="tableroDisponibilidad" value="sí"> Sí</label>
                            <label><input type="radio" name="tableroDisponibilidad" value="no"> No</label>
                        </td>
                        <td><input type="number" name="tableroCantidad" min="0"></td>
                        <td><input type="text" name="tableroDescripcion"></td>
                    </tr>
                    <tr>
                        <td>Aire Acondicionado</td>
                        <td class="options">
                            <label><input type="radio" name="aireAcondicionadoDisponibilidad" value="sí"> Sí</label>
                            <label><input type="radio" name="aireAcondicionadoDisponibilidad" value="no"> No</label>
                        </td>
                        <td><input type="number" name="aireAcondicionadoCantidad" min="0"></td>
                        <td><input type="text" name="aireAcondicionadoDescripcion"></td>
                    </tr>
                    <tr>
                        <td>Televisor</td>
                        <td class="options">
                            <label><input type="radio" name="televisorDisponibilidad" value="sí"> Sí</label>
                            <label><input type="radio" name="televisorDisponibilidad" value="no"> No</label>
                        </td>
                        <td><input type="number" name="televisorCantidad" min="0"></td>
                        <td><input type="text" name="televisorDescripcion"></td>
                    </tr>
                    <tr>
                        <td>Proyector</td>
                        <td class="options">
                            <label><input type="radio" name="proyectorDisponibilidad" value="sí"> Sí</label>
                            <label><input type="radio" name="proyectorDisponibilidad" value="no"> No</label>
                        </td>
                        <td><input type="number" name="proyectorCantidad" min="0"></td>
                        <td><input type="text" name="proyectorDescripcion"></td>
                    </tr>
                    <tr>
                        <td>Modelo De Internet</td>
                        <td class="options">
                            <label><input type="radio" name="modeloDeInternetDisponibilidad" value="sí"> Sí</label>
                            <label><input type="radio" name="modeloDeInternetDisponibilidad" value="no"> No</label>
                        </td>
                        <td><input type="number" name="modeloDeInternetCantidad" min="0"></td>
                        <td><input type="text" name="modeloDeInternetDescripcion"></td>
                    </tr>
                    <tr>
                        <td>Cortinas</td>
                        <td class="options">
                            <label><input type="radio" name="cortinasDisponibilidad" value="sí"> Sí</label>
                            <label><input type="radio" name="cortinasDisponibilidad" value="no"> No</label>
                        </td>
                        <td><input type="number" name="cortinasCantidad" min="0"></td>
                        <td><input type="text" name="cortinasDescripcion"></td>
                    </tr>
                    <tr>
                        <td>Conectores Eléctricos</td>
                        <td class="options">
                            <label><input type="radio" name="conectoresElectricosDisponibilidad" value="sí"> Sí</label>
                            <label><input type="radio" name="conectoresElectricosDisponibilidad" value="no"> No</label>
                        </td>
                        <td><input type="number" name="conectoresElectricosCantidad" min="0"></td>
                        <td><input type="text" name="conectoresElectricosDescripcion"></td>
                    </tr>
                    <tr>
                        <td>Extensión</td>
                        <td class="options">
                            <label><input type="radio" name="extensionDisponibilidad" value="sí"> Sí</label>
                            <label><input type="radio" name="extensionDisponibilidad" value="no"> No</label>
                        </td>
                        <td><input type="number" name="extensionCantidad" min="0"></td>
                        <td><input type="text" name="extensionDescripcion"></td>
                    </tr>
                    <tr>
                        <td>Marcadores</td>
                        <td class="options">
                            <label><input type="radio" name="marcadoresDisponibilidad" value="sí"> Sí</label>
                            <label><input type="radio" name="marcadoresDisponibilidad" value="no"> No</label>
                        </td>
                        <td><input type="number" name="marcadoresCantidad" min="0"></td>
                        <td><input type="text" name="marcadoresDescripcion"></td>
                    </tr>
                    <tr>
                        <td>Borrador De Tablero</td>
                        <td class="options">
                            <label><input type="radio" name="borradorDeTableroDisponibilidad" value="sí"> Sí</label>
                            <label><input type="radio" name="borradorDeTableroDisponibilidad" value="no"> No</label>
                        </td>
                        <td><input type="number" name="borradorDeTableroCantidad" min="0"></td>
                        <td><input type="text" name="borradorDeTableroDescripcion"></td>
                    </tr>
                    <tr>
                        <td>Muebles</td>
                        <td class="options">
                            <label><input type="radio" name="mueblesDisponibilidad" value="sí"> Sí</label>
                            <label><input type="radio" name="mueblesDisponibilidad" value="no"> No</label>
                        </td>
                        <td><input type="number" name="mueblesCantidad" min="0"></td>
                        <td><input type="text" name="mueblesDescripcion"></td>
                </tbody>
            </table>
            <div class="form-buttons">
                <a href="login.php" class="button start-btn">Inicio</a>
                <button class="button save-btn" type="submit">Guardar</button>
                <a href="historialinver.php" class="button historial-btn">Historial</a>
            </div>
        </form>
    </div>
</body>
</html>

