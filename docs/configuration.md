# Configuração — moodle-docker_compose

## Estrutura de Diretórios

- **`build/plugins`**: Novos plugins baixados do repositório Moodle colocados aqui serão integrados na construção da imagem.
- **`src`**: Contém código-fonte montado em tempo de execução para rápida edição em desenvolvimento.

## Variáveis de Ambiente

As variáveis de banco de dados (ex: MariaDB/PostgreSQL), portas HTTP/HTTPS e volume de uploads são configuráveis no `docker-compose.yml`.
