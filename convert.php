<?php
// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['video_url'])) {
    // Recebe a URL do formulário
    $input_url = $_POST['video_url'];
    $output_file = 'output.mp4';

    // Valida a URL para garantir que ela não seja vazia e está formatada corretamente
    if (filter_var($input_url, FILTER_VALIDATE_URL) === FALSE) {
        header("Location: result.php?status=error");
        exit;
    }

    // Comando FFmpeg
    $command = "ffmpeg -i " . escapeshellarg($input_url) . " -c:v libx264 -c:a aac -strict -2 " . escapeshellarg($output_file) . " 2>&1";
    
    // Executa o comando e captura a saída
    $output = shell_exec($command);

    // Verifica se houve erro
    if ($output === null || !file_exists($output_file)) {
        header("Location: result.php?status=error");
    } else {
        header("Location: result.php?status=success");
    }
}
?>
