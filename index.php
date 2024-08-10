<?php

// Obtener el nombre de la carpeta desde la URL
$requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$carpetaNombre = $requestUri ? basename($requestUri) : '';


$carpetaRuta = "./descarga/" . $carpetaNombre;

try {
    // Crear la carpeta si no existe
    if (!file_exists($carpetaRuta)) {
        if (!mkdir($carpetaRuta, 0755, true)) {
            throw new Exception("No se pudo crear la carpeta.");
        }
        $mensaje = "Carpeta '$carpetaNombre' creada con éxito.";
    } else {
        $mensaje = "La carpeta '$carpetaNombre' ya existe.";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Manejo de archivos subidos
        if (isset($_FILES['archivos'])) {
            foreach ($_FILES['archivos']['name'] as $i => $nombreArchivo) {
                $nombreArchivo = str_replace(' ', '_', $nombreArchivo);
                $error = $_FILES['archivos']['error'][$i];
                if ($error === UPLOAD_ERR_OK) {
                    $destinoArchivo = $carpetaRuta . '/' . basename($nombreArchivo);
                    if (!move_uploaded_file($_FILES['archivos']['tmp_name'][$i], $destinoArchivo)) {
                        throw new Exception("Error al mover el archivo '$nombreArchivo'.");
                    }
                } else {
                    throw new Exception("Error en la carga del archivo: " . $error);
                }
            }
            $mensaje = "Archivos subidos con éxito.";
        }

        // Eliminación de archivo
        if (isset($_POST['eliminarArchivo'])) {
            $archivoAEliminar = basename($_POST['eliminarArchivo']);
            $archivoRutaAEliminar = $carpetaRuta . '/' . $archivoAEliminar;
            if (file_exists($archivoRutaAEliminar)) {
                if (!unlink($archivoRutaAEliminar)) {
                    throw new Exception("Error al eliminar el archivo.");
                }
                $mensaje = "Archivo '$archivoAEliminar' eliminado con éxito.";
            } else {
                throw new Exception("El archivo '$archivoAEliminar' no existe.");
            }
        }
    }
} catch (Exception $e) {
    $mensaje = "Error: " . htmlspecialchars($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compartir archivos</title>
    <script src="parametro.js" defer></script>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Compartir archivos <sup class="beta">BETA</sup></h1>
    <div class="content">
        <h3>Sube tus archivos y comparte este enlace temporal: <span>andrelv.store/<?php echo htmlspecialchars($carpetaNombre); ?></span></h3>
        <div class="container">
            <div class="drop-area" id="drop-area">
                <form action="" id="form" method="POST" enctype="multipart/form-data">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" style="fill:#0730c5;">
                        <path d="M13 19v-4h3l-4-5-4 5h3v4z"></path>
                        <path d="M7 19h2v-2H7c-1.654 0-3-1.346-3-3 0-1.404 1.199-2.756 2.673-3.015l.581-.102.192-.558C8.149 8.274 9.895 7 12 7c2.757 0 5 2.243 5 5v1h1c1.103 0 2 .897 2 2s-.897 2-2 2h-3v2h3c2.206 0 4-1.794 4-4a4.01 4.01 0 0 0-3.056-3.888C18.507 7.67 15.56 5 12 5 9.244 5 6.85 6.611 5.757 9.15 3.609 9.792 2 11.82 2 14c0 2.757 2.243 5 5 5z"></path>
                    </svg> <br>
                    <input title="Clic acá para elegir archivos" type="file" class="file-input" name="archivos[]" id="archivo" multiple><br>
                    Arrastra tus archivos aquí<br><br>
                    <button class="botonSubir" title="Clic acá para subir los archivos" type="submit">Subir archivo</button><br>
                </form>
            </div>

            <div class="container2">
                <div id="file-list" class="pila">
                    <?php
                    $files = scandir($carpetaRuta);
                    $files = array_diff($files, array('.', '..'));

                    if (count($files) > 0) {
                        echo "<h3 style='margin-bottom:10px;'>Archivos Subidos:</h3>";

                        foreach ($files as $file) {
                            echo "<div class='archivos_subidos'>
                            <div><a href='$carpetaRuta/$file' download class='boton-descargar'>$file</a></div>
                            <div>
                                <form action='' method='POST' style='display:inline;'>
                                    <input type='hidden' name='eliminarArchivo' value='$file'>
                                    <button class='boton-eliminar' type='submit'>Eliminar</button>
                                </form>
                            </div>
                            </div>";
                        }
                    } else {
                        echo "<p>No hay archivos subidos aún.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
