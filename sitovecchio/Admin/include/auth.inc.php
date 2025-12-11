
<?php
// start or continue session
session_start();

if (!isset($_SESSION['logged'])) {
    header('Refresh: 3; URL=http://www.sekurbox.com/Admin');
    echo '<p>Area Riservata.</p>';
    echo '<p>Sarai indirizzato alla home page del sito, se non vieni indirizzato automaticamente <a href="http://www.sekurbox.com/Admin">clicca qui</a>.</p>';
    die();
}
?>

