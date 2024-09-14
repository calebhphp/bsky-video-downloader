<?php 
if (isset($_GET['file']) && isset($_GET['expires'])) {
    $file = urldecode($_GET['file']);
    $expires = urldecode($_GET['expires']);
    
    // Verifica se o arquivo existe e se ainda está dentro do tempo de expiração
    if (file_exists($file) && time() < $expires) {
        // Cabeçalhos para forçar o download do arquivo
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));

        // Envia o arquivo para o navegador do usuário
        readfile($file);
        
        // Remove o arquivo do servidor após o download
        unlink($file);
        exit; // Sai imediatamente após excluir o arquivo
    } else {
        echo "Arquivo não encontrado ou expirado.";
    }
}
?>
