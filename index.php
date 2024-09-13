<!DOCTYPE html>
<html>
<head>
    <title>Video Downloader for BlueSky</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://docs.bsky.app/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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

        /* Evitar zoom no input em dispositivos móveis */
        input {
            font-size: 16px; /* Evita zoom em iOS */
        }

        /* Aumentar o card e o texto */
        @media (max-width: 640px) {
            .max-w-lg {
                max-width: 100%; /* Aumenta o card em dispositivos móveis */
            }

            h1 {
                font-size: 1.75rem; /* Aumenta o tamanho do título */
            }

            input, .rounded-md {
                font-size: 1.1rem; /* Aumenta o tamanho do texto dos inputs */
            }

            .bg-white {
                padding: 16px; /* Aumenta o padding do card */
            }
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"> <!-- Evita zoom ao clicar no input -->
</head>
<body class="bg-gray-100 flex flex-col justify-center min-h-screen">
    <div class="flex-grow flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <h1 class="text-2xl font-semibold text-gray-800 mb-4">Video Downloader for BlueSky</h1>
            <form id="conversion-form" action="convert.php" method="post">
                <input type="text" name="video_url" id="video_url" placeholder="Insira a URL do post do BlueSky" required class="w-full p-3 border border-gray-300 rounded-md mb-4">
                <input type="submit" value="Buscar vídeo" class="bg-indigo-600 text-white py-2 px-4 rounded-md shadow-sm hover:bg-indigo-700">
            </form>

            <!-- Redes Sociais -->
            <div class="mt-4 text-center">
                <div class="flex justify-center space-x-6">
                    <!-- Matheus Martins -->
                    <div class="text-center">
                        <p class="text-gray-600">Matheus Martins</p>
                        <a href="https://github.com/calebhphp" target="_blank" class="text-gray-500 hover:text-gray-900 mx-2">
                            <i class="fab fa-github fa-2x"></i>
                        </a>
                        <a href="https://www.linkedin.com/in/matheus-villanova" target="_blank" class="text-gray-500 hover:text-gray-900 mx-2">
                            <i class="fab fa-linkedin fa-2x"></i>
                        </a>
                    </div>

                    <!-- Caique Silva -->
                    <div class="text-center">
                        <p class="text-gray-600">Caique Silva</p>
                        <a href="https://github.com/scaique" target="_blank" class="text-gray-500 hover:text-gray-900 mx-2">
                            <i class="fab fa-github fa-2x"></i>
                        </a>
                        <a href="https://www.linkedin.com/in/sergio-caique-da-silva/" target="_blank" class="text-gray-500 hover:text-gray-900 mx-2">
                            <i class="fab fa-linkedin fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-200 py-4 text-center">
        <p class="text-gray-600">&copy; <?php echo date("Y"); ?> Feito por Matheus Martins e Caique Silva</p>
    </footer>

    <!-- Overlay de carregamento -->
    <div id="loading-overlay" class="overlay">Processando, por favor aguarde...</div>
    <script>
let cursor = null;

function carregando(valor) {
    const msg = document.getElementById("loading-overlay");
    msg.style.display = valor ? "flex" : "none";
}

async function getDID(actor) {
    const url = `https://public.api.bsky.app/xrpc/app.bsky.actor.getProfile?actor=${actor}`;
    try {
        const response = await fetch(url);
        if (!response.ok) throw new Error('Erro ao buscar o perfil');
        const data = await response.json();
        console.log(`actor: ${actor} - did: ${data.did}`);
        return { actor, did: data.did };
    } catch (error) {
        console.error('Erro:', error);
        return null;
    }
}

async function getPost(actor, did, postId) {
    try {
        let proxima = true;
        let playlist = null;

        while (proxima) {
            let url = `https://public.api.bsky.app/xrpc/app.bsky.feed.getAuthorFeed?actor=${actor}&filter=posts_with_media`;
            if (cursor) url += `&cursor=${cursor}`;

            const response = await fetch(url);
            if (!response.ok) throw new Error('Erro ao buscar o feed do autor');
            const data = await response.json();
            const expectedUri = `at://${did}/app.bsky.feed.post/${postId}`;

            for (const post of data.feed) {
                if (post.post?.uri === expectedUri) {
                    playlist = decodeURIComponent(post.post?.embed?.playlist);
                    console.log(`playlist: ${playlist}`);
                    proxima = false; // Encontrou a playlist, encerra o loop
                    break;
                }
            }

            cursor = data.cursor;
            proxima = cursor != null && !playlist; // Continua se houver cursor e playlist não encontrada
        }

        return playlist;
    } catch (error) {
        console.error('Erro:', error);
        return null;
    }
}

async function getLink() {
    const input = document.getElementById("video_url").value;
    const regex = /https:\/\/bsky\.app\/profile\/(.+?)\/post\/(.+)/;
    const match = input.match(regex);

    if (match) {
        const actor = match[1];
        const postId = match[2];
        carregando(true);

        const profileData = await getDID(actor);
        if (!profileData) {
            console.log("Não foi possível obter o DID.");
            carregando(false);
            return;
        }

        const playlist = await getPost(profileData.actor, profileData.did, postId);
        if (playlist && playlist.startsWith('http')) {
            // Enviar o formulário para o PHP
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'convert.php';
            const inputField = document.createElement('input');
            inputField.type = 'hidden';
            inputField.name = 'video_url';
            inputField.value = playlist;
            form.appendChild(inputField);
            document.body.appendChild(form);
            form.submit();  // Envia o formulário automaticamente
        } else {
            document.getElementById("div-link").innerText = "Nenhuma playlist encontrada.";
        }
        carregando(false);
    } else {
        console.log("Formato de link inválido.");
    }
}

// Adiciona um event listener ao formulário para usar a função getLink na submissão
document.getElementById('conversion-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita a submissão padrão do formulário
    getLink();
});

    </script>

</body>
</html>
