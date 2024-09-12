<?php
// Verifica se o parâmetro 'file' está presente
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // Verifica se o arquivo existe
    if (file_exists($file)) {
        // Define os headers para forçar o download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    } else {
        echo "Arquivo não encontrado.";
    }
} else {
    echo "Nenhum arquivo especificado.";
}
?>
