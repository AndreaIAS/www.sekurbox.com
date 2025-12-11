<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header('Refresh: 3; URL=http://www.sekurbox.com');
    echo '<p>Area Riservata.</p>';
    echo '<p>Sarai indirizzato alla home page del sito, se non vieni indirizzato automaticamente ' .
        '<a href="http://www.sekurbox.com">clicca qui</a></p>';
    die();
}
?>