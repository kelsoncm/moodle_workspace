# Guia de Uso — moodle-docker_compose

## Comandos Úteis

### Iniciar o ambiente Moodle:
```bash
docker compose up -d
```

### Visualizar logs da aplicação:
```bash
docker compose logs -f moodle
```

### Executar CLI de atualização no contêiner:
```bash
docker compose exec -T moodle php admin/cli/upgrade.php --non-interactive
```

### Limpar caches do Moodle:
```bash
docker compose exec -T moodle php admin/cli/purge_caches.php
```
