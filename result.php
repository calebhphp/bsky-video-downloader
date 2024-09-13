<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversão de Vídeo - Resultado</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg text-center">
        <?php
        // Recebe o resultado da conversão
        $output_file = isset($_GET['file']) ? $_GET['file'] : '';

        if (isset($_GET['status']) && $_GET['status'] === 'success') {
            echo "<h1 class='text-2xl font-semibold text-gray-800 mb-4'>Conversão bem-sucedida!</h1>";
            echo "<p class='text-gray-600 mb-4'>O vídeo foi convertido com sucesso. Clique no botão abaixo para iniciar o download.</p>";
            echo "<a href='download.php?file=" . urlencode($output_file) . "' class='inline-block bg-indigo-600 text-white py-2 px-4 rounded-md shadow-sm hover:bg-indigo-700'>Download do arquivo MP4</a>";
        } else {
            echo "<h1 class='text-2xl font-semibold text-gray-800 mb-4'>Erro na Conversão</h1>";
            echo "<p class='text-red-600 mb-4'>Ocorreu um erro durante o processo de conversão. Tente novamente.</p>";
            echo "<a href='index.php' class='inline-block bg-indigo-600 text-white py-2 px-4 rounded-md shadow-sm hover:bg-indigo-700'>Voltar</a>"; 
        }
        ?>
    </div>
</body>
</html>
