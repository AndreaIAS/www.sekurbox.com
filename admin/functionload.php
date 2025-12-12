<?php

//Include config
include('config.php');


//********************************  LOGIN ********************************************
if ($_POST['function'] == "login") {

  $errore = "no";

  $array_req = array("username", "password");

  //Conrtrollo i campi obbligatori
  for ($i = 0; $i < count($array_req); $i++) {

    $valore = $array_req[$i];
    if (trim($_POST[$valore]) == "") {

      $nome = $valore;
      $errore = "request";
      $arr = array('campo' => $nome, 'errore' => $errore);
      echo json_encode($arr);
      exit();
    }
  }

  $db->query("SELECT password, username FROM 
                 bag_admin 
                 WHERE id = '3' ");
  $list = $db->single();



  if (trim(mysql_escape_string($_POST['username'])) != $list['username']) {

    $nome = 'username';
    $errore = "notmatch";
    $arr = array('campo' => $nome, 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }

  if (trim(mysql_escape_string($_POST['password'])) != $list['password']) {

    $nome = 'password';
    $errore = "notmatch";
    $arr = array('campo' => $nome, 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }

  $_SESSION = array();
  $_SESSION['admin_account']['username'] = trim($_POST['username']);
  $_SESSION['admin_account']['login'] = 1;

  $arr = array('campo' => '', 'errore' => $errore);
  echo json_encode($arr);
}


//********************************FINE  LOGIN ********************************************


//********************************MODIFICA SLIDER HOME ********************************************  

if ($_POST['function'] == 'editsliderhome') {

  $testoquery = "";
  for ($i = 1; $i <= 5; $i++) {

    $indimg = "img" . $i;
    $indlink = "link_img" . $i;

    if (isset($_POST[$indimg])) {
      $testoquery .= $indimg . "='" . mysql_escape_string($_POST[$indimg]) . "', ";
    }

    $testoquery .= $indlink . "='" . mysql_escape_string($_POST[$indlink]) . "' ";

    if ($i != 5) {
      $testoquery .= ",";
    }
  }
  $errore = "no";

  $db->query("UPDATE slider_home 
                 SET " . $testoquery);

  if ($db->execute()) {
    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }

  $errore = mysql_error();
  $arr = array('campo' => '', 'errore' => $errore);
  echo json_encode($arr);
  exit();
}

//********************************FINE MODIFICA SLIDER HOME ********************************************  



//********************************  MODIFICA CATEGORIA ARTICOLI BLOG ********************************************
if ($_POST['function'] == "editcateart") {


  $errore = "no";


  $db->query("UPDATE  
  	       categorie_articoli 
  	       SET categoria_articolo_it='" . mysql_escape_string($_POST['categoria_it']) . "'
               WHERE id_categoria_articolo = '" . mysql_escape_string($_POST['id']) . "' ");

  if ($db->execute()) {

    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  } else {
    $nome = mysql_error();
    $errore = 'editrecord';
    $arr = array('campo' => $nome, 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }
}


//********************************FINE  MODIFICA CATEGORIA ARTICOLI BLOG  ********************************************



//******************************** INSERISCI CATEGORIA  ARTICOLI BLOG ********************************************
if ($_POST['function'] == "inscateart") {


  $errore = "no";



  $db->query("INSERT INTO  
  	           categorie_articoli (categoria_articolo_it)
  	           VALUES('" . mysql_escape_string($_POST['categoria_it']) . "')
              ");



  if ($db->execute()) {

    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  } else {
    $nome = mysql_error();
    $errore = 'insrecord';
    $arr = array('campo' => $nome, 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }
}


//********************************FINE  INSERISCI  CATEGORIA  ARTICOLI BLOG ********************************************                                       


//******************************** INSERISCI ARTICOLO********************************************
if ($_POST['function'] == 'insarticolo') {

  $errore = "no";

  $db->query("INSERT INTO

                      articoli (titolo_it,articolo_it,immagine,autore,title,
                      keywords,description,url,categoria,visible,data) 
                       VALUES('" . mysql_escape_string($_POST['titolo_it']) . "',
                         '" . mysql_escape_string($_POST['articolo_it']) . "',
                         '" . mysql_escape_string($_POST['immagine']) . "','" . mysql_escape_string($_POST['autore']) . "',
                         '" . mysql_escape_string($_POST['title']) . "','" . mysql_escape_string($_POST['keywords']) . "','" . mysql_escape_string($_POST['description']) . "',
                         '" . mysql_escape_string($_POST['url']) . "','" . mysql_escape_string($_POST['categoria']) . "',
                         '" . mysql_escape_string($_POST['visible']) . "',NOW()
                         )");



  if ($db->execute()) {
    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }

  $errore = mysql_error();
  $arr = array('campo' => '', 'errore' => $query);
  echo json_encode($arr);
  exit();
}



//********************************FINE  INSERISCI Articolo********************************************   


//******************************** MODIFICA ARTICOLO********************************************
if ($_POST['function'] == 'editarticolo') {

  $errore = "no";

  $db->query("UPDATE
                     articoli
                     SET
                     titolo_it='" . mysql_escape_string($_POST['titolo_it']) . "',
                     articolo_it='" . mysql_escape_string($_POST['articolo_it']) . "',
                     immagine='" . mysql_escape_string($_POST['immagine']) . "',
                     autore='" . mysql_escape_string($_POST['autore']) . "',
                     title='" . mysql_escape_string($_POST['title']) . "',
                     keywords='" . mysql_escape_string($_POST['keywords']) . "',
                     description='" . mysql_escape_string($_POST['description']) . "',
                     url='" . mysql_escape_string($_POST['url']) . "',
                     categoria='" . mysql_escape_string($_POST['categoria']) . "',
                     visible='" . mysql_escape_string($_POST['visible']) . "'
                     WHERE id_articolo='" . mysql_escape_string($_POST['id']) . "'
                     ");



  if ($db->execute()) {
    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }

  $errore = mysql_error();
  $arr = array('campo' => '', 'errore' => $query);
  echo json_encode($arr);
  exit();
}



//********************************FINE  MODIFICA ARTICOLO********************************************

//********************************  MODIFICA MARCA ********************************************
if ($_POST['function'] == "editmarca") {

  $errore = "no";

  $db->query("UPDATE  
  	       bag_marche 
  	       SET 
               nome_it='" . mysql_escape_string($_POST['nome_it']) . "',
               nome_en='" . mysql_escape_string($_POST['nome_en']) . "',
               immagine='" . mysql_escape_string($_POST['immagine']) . "'
               WHERE id = '" . mysql_escape_string($_POST['id']) . "' ");

  if ($db->execute()) {

    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  } else {
    $nome = mysql_error();
    $errore = 'editrecord';
    $arr = array('campo' => $nome, 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }
}

//********************************FINE  MODIFICA MARCA  ********************************************                                     



//******************************** INSERISCI MARCA ********************************************
if ($_POST['function'] == "insmarca") {

  $errore = "no";

  $db->query("INSERT INTO  
  	        bag_marche(nome_it,nome_en,immagine)
  	        VALUES('" . mysql_escape_string($_POST['nome_it']) . "','" . mysql_escape_string($_POST['nome_en']) . "','" . mysql_escape_string($_POST['immagine']) . "')
               ");

  if ($db->execute()) {

    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  } else {
    $nome = mysql_error();
    $errore = 'insrecord';
    $arr = array('campo' => $nome, 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }
}
//********************************FINE INSERISCI  MARCA  ********************************************    

//********************************  MODIFICA CATEGORIA ********************************************
if ($_POST['function'] == "editcate") {

  $errore = "no";

  $db->query("UPDATE  
  	       bag_categorie 
  	       SET 
               nome_it='" . mysql_escape_string($_POST['nome_it']) . "',
               nome_en='" . mysql_escape_string($_POST['nome_en']) . "',
               posizione='" . mysql_escape_string($_POST['posizione']) . "',
               immagine='" . mysql_escape_string($_POST['immagine']) . "',
               font_awesome_code='" . mysql_escape_string($_POST['font_awesome_code']) . "'
               WHERE id = '" . mysql_escape_string($_POST['id']) . "' ");

  if ($db->execute()) {

    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  } else {
    $nome = mysql_error();
    $errore = 'editrecord';
    $arr = array('campo' => $nome, 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }
}

//********************************FINE  MODIFICA CATEGORIA  ********************************************

//******************************** INSERISCI CATEGORIA ********************************************
if ($_POST['function'] == "inscate") {

  $errore = "no";

  $db->query("INSERT INTO  
  	           bag_categorie (nome_it,nome_en,immagine,posizione,id_macro,font_awesome_code)
  	           VALUES('" . mysql_escape_string($_POST['nome_it']) . "','" . mysql_escape_string($_POST['nome_en']) . "','" . mysql_escape_string($_POST['immagine']) . "'
                       ,'" . mysql_escape_string($_POST['posizione']) . "','1','" . mysql_escape_string($_POST['font_awesome_code']) . "')
              ");

  if ($db->execute()) {

    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  } else {
    $nome = mysql_error();
    $errore = 'insrecord';
    $arr = array('campo' => $nome, 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }
}
//********************************FINE  INSERISCI  CATEGORIA  ********************************************    


//********************************AGGIORNA STATO PAGAMENTO ********************************************

if ($_POST['function'] == 'aggiornastatopag') {
  if ($_POST['statoattuale'] == 's') $stato = 'n';
  else $stato = 's';

  $db->query("SELECT * FROM bag_det_ord WHERE id_ordine='" . $_POST['id'] . "' ");
  $resultm = $db->resultset();
  foreach ($resultm as $listm) {

    $db->query("UPDATE bag_prodotti SET quantita= quantita-" . $listm['qta'] . " WHERE id='" . $listm['id_articolo'] . "' ");
    $db->execute();
  }


  $db->query("UPDATE bag_ordini SET pagato= '" . $stato . "' WHERE id='" . $_POST['id'] . "' ");
  $db->execute();

  $arr = array('valore' => $stato);
  echo json_encode($arr);
  exit();
}
//******************************** FINE STATO PAGAMENTO ********************************************    


//********************************AGGIORNA STATO SPEDITO ********************************************

if ($_POST['function'] == 'aggiornastatosped') {
  if ($_POST['statoattuale'] == 's') $stato = 'n';
  else $stato = 's';

  $db->query("UPDATE bag_ordini SET spedito= '" . $stato . "' WHERE id='" . $_POST['id'] . "' ");
  $db->execute();

  $arr = array('valore' => $stato);
  echo json_encode($arr);
  exit();
}
//******************************** FINE STATO SPEDITO ********************************************   



//********************************ELIMINA RECORD ********************************************
if ($_POST['function'] == 'elimina') {

  $db->query("DELETE FROM  " . $_POST['table'] . "  WHERE id='" . $_POST['idrecord'] . "' ");
  $db->execute();
}
//******************************** FINE ELIMINA RECORD ********************************************


//******************************** INSERISCI UTENTE********************************************
if ($_POST['function'] == 'insutente') {


  $errore = "no";
  //creazione codice attivazione account    
  //                $usernameStrip = trim($_POST['email']);
  //                function ActiveCode($nome_utente){
  //		$chiave_attivazione = md5(time().$nome_utente.'tonio1622wqo234');
  //		return $chiave_attivazione;
  //	                                          }   
  //                $chiave = ActiveCode($usernameStrip);

  $db->query("INSERT INTO
                     bag_utenti (cellulare,data_regis,attivo,ragione,nome,cognome,password,p_iva,cod_fiscale,indirizzo,id_nazione,id_comune,cap,email,tipologia,telefono,note_regis) 
                     VALUES('" . mysql_escape_string($_POST['cellulare']) . "',NOW(),'" . mysql_escape_string($_POST['attivo']) . "',
                            '" . mysql_escape_string($_POST['ragione']) . "','" . mysql_escape_string($_POST['nome']) . "'
                            ,'" . mysql_escape_string($_POST['cognome']) . "'
                               ,'" . mysql_escape_string(md5($_POST['password'])) . "','" . mysql_escape_string($_POST['p_iva']) . "' 
                            ,'" . mysql_escape_string($_POST['cod_fiscale']) . "','" . mysql_escape_string($_POST['indirizzo']) . "'
                                ,'" . mysql_escape_string($_POST['id_nazione']) . "' ,'" . mysql_escape_string($_POST['id_comune']) . "'
                            ,'" . mysql_escape_string($_POST['cap']) . "' ,'" . mysql_escape_string($_POST['email']) . "' ,'" . mysql_escape_string($_POST['tipologia']) . "' 
                            ,'" . mysql_escape_string($_POST['telefono']) . "','" . mysql_escape_string($_POST['note_regis']) . "' );  
                        ");

  if ($db->execute()) {
    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }

  $errore = mysql_error();
  $arr = array('campo' => '', 'errore' => $query);
  echo json_encode($arr);
  exit();
}

//********************************FINE  INSERISCI UTENTE********************************************     

//******************************** MODIFICA UTENTE********************************************
if ($_POST['function'] == 'editutente') {

  $errore = "no";

  //creazione codice attivazione account    
  //                $usernameStrip = trim($_POST['email']);
  //                function ActiveCode($nome_utente){
  //		$chiave_attivazione = md5(time().$nome_utente.'tonio1622wqo234');
  //		return $chiave_attivazione;
  //	                                          }   
  //                $chiave = ActiveCode($usernameStrip);

  $queryUpdUsers = "UPDATE
                      bag_utenti 
                    SET
                      cellulare='" . mysql_escape_string($_POST['cellulare']) . "',
                      nome='" . mysql_escape_string($_POST['nome']) . "',
                      attivo='" . mysql_escape_string($_POST['attivo']) . "',
                      ragione='" . mysql_escape_string($_POST['ragione']) . "',
                      cognome='" . mysql_escape_string($_POST['cognome']) . "',
                      password='" . mysql_escape_string(md5($_POST['password'])) . "',
                      p_iva='" . mysql_escape_string($_POST['p_iva']) . "',
                      cod_fiscale='" . mysql_escape_string($_POST['cod_fiscale']) . "',
                      indirizzo='" . mysql_escape_string($_POST['indirizzo']) . "',
                      id_nazione='" . mysql_escape_string($_POST['id_nazione']) . "',
                      id_comune='" . mysql_escape_string($_POST['id_comune']) . "',
                      cap='" . mysql_escape_string($_POST['cap']) . "',
                      email='" . mysql_escape_string($_POST['email']) . "',
                      tipologia='" . mysql_escape_string($_POST['tipologia']) . "',
                      telefono='" . mysql_escape_string($_POST['telefono']) . "',
                      note_regis='" . mysql_escape_string($_POST['note_regis']) . "'
                      WHERE id='" . mysql_escape_string($_POST['id']) . "' ";

  $db->query($queryUpdUsers);

  if ($db->execute()) {
    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }

  $errore = mysql_error();
  $arr = array('campo' => '', 'errore' => $query);
  echo json_encode($arr);
  exit();
}

//********************************FINE  MODIFICA UTENTE********************************************        

//********************************  LOAD REGIONI ********************************************
if ($_POST['function'] == "regionireg") {
?>

  <div id="data">
    <b>Regione</b><br />
    <span class="field">
      <select name="id_regione" required class="select2" id="id_regione"
        onchange="jQuery('#provincia').load('functionload.php #data',{function:'provincereg',id_regione:jQuery(this).val()},
                                                  function(){jQuery('#id_provincia .select2').select2({
                                                        theme: 'classic',
                                                        dropdownAutoWidth: true,
                                                        width: '40.7%',
                                                        padding: '10px'
                                             });});">
        <option value="">Regione</option>
        <?php
        $db->query("SELECT *
                  FROM  
                  regioni
                  -- WHERE id_regione = '" . mysql_escape_string($_POST['id_regione']) . "'
                  ORDER by nome
                  ");
        $recordr = $db->resultset();
        foreach ($recordr as $list) {
        ?>
          <option value="<?= $list['id']; ?>"><?= $list['nome']; ?></option>
        <?php } ?>
      </select>
    </span>
  </div>

<?php }
//********************************FINE  LOAD REGIONI  ********************************************

//********************************  LOAD PROVINCE ********************************************
if ($_POST['function'] == "provincereg") {
?>

  <div id="data">
    <b>Provincia</b><br />
    <span class="field">
      <select name="id_provincia" required class="select2" id="id_provincia"
        onchange="jQuery('#comune').load('functionload.php #data',{function:'comunireg',id_provincia:jQuery(this).val()},
                                                  function(){jQuery('#id_comune .select2').select2({
                                                        theme: 'classic',
                                                        dropdownAutoWidth: true,
                                                        width: '40.7%',
                                                        padding: '10px'
                                             });});">
        <option value="">Provincia</option>
        <?php
        $db->query("SELECT *
                  FROM  
                  province
                  WHERE id_regione = '" . mysql_escape_string($_POST['id_regione']) . "'
                  ORDER by nome
                  ");
        $recordr = $db->resultset();
        foreach ($recordr as $list) {
        ?>
          <option value="<?= $list['id']; ?>"><?= $list['nome']; ?></option>
        <?php } ?>
      </select>
    </span>
  </div>

<?php }
//********************************FINE  LOAD PROVINCE  ********************************************

//********************************  LOAD COMUNI ********************************************
if ($_POST['function'] == "comunireg") { ?>

  <div id="data">
    <b>Comune</b><br />
    <span class="field">
      <select name="id_comune" required class="select2" id="id_comune"
        onchange="jQuery('#cap').load('functionload.php #data',{function:'capreg',id_comune:jQuery(this).val()});">
        <option value="">Comune</option>
        <?php
        $db->query("SELECT *
                  FROM  
                  comuni
                  WHERE id_provincia = '" . mysql_escape_string($_POST['id_provincia']) . "'
                  ORDER by nome
                  ");
        $recordr = $db->resultset();
        foreach ($recordr as $list) {
        ?>
          <option value="<?= $list['id']; ?>"><?= $list['nome']; ?></option>
        <?php } ?>
      </select>
    </span>
  </div>

<?php }

//********************************FINE   LOAD COMUNI ************************************

//********************************  SHOW CAP ********************************************
if ($_POST['function'] == "capreg") { ?>

  <div id="data">
    <b>CAP</b><br />
    <span class="field"><input type="text" name="cap" id="cap" class="smallinput" /></span>
  </div>

<?php }
//********************************FINE SHOW CAP ********************************************

//******************************** INSERISCI PRODOTTO***************************************
if ($_POST['function'] == 'insprodotto') {

  $errore = "no";
  $prezzo = str_replace(",", ".", $_POST['prezzo']);
  if (isset($_POST['piu_venduto'])) $piuvenduto = 's';
  else $piuvenduto = 'n';
  if (isset($_POST['ultimo_arrivo'])) $ultimoarrivo = 's';
  else $ultimoarrivo = 'n';
  if (isset($_POST['offerta'])) $offerta = 's';
  else $offerta = 'n';


  $db->query("INSERT INTO
                     bag_prodotti (nome_it,nome_en,descrizione_it,descrizione_en,description_it,description_en,codice,quantita,prezzo,
                     sconto_installatore,sconto_rivenditore,immagine,id_sottocategoria,id_marca,data_insert,scheda_tecnica,posizione,offerta,ultimo_arrivo,piu_venduto) 
                     VALUES('" . mysql_escape_string($_POST['nome_it']) . "','" . mysql_escape_string($_POST['nome_en']) . "','" . mysql_escape_string($_POST['descrizione_it']) . "','" . mysql_escape_string($_POST['descrizione_en']) . "'
                          , '" . mysql_escape_string($_POST['description_it']) . "', '" . mysql_escape_string($_POST['description_en']) . "','" . mysql_escape_string($_POST['codice']) . "',
                            '" . mysql_escape_string($_POST['quantita']) . "','" . mysql_escape_string($prezzo) . "','" . mysql_escape_string($_POST['sconto_installatore']) . "','" . mysql_escape_string($_POST['sconto_rivenditore']) . "',
                            '" . mysql_escape_string($_POST['immagine']) . "', '" . mysql_escape_string($_POST['id_sottocategoria']) . "','" . mysql_escape_string($_POST['id_marca']) . "', NOW(),"
    . "    '" . mysql_escape_string($_POST['scheda_tecnica']) . "','" . mysql_escape_string($_POST['posizione']) . "','" . $offerta . "',"
    . "'" . $ultimoarrivo . "','" . $piuvenduto . "')  						

                    ");

  if ($db->execute()) {

    $idprodotto = $db->lastInsertId();


    $db->query("INSERT INTO  
                        bag_image(id_prodotto,immagine,posizione)
                        VALUES('" . $idprodotto . "','" . mysql_escape_string($_POST['immagine']) . "',1)
                       ");
    $db->execute();

    if (isset($_POST['immagine_m']) and count($_POST['immagine_m']) > 0) {

      foreach ($_POST['immagine_m'] as $immagine) {

        $db->query("INSERT INTO  
                                    bag_image(id_prodotto,immagine,posizione)
                                    VALUES('" . $idprodotto . "','" . mysql_escape_string($immagine) . "',2)
                                   ");
        $db->execute();
      }
    }

    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }

  $errore = mysql_error();
  $arr = array('campo' => '', 'errore' => $query);
  echo json_encode($arr);
  exit();
}

//********************************FINE  INSERISCI PRODOTTO********************************************   

//******************************** MODIFICA POSIZIONE PRODOTTO********************************************
if ($_POST['function'] == 'edit_posizione') {

  $db->query("UPDATE
                    " . $_POST['table'] . "
                    SET
                    posizione='" . mysql_escape_string($_POST['valore']) . "'
                    WHERE id='" . mysql_escape_string($_POST['id']) . "'
                     ");

  if ($db->execute()) {
    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }
  $errore = mysql_error();
  $arr = array('campo' => '', 'errore' => $query);
  echo json_encode($arr);
  exit();
}

//********************************FINE  MODIFICA POSIZIONE PRODOTTO******************************************** 

//******************************** MODIFICA SCONTO INSTALLATORE PRODOTTO********************************************
if ($_POST['function'] == 'edit_sconto_inst') {

  $db->query("UPDATE
                     bag_prodotti
                     SET
                     sconto_installatore='" . mysql_escape_string($_POST['valore']) . "'
                     WHERE id='" . mysql_escape_string($_POST['id']) . "'
                     ");

  if ($db->execute()) {
    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }
  $errore = mysql_error();
  $arr = array('campo' => '', 'errore' => $query);
  echo json_encode($arr);
  exit();
}

//********************************FINE  MODIFICA SCONTO INSTALLATORE PRODOTTO********************************************                                      

//******************************** MODIFICA SCONTO RIVENDITORE PRODOTTO********************************************
if ($_POST['function'] == 'edit_sconto_riv') {

  $db->query("UPDATE
                bag_prodotti
                SET
                sconto_rivenditore='" . mysql_escape_string($_POST['valore']) . "'
                WHERE id='" . mysql_escape_string($_POST['id']) . "'
               ");

  if ($db->execute()) {
    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }

  $errore = mysql_error();
  $arr = array('campo' => '', 'errore' => $query);
  echo json_encode($arr);
  exit();
}

//********************************FINE  MODIFICA SCONTO RIVENDITORE PRODOTTO********************************************                                     

//******************************** MODIFICA PREZZO PRODOTTO********************************************
if ($_POST['function'] == 'edit_prezzo') {

  $prezzo = str_replace(",", ".", $_POST['valore']);

  $db->query("UPDATE
                     bag_prodotti
                     SET
                     prezzo='" . mysql_escape_string($prezzo) . "'
                     WHERE id='" . mysql_escape_string($_POST['id']) . "'
                     ");

  if ($db->execute()) {
    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }
  $errore = mysql_error();
  $arr = array('campo' => '', 'errore' => $query);
  echo json_encode($arr);
  exit();
}

//********************************FINE  MODIFICA PREZZO PRODOTTO******************************************** 

//******************************** MODIFICA QUANTITA PRODOTTO********************************************

if ($_POST['function'] == 'edit_quantita') {



  $db->query("UPDATE
                    " . $_POST['table'] . "
                    SET
                    quantita='" . mysql_escape_string($_POST['valore']) . "'
                    WHERE id='" . mysql_escape_string($_POST['id']) . "'
                    ");

  if ($db->execute()) {

    $arr = array('campo' => '', 'errore' => $errore);

    echo json_encode($arr);

    exit();
  }

  $errore = mysql_error();

  $arr = array('campo' => '', 'errore' => $query);

  echo json_encode($arr);

  exit();
}

//********************************FINE MODIFICA QUANTITA PRODOTTO********************************************

//******************************** MODIFICA PRODOTTO********************************************
if ($_POST['function'] == 'editprodotto') {

  $errore = "no";
  $prezzo = str_replace(",", ".", $_POST['prezzo']);
  $prezzo_scontato = str_replace(",", ".", $_POST['prezzo_scontato']);

  if (isset($_POST['immagine'])) $rigaimg = " immagine='" . mysql_escape_string($_POST['immagine']) . "', ";
  else $rigaimg = "";

  if (isset($_POST['id_sottocategoria'])) $rigascat = " id_sottocategoria='" . mysql_escape_string($_POST['id_sottocategoria']) . "',";
  else $rigascat = "";

  if (isset($_POST['piu_venduto'])) $piuvenduto = 's';
  else $piuvenduto = 'n';
  if (isset($_POST['ultimo_arrivo'])) $ultimoarrivo = 's';
  else $ultimoarrivo = 'n';
  if (isset($_POST['offerta'])) $offerta = 's';
  else $offerta = 'n';

  $db->query("UPDATE
                bag_prodotti
              SET
                posizione='" . mysql_escape_string($_POST['posizione']) . "',
                nome_it='" . mysql_escape_string($_POST['nome_it']) . "',
                nome_en='" . mysql_escape_string($_POST['nome_en']) . "',    
                descrizione_it='" . mysql_escape_string($_POST['descrizione_it']) . "',
                descrizione_en='" . mysql_escape_string($_POST['descrizione_en']) . "',
                description_it='" . mysql_escape_string($_POST['description_it']) . "',
                description_en='" . mysql_escape_string($_POST['description_en']) . "',    
                codice='" . mysql_escape_string($_POST['codice']) . "',
                offerta='" . $offerta . "',
                ultimo_arrivo='" . $ultimoarrivo . "',
                piu_venduto='" . $piuvenduto . "', 
                prezzo='" . mysql_escape_string($prezzo) . "',
                sconto_rivenditore='" . mysql_escape_string($_POST['sconto_rivenditore']) . "',
                sconto_installatore='" . mysql_escape_string($_POST['sconto_installatore']) . "',
                quantita='" . mysql_escape_string($_POST['quantita']) . "',
                " . $rigascat . "
                id_marca='" . mysql_escape_string($_POST['id_marca']) . "',   
                " . $rigaimg . "
                scheda_tecnica='" . mysql_escape_string($_POST['scheda_tecnica']) . "'
                WHERE id='" . mysql_escape_string($_POST['id']) . "'
              ");

  if ($db->execute()) {

    if (isset($_POST['immagine']) and $_POST['immagine'] != '') {

      $db->query("UPDATE  
                  bag_image SET immagine='" . mysql_escape_string($_POST['immagine']) . "'
                  WHERE id_prodotto='" . $_POST['id'] . "' AND posizione=1
                 ");
      $db->execute();
    }

    if (isset($_POST['immagine_m']) and count($_POST['immagine_m']) > 0) {

      foreach ($_POST['immagine_m'] as $immagine) {

        $db->query("INSERT INTO  
                    bag_image(id_prodotto,immagine,posizione)
                    VALUES('" . $_POST['id'] . "','" . mysql_escape_string($immagine) . "',2)
                    ");
        $db->execute();
      }
    }

    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }

  $errore = mysql_error();
  $arr = array('campo' => '', 'errore' => $query);
  echo json_encode($arr);
  exit();
}

//********************************FINE  MODIFICA ARTICOLO************************************

//********************************  ELIMINA FILE ********************************************
if ($_POST['function'] == "elimina_file") {

  //Cancello immagine
  $db->query("SELECT immagine FROM bag_image
                     WHERE id= '" . $_POST['id_file'] . "' ");
  $nomefile = $db->single();

  $db->query("DELETE FROM bag_image
                     WHERE id= '" . $_POST['id_file'] . "' ");
  $db->execute();

  unlink(BASE_PATH_HOME . "upload/prodotti/" . $nomefile['immagine']);
}

//********************************FINE ELIMINA FILE ********************************************                                

//********************************ELIMINA FOTO SLIDER HOME**************************************

if ($_POST['function'] == 'eliminafotosliderhome') {

  //Cancello immagine
  $db->query("UPDATE slider_home
                     SET " . $_POST['titolo'] . " ='' ");
  $db->execute();
  unlink(BASE_PATH_HOME . "images/img_slider_home/" . $_POST['image']);
}

//********************************FINE ELIMINA FOTO SLIDER HOME*************************************

//********************************ELIMINA FOTO PRODOTTO********************************************

if ($_POST['function'] == 'eliminafotoprod') {

  //Cancello immagine
  $db->query("UPDATE bag_prodotti
                     SET " . $_POST['titolo'] . " ='' WHERE id='" . $_POST['idprod'] . "' ");
  $db->execute();
  unlink(BASE_PATH_HOME . "images/img_prod/" . $_POST['image']);
}

//********************************FINE ELIMINA FOTO PRODOTTO***********************************

//********************************ELIMINA SCHEDA********************************************

if ($_POST['function'] == 'eliminascheda') {

  //Cancello immagine
  $db->query("UPDATE bag_prodotti
                     SET " . $_POST['titolo'] . " ='' WHERE id='" . $_POST['idprod'] . "' ");
  $db->execute();
  unlink(BASE_PATH_HOME . "schede/" . $_POST['image']);
}

//********************************FINE ELIMINA FOTO PRODOTTO********************************************                                        

//********************************ELIMINA FOTO CATEGORIA********************************************

if ($_POST['function'] == 'eliminafotocat') {

  //Cancello immagine
  $db->query("UPDATE " . $_POST['tabella'] . "
                     SET immagine ='' WHERE id='" . $_POST['idprod'] . "' ");
  $db->execute();
  unlink(BASE_PATH_HOME . "images/categorie/" . $_POST['image']);
}

//********************************FINE ELIMINA FOTO PRODOTTO******************************************** 

//******************************** INSERISCI MACROCATEGORIA ********************************************
if ($_POST['function'] == "insmacro") {

  $errore = "no";

  $db->query("INSERT INTO  
  	           bag_macro (nome_it,nome_en,immagine,posizione)
  	           VALUES('" . mysql_escape_string($_POST['nome_it']) . "','" . mysql_escape_string($_POST['nome_en']) . "','" . mysql_escape_string($_POST['immagine']) . "'
                       ,'" . mysql_escape_string($_POST['posizione']) . "')
              ");

  if ($db->execute()) {

    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  } else {
    $nome = mysql_error();
    $errore = 'insrecord';
    $arr = array('campo' => $nome, 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }
}

//********************************FINE  INSERISCI  MACROCATEGORIA  ********************************************

//********************************  MODIFICA MACROCATEGORIA ********************************************
if ($_POST['function'] == "editmacro") {


  $errore = "no";

  if (isset($_POST['immagine'])) $mod_img = "  immagine='" . mysql_escape_string($_POST['immagine']) . "', ";
  else $mod_img = "";

  $db->query("UPDATE  
                 bag_macro 
              SET 
                 nome_it='" . mysql_escape_string($_POST['nome_it']) . "',
                 nome_en='" . mysql_escape_string($_POST['nome_en']) . "',
                 $mod_img
                 posizione='" . mysql_escape_string($_POST['posizione']) . "'
                 WHERE id = '" . mysql_escape_string($_POST['id']) . "' ");

  if ($db->execute()) {

    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  } else {
    $nome = mysql_error();
    $errore = 'editrecord';
    $arr = array('campo' => $nome, 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }
}

//********************************FINE  MODIFICA MACROCATEGORIA  ********************************************

//********************************  MODIFICA SOTTOCATEGORIA ********************************************
if ($_POST['function'] == "editscat") {

  $errore = "no";

  $db->query("UPDATE  
                bag_scat 
              SET 
                nome_it='" . mysql_escape_string($_POST['nome_it']) . "',
                nome_en='" . mysql_escape_string($_POST['nome_en']) . "',
                posizione='" . mysql_escape_string($_POST['posizione']) . "',
                immagine='" . mysql_escape_string($_POST['immagine']) . "',
                id_categoria='" . mysql_escape_string($_POST['id_categoria']) . "'
                WHERE id = '" . mysql_escape_string($_POST['id']) . "' ");

  if ($db->execute()) {
    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  } else {
    $nome = mysql_error();
    $errore = 'editrecord';
    $arr = array('campo' => $nome, 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }
}

//******************************** FINE MODIFICA SOTTOCATEGORIA ********************************************

//******************************** INSERISCI SOTTOCATEGORIA ********************************************
if ($_POST['function'] == "insscat") {

  $errore = "no";

  $db->query("INSERT INTO  
  	           bag_scat (nome_it,nome_en,immagine,posizione,id_categoria)
  	           VALUES('" . mysql_escape_string($_POST['nome_it']) . "','" . mysql_escape_string($_POST['nome_en']) . "','" . mysql_escape_string($_POST['immagine']) . "'
                       ,'" . mysql_escape_string($_POST['posizione']) . "','" . mysql_escape_string($_POST['id_categoria']) . "')
              ");

  if ($db->execute()) {
    $arr = array('campo' => '', 'errore' => $errore);
    echo json_encode($arr);
    exit();
  } else {
    $nome = mysql_error();
    $errore = 'insrecord';
    $arr = array('campo' => $nome, 'errore' => $errore);
    echo json_encode($arr);
    exit();
  }
}
//********************************FINE  INSERISCI  SOTTOCATEGORIA  ********************************************