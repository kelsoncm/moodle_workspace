<?php
define('CLI_SCRIPT', true);
define('CACHE_DISABLE_ALL', true);

$connected = false;
$i = 1;
$original_debug = getenv('CFG_DEBUG');
$original_timeout = getenv('CFG_CONNECTTIMEOUT');
putenv("CFG_DEBUG=false");
putenv("CFG_CONNECTTIMEOUT=1");
while (!$connected) {
    try {
        echo "Tentando conectar: $i ... ";
        include_once('/var/www/html/config.php');
        var_dump($DB->get_record_sql('SELECT now()'));
        $connected = true;
        echo "CONNECTED.\n";
    } catch (Exception $e) {
        echo "NOT CONNECTED.\n";
        sleep(3);
        $i++;
    }
}
putenv("CFG_DEBUG=$original_debug");
putenv("CFG_CONNECTTIMEOUT=$original_timeout");
