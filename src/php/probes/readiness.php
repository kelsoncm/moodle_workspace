<?php
    ob_start();
    $accept = explode(',', strtolower(str_replace(   ' ', '', $_SERVER['HTTP_ACCEPT'])))[0];
    header("Content-Type: $accept");
    require_once '../readenv.php';
    if (env('CFG_PROBES_TOKEN') !== $_GET['token']) {
        echo "Não autorizado!\n" ;
        http_response_code(403);
        exit();
    }
    $checks = [];

    try {
        if (file_exists("/var/www/moodledata/climaintenance.html")) {
            $checks[] = ["Modo de manutenção inativo", false];
        } else {
            $checks[] = ["Modo de manutenção inativo", true];
            try {
                require_once '../config.php';
                if ($DB->count_records_sql("SELECT 1") == 1) {
                    $checks[] = ["PostgreSQL database conectando", true];
                } else {
                    $checks[] = ["PostgreSQL database conectando", false];
                };
            } catch (dml_connection_exception $e) {
                $checks[] = ["PostgreSQL database conectando", false];
            }

            if (env_as_bool('CFG_PROBES_DEBUG')) {
                $checks[] = ["Debug inativo", !$CFG->debug];
                $checks[] = ["Theme designer mode", !$CFG->themedesignermode];
                $checks[] = ["Cache JS", $CFG->cachejs];
                $checks[] = ["Debug display", !$CFG->debugdisplay];
            }

//            if (env_as_bool('CFG_PROBES_SESSION_REDIS')) {
//                $checks[] = ["Sessão usando Redis", false];
//            }
//            if (env_as_bool('CFG_PROBES_CACHE_REDIS')) {
//                $checks[] = ["Cache usando Redis", false];
//            }
            if (env_as_bool('CFG_PROBES_CRONJOB')) {
//                $checks[] = ["Cronjob executando a cada minuto", false];
                $checks[] = ["Cronjob ativo", $CFG->cron_enabled];
                $checks[] = ["Cronjob restrito ao CLI", $CFG->cronclionly];
            }
            if (env_as_bool('CFG_PROBES_TASKS')) {
//                $checks[] = ["Tasks sem falha", ????];
            }
//            if (env_as_bool('CFG_PROBES_AUTOMATIC_BACKUP')) {
//                $checks[] = ["Backup automático ativo", $CFG->backup_auto_active];
//            }
//            if (env_as_bool('CFG_PROBES_STATISCTICS')) {
//                $checks[] = ["Estatísticas ativas", $CFG->enablestats];
//            }
            if (env_as_bool('CFG_PROBES_ANALYTICS')) {
//                $checks[] = ["Analíticas ativas", $CFG->????];
            }
            if (env_as_bool('CFG_PROBES_WEBSERVICES')) {
//                $checks[] = ["Webservices ativos", $CFG->????];
            }
            if (env_as_bool('CFG_PROBES_DBSYNC')) {
//                $checks[] = ["Esquema do banco de dados sincronizado", $CFG->????];
            }
        }
    } catch (Exception $e) {
    }

    $tudo_ok = true;
    if ($accept == "text/plain") {
        echo "Moodle health checker: $accept\n";
        foreach ($checks as $check) {
            $tudo_ok = $tudo_ok && $check[1];
            $status = $check[1] ? "OK" : "FAIL";
            echo "$check[0]: $status\n";
        }
        $status = $tudo_ok ? "ALL FINE" : "SOME FAILS";
        echo "Status geral: $status\n";
        http_response_code($tudo_ok ? 200 : 510);
    } else {
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">';
        echo "<h1>Moodle health checker: $accept</h1><table class='table table-striped table-hover'><thead><tr><th>Check</th><th>Status</th></tr></thead><tbody class='table-group-divider'>";
        foreach ($checks as $check) {
            $tudo_ok = $tudo_ok && $check[1];
            $status = $check[1] ? "✅" : "❌";
            echo "<tr><td>$check[0]</td><td>$status</td></tr>";
        }
        $status = $tudo_ok ? "✅" : "❌";
        echo "</tbody><tfoot class='table-group-divider'><tr><td>Status geral</td><td>$status</td></tr></tfoot></table>";
        http_response_code($tudo_ok ? 200 : 510);
    }
    ob_flush();
