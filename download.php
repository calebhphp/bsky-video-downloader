<?php
// Verifica se o arquivo foi solicitado
if (isset($_GET['file'])) {
    $file = urldecode($_GET['file']);
    
    // Verifica se o arquivo existe
    if (file_exists($file)) {
        // Força o download do arquivo
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    } else {
        echo "Arquivo não encontrado.";
    }
}
?>
