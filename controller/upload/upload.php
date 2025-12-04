<?php
// Carpeta destino donde se guardará la imagen
$targetDir = "../uploads/";

// Si no existe la carpeta, la creamos
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

if (isset($_FILES['file'])) {
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    // Mover archivo subido a la carpeta destino
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
        echo "Archivo subido exitosamente: " . $targetFilePath;
    } else {
        echo "Error al subir el archivo.";
    }
} else {
    echo "No se recibió ningún archivo.";
}
?>
