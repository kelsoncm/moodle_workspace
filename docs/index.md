# Visão Geral — moodle-docker_compose

O **`moodle-docker_compose`** é um ambiente containerizado pré-configurado com **Docker Compose** para orquestração, execução e testes rápidos de instâncias Moodle e seus plugins em ambiente de desenvolvimento local.

---

## 🚀 Principais Recursos

- **Ambiente Completo Moodle + Banco de Dados**: Subida rápida de contêineres PHP/Apache Moodle e SGBD.
- **Separação de Build e Runtime**:
  - Diretório `build/plugins` para pacotes compilados na construção da imagem.
  - Diretório `src` para montagem de código em tempo de execução.
- **Pronto para Docker Hub**: Scripts e definições preparados para push de imagens personalizadas.

---

## 📚 Tópicos da Documentação

- 📦 **[Instalação & Requisitos](installation.md)** — Requisitos do Docker & Docker Compose.
- ⚙️ **[Configuração](configuration.md)** — Parametrização do `docker-compose.yml` e variáveis de ambiente.
- 📖 **[Guia de Uso](usage.md)** — Comandos `docker compose up`, inclusão de plugins e builds.
