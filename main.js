let cursor = null;

function carregando(valor) {
    const msg = document.getElementById("mensagem");
    msg.style.display = valor ? "flex" : "none";
    return valor === "";
}

async function getDID(actor) {
    const url = `https://public.api.bsky.app/xrpc/app.bsky.actor.getProfile?actor=${actor}`;

    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('Erro ao buscar o perfil');
        }

        const data = await response.json();
        return { actor, did: data.did };
    } catch (error) {
        console.error('Erro:', error);
        return null;
    }
}

async function getPost(actor, did, postId) {
    try {
        let proxima = true;
        
        while (proxima) {
            let url = `https://public.api.bsky.app/xrpc/app.bsky.feed.getAuthorFeed?actor=${actor}&filter=posts_with_media`;
            if (cursor) {
                url += `&cursor=${cursor}`;
            }

            const response = await fetch(url);
            if (!response.ok) {
                throw new Error('Erro ao buscar o feed do autor');
            }

            const data = await response.json();

            if (!data.feed || !Array.isArray(data.feed)) {
                throw new Error('Feed não encontrado ou em formato inválido');
            }

            const expectedUri = `at://${did}/app.bsky.feed.post/${postId}`;
            for (const post of data.feed) {
                if (post.post?.uri === expectedUri) {
                    return post.post?.embed?.playlist || null;
                }
            }

            cursor = data.cursor;
            proxima = cursor != null;
        }

        return null;
    } catch (error) {
        console.error('Erro:', error);
        return null;
    }
}

async function getLink() {
    const input = document.getElementById("link-video").value;
    
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
        if (playlist) {
            document.getElementById("div-link").innerHTML = `<div class="container"><a id="link" href="${playlist}" target="_blank">Link</a></div>`;
        } else {
            document.getElementById("div-link").innerText = "Nenhuma playlist encontrada.";
        }

        carregando(false);
    } else {
        console.log("Formato de link inválido.");
    }
}

