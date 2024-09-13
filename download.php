<?php
if (isset($_GET['file']) && isset($_GET['expires'])) {
    $file = urldecode($_GET['file']);
    $expires = urldecode($_GET['expires']);
    
    // Verifica se o arquivo existe e não está expirado
    if (file_exists($file) && time() < $expires) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        
        // Remove o arquivo após o download
        unlink($file);
        exit;
    } else {
        echo "Arquivo não encontrado ou expirado.";
    }
}
?>
