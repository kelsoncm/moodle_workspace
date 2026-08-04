# Instalação — moodle-docker_compose

## Requisitos

- **Docker Engine**: 20.10+
- **Docker Compose**: v2.0+
- **Git**

---

## Passo a Passo

1. Clone o repositório em sua máquina de desenvolvimento:
   ```bash
   git clone https://github.com/moodle-by-kelsoncm/moodle-docker_compose.git
   cd moodle-docker_compose
   ```
2. Verifique o arquivo `docker-compose.yml` e personalize o nome da imagem caso necessário:
   ```yaml
   services:
     moodle:
       image: meu/moodle:4.5.0
   ```
3. Construa as imagens e inicie os contêineres:
   ```bash
   docker compose build
   docker compose up -d
   ```
