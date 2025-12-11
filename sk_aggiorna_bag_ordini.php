<?php
    include("inc_config.php");

    if (empty($_GET["transactionID"]))
        die("Transaction ID mancante");

    $id_ordine= $_GET["transactionID"];

    $query = " UPDATE bag_ordini SET pagato = 1

            WHERE id= '" . trim($transactionId) . "' ";

    $db->query($query);

    $db->execute(); 

    echo "OK";
?>