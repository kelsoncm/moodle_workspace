# Exemplo de Moodle em imagem Docker e usando Docker Compose


```bash
git clone https://github.com/kelsoncm/moodle_workspace.git
cd moodle_workspace
docker compose build
docker compose up
```

Não se esqueça de alterar o arquivo `docker-compose.yml`, especialmente a `image:` para um nome de imagem que você deseja.

```
services:
# ...
    ava:
        image: meu/moodle:4.5.6.001
```

## Observações
1. Novos plugins são instalados baixando da **Moodle Plugins Directory** e colocando na pasta `build/plugins`.
2. A pasta `build/plugins` ficam os código udando apenas em tempo de **construção**.
3. A pasta `src`  ficam os código udando apenas em tempo de **execução**.
