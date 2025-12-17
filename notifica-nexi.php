<?php

include("inc_config.php");

$idOrdine = isset($_GET['id_ordine']) ? (int)$_GET['id_ordine'] : 0;
if ($idOrdine <= 0) {
    http_response_code(400);
    die('id_ordine mancante');
}

$db->query("SELECT * FROM bag_ordini WHERE id=:id");
$dbOrdine = $db->single(array('id' => $idOrdine));
if (!$dbOrdine) {
    http_response_code(404);
    die('Ordine non trovato');
}

if (isset($dbOrdine['pagato']) && $dbOrdine['pagato'] === 's') {
    http_response_code(200);
    die('OK');
}

// TODO: validare la notifica Nexi (firma/MAC o token) quando avrai le specifiche e le credenziali.
// Per ora consideriamo la notifica come "OK" per costruire la struttura.

$db->query("UPDATE bag_ordini SET pagato='s' WHERE id=:id");
$db->execute(array('id' => $idOrdine));

$template_email = file_get_contents(BASE_URL . "template-email.php?id_ordine=" . $idOrdine);

$messaggio = new PHPmailer();
$messaggio->IsHTML(true);
$messaggio->SetLanguage("it", './php_mailer_language/');
$messaggio->CharSet = 'UTF-8';

$messaggio->From = EMAIL_ADM;
$messaggio->FromName = "Sekurbox";

if (!empty($dbOrdine['email'])) {
    $messaggio->AddAddress($dbOrdine['email']);
} else {
    $messaggio->AddAddress(EMAIL_ADM);
}

$messaggio->Subject = 'Sekurbox.com - Conferma ordine numero SK' . $idOrdine;
$messaggio->Body = $template_email;

$messaggio->Send();

http_response_code(200);
die('OK');
