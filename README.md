# BlueSky Video Downloader

**BlueSky Video Downloader** é uma aplicação web que facilita o download de vídeos da rede social BlueSky (um novo Twitter). O projeto permite que usuários convertem vídeos da BlueSky, que estão no formato M3U8, para MP4, tornando-os facilmente acessíveis em diversos dispositivos.

## Funcionalidades

- **Conversão de Vídeos:** Receba o link do post da BlueSky e a aplicação buscará o link do vídeo em M3U8 e o converterá para o formato MP4.
- **Interface Simples:** Um formulário fácil de usar para inserir o link do post e iniciar a conversão.
- **Barra de Progresso:** Durante a conversão, um indicador de carregamento informa o progresso ao usuário.
- **Download Automático:** Após a conversão, o vídeo convertido é disponibilizado para download automático.

## Como Funciona

1. **Receba o Link do Post:** O usuário insere o link do post da BlueSky no formulário.
2. **Busca o Vídeo:** O sistema utiliza a API da BlueSky para obter o link do vídeo em M3U8.
3. **Converte o Vídeo:** O link do vídeo é passado para o FFmpeg, que converte o vídeo para o formato MP4.
4. **Download:** O vídeo convertido está disponível para download direto.

## Tecnologias Utilizadas

- **PHP:** Para manipulação do backend e execução dos comandos de conversão.
- **FFmpeg:** Ferramenta de linha de comando para converter o formato de vídeo.
- **Tailwind CSS:** Para estilização moderna e responsiva do formulário e das páginas.

## Configuração

Para rodar esta aplicação localmente:

1. **Clone o Repositório:**

   ```bash
   git clone https://github.com/seu-usuario/blue-sky-video-downloader.git

2. **Instale as Dependências:**

   Para executar este projeto, é necessário ter o PHP e o FFmpeg instalados e configurados em seu sistema. Não há dependências adicionais além dessas ferramentas.

2. **Configure o Servidor Web:**

   Configure seu servidor web (como Apache ou Nginx) para apontar para o diretório onde o projeto está localizado. Garanta que o diretório tenha permissões adequadas para leitura e escrita.

3. **Acesse a Aplicação:**

   Após a configuração, abra seu navegador e acesse a URL onde a aplicação está hospedada. Você deverá ver a página inicial com um formulário para inserir o link do post da BlueSky.

## Exemplo de Uso

1. **Abra a Página Principal da Aplicação:**

   Navegue até a URL onde a aplicação está hospedada.

2. **Insira o Link do Post da BlueSky:**

   No campo de URL, cole o link do post da BlueSky e clique em "Converter para MP4".

3. **Aguarde a Conversão:**

   O sistema exibirá um indicador de carregamento durante o processo de conversão.

4. **Baixe o Vídeo Convertido:**

   Após a conclusão da conversão, um link para download do vídeo convertido será exibido. Clique no link para baixar o vídeo em formato MP4.
