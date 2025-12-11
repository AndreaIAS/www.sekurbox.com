<?php

    $f = fopen("log_richieste.txt", "a");
    fwrite($f, "==============================================\n");
    fwrite($f, $_REQUEST["REMOTE_ADDR"]);
    fwrite($f, "\n\n");
    fwrite($f, json_encode($_GET));
    fwrite($f, "\n==============================================\n");
    fclose($f);

    echo "OK";

?>