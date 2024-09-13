<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['video_url'])) {
    $input_url = $_POST['video_url'];
    $output_file = 'videos/output_' . uniqid() . '.mp4';

    if (filter_var($input_url, FILTER_VALIDATE_URL) === FALSE) {
        header("Location: result.php?status=error");
        exit;
    }

    $command = "ffmpeg -i " . escapeshellarg($input_url) . " -c:v libx264 -preset fast -crf 23 -c:a aac -strict -2 " . escapeshellarg($output_file) . " 2>&1";
    $output = shell_exec($command);

    if ($output === null || !file_exists($output_file)) {
        header("Location: result.php?status=error");
    } else {
        // Redireciona para o script de download com um tempo de expiração
        header("Location: download.php?file=" . urlencode($output_file) . "&expires=" . urlencode(date('U', strtotime('+1 hour'))));
    }
}
?>
