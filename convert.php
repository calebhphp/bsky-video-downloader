<?php
// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['video_url'])) {
    // Recebe a URL do formulário
    $input_url = $_POST['video_url'];
    $output_file = 'videos/output_' . uniqid() . '.mp4'; // Gera um nome único para o arquivo

    // Valida a URL para garantir que ela não seja vazia e está formatada corretamente
    if (filter_var($input_url, FILTER_VALIDATE_URL) === FALSE) {
        header("Location: result.php?status=error");
        exit;
    }

    // Comando FFmpeg
    $command = "ffmpeg -i " . escapeshellarg($input_url) . " -c:v libx264 -preset fast -crf 23 -c:a aac -strict -2 " . escapeshellarg($output_file) . " 2>&1";
    
    // Executa o comando e captura a saída
    $output = shell_exec($command);

    // Verifica se a conversão foi bem-sucedida
    if ($output === null || !file_exists($output_file)) {
        header("Location: result.php?status=error");
    } else {
        // Redireciona para a página de resultado com o nome do arquivo convertido
        header("Location: result.php?status=success&file=" . urlencode($output_file));
    }
}
?>
