<!DOCTYPE html>
<html>
<head>
    <title>Conversão de Vídeo - M3U8 para MP4</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilo do overlay de carregamento */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5em;
            font-weight: bold;
            z-index: 9999;
            display: none;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Conversão de Vídeo (M3U8 para MP4)</h1>
        <form id="conversion-form" action="convert.php" method="post">
            <label for="video_url" class="block text-gray-700 mb-2">Insira a URL do arquivo .m3u8:</label>
            <input type="text" name="video_url" id="video_url" required class="w-full p-2 border border-gray-300 rounded-md mb-4">
            <input type="submit" value="Converter para MP4" class="bg-indigo-600 text-white py-2 px-4 rounded-md shadow-sm hover:bg-indigo-700">
        </form>
    </div>
    <!-- Overlay de carregamento -->
    <div id="loading-overlay" class="overlay">Processando, por favor aguarde...</div>

    <script>
        // Exibir o overlay de carregamento quando o formulário é enviado
        document.getElementById('conversion-form').addEventListener('submit', function() {
            document.getElementById('loading-overlay').style.display = 'flex';
        });
    </script>
</body>
</html>
