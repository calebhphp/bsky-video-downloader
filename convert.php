<?php
header('Content-Type: application/json');

// Função para deletar arquivos antigos na pasta de vídeos
function deleteOldFiles($directory, $expirationTime = 3600) {
    // Obtém todos os arquivos no diretório especificado
    $files = glob($directory . '/*');
    
    // Percorre os arquivos e verifica se já passaram do tempo de expiração
    foreach ($files as $file) {
        if (is_file($file)) {
            // Verifica se o arquivo foi modificado há mais de $expirationTime segundos
            if (time() - filemtime($file) > $expirationTime) {
                // Exclui o arquivo se passou do tempo de expiração
                unlink($file);
            }
        }
    }
}

// Diretório onde os arquivos temporários estão armazenados
$directory = 'videos';

// Expiração de 1 hora (3600 segundos)
deleteOldFiles($directory, 10);

// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['video_url'])) {
    // Recebe a URL do formulário
    $input_url = $_POST['video_url'];

    // Gera um nome único para o arquivo de saída
    $unique_id = uniqid(); // Gera um ID único
    $output_file = 'videos/output_' . $unique_id . '.mp4';

    // Valida a URL para garantir que ela não seja vazia e está formatada corretamente
    if (filter_var($input_url, FILTER_VALIDATE_URL) === FALSE) {
        echo json_encode(['status' => 'error', 'message' => 'URL inválida.']);
        exit;
    }

    // Comando FFmpeg para converter o vídeo
    $command = "ffmpeg -i " . escapeshellarg($input_url) . " -c:v libx264 -c:a aac -strict -2 " . escapeshellarg($output_file) . " 2>&1";
    
    // Executa o comando e captura a saída
    $output = shell_exec($command);

    // Verifica se houve erro
    if (!file_exists($output_file)) {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao converter o vídeo.']);
    } else {
        // Define uma data de expiração para o link (por exemplo, 1 hora)
        $expires = time() + 3600; // 1 hora em segundos

        // Resposta JSON com o link para o vídeo convertido
        echo json_encode(['status' => 'success', 'file' => $output_file, 'expires' => $expires]);

        // Função para deletar o arquivo após o download ser feito ou o tempo expirar
        // Pode ser implementada via um script JavaScript ou cron job no servidor para monitorar e apagar arquivos expirados
    }
}
?>
