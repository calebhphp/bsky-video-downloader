# BlueSky Video Downloader 
BlueSky Video Downloader é uma aplicação web que facilita o download de vídeos da rede social BlueSky (um novo Twitter). O projeto permite que usuários convertem vídeos da BlueSky, que estão no formato M3U8, para MP4, tornando-os facilmente acessíveis em diversos dispositivos.

Funcionalidades
Conversão de Vídeos: Receba o link do post da BlueSky, e a aplicação irá buscar o link do vídeo em M3U8 e convertê-lo para o formato MP4.
Interface Simples: Um formulário fácil de usar para inserir o link do post e iniciar a conversão.
Barra de Progresso: Durante a conversão, um indicador de carregamento informa o progresso ao usuário.
Download Automático: Após a conversão, o vídeo convertido é disponibilizado para download automático.
Como Funciona
Receba o Link do Post: O usuário insere o link do post da BlueSky no formulário.
Busca o Vídeo: O sistema utiliza a API da BlueSky para obter o link do vídeo em M3U8.
Converte o Vídeo: O link do vídeo é passado para o FFmpeg, que converte o vídeo para o formato MP4.
Download: O vídeo convertido está disponível para download direto.
Tecnologias Utilizadas
PHP: Para manipulação do backend e execução dos comandos de conversão.
FFmpeg: Ferramenta de linha de comando para converter o formato de vídeo.
Tailwind CSS: Para estilização moderna e responsiva do formulário e das páginas.
Configuração
Para rodar esta aplicação localmente:

Clone o Repositório:

bash
Copiar código
git clone https://github.com/seu-usuario/blue-sky-video-downloader.git
Instale as Dependências:

Certifique-se de que o PHP e o FFmpeg estão instalados e configurados no seu sistema.

Configure o Servidor Web:

Configure seu servidor web para apontar para o diretório do projeto.

Acesse a Aplicação:

Abra o navegador e vá para a URL onde a aplicação está hospedada.
