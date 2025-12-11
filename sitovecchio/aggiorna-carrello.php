
<?php
include 'include/connessione.php';
include "include/lingua.php";
session_start();
$session = session_id();
$quantita = (isset($_POST['quantita']) && ctype_digit($_POST['quantita'])) ? $_POST['quantita'] : 0;
$id_prodotto = (isset($_POST['id_prodotto'])) ? $_POST['id_prodotto'] : '';
$action = (isset($_POST['submit'])) ? $_POST['submit'] : '';
$redirect=$_POST['redirect'];

switch ($action) {
    
case 'Aggiungi al carrello': case 'Add to Cart':
            if (!empty($id_prodotto) && $quantita > 0) {
                $query = 'INSERT INTO carrelli_temporanei
                        (session, id_prodotto, quantita)
                    VALUES
                        ("' . $session . '", "' .
                        mysql_real_escape_string($id_prodotto, $db) . '", ' . $quantita . ')';
                                mysql_query($query, $db) or die(mysql_error($db));
            }
            header('Location: http://www.sekurbox.com/'.$lingua.'/carrello.html');
            exit();
            break;

case 'Cambia Quantità': case 'Change Quantity':
    if (!empty($id_prodotto)) {
        if ($quantita > 0) {
            $query = 'UPDATE carrelli_temporanei
                SET
                    quantita = ' . $quantita . '
                WHERE
                    session = "' . $session . '" AND
                    id_prodotto = "' .
                    mysql_real_escape_string($id_prodotto, $db) . '"';
        } else {
            $query = 'DELETE FROM carrelli_temporanei
                WHERE
                    session = "' . $session . '" AND
                    id_prodotto = "' .
                    mysql_real_escape_string($id_prodotto, $db) . '"';
        }
        mysql_query($query, $db) or die(mysql_error($db));
    }
    header('Location: http://www.sekurbox.com/'.$lingua.'/carrello.html');
    exit();
    break;

case $svuota_carrello:
    $query = 'DELETE FROM carrelli_temporanei
        WHERE
            session = "' . $session . '"';
    mysql_query($query, $db) or die(mysql_error($db));
    header('Location: '.$redirect);
    exit();
    break;
}
?>