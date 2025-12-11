<?php
include("inc_config.php");

if(!isset($_SESSION['user'])){header("Location: ".BASE_URL."registrati.php");}
//if(!isset($_POST['metodosped'])){header("Location: ".BASE_URL."index.php");}


if(isset($_SESSION['metodopag'])){


           if(isset($_SESSION['nome2'])){

                                  $nomesped=$_SESSION['nome2'];
                                  $cognomesped=$_SESSION['cognome2'];
                                  $indirsped=$_SESSION['indirizzo2'];
                                  $cittasped=$_SESSION['citta2'];
                                  $provsped=$_SESSION['provincia2'];
                                  $capsped=  $_SESSION['cap2'];
                                  $emailsped=  $_SESSION['email2'];
                                  $telsped=  $_SESSION['telefono2'];
                                  $cellsped= $_SESSION['cellulare2'];

                             }
                             else {

                                  $nomesped='';
                                  $cognomesped='';
                                  $indirsped='';
                                  $cittasped='';
                                  $provsped='';
                                  $capsped='';
                                  $emailsped='';
                                  $telsped='';
                                  $cellsped='';


                             }


             $db->query("INSERT INTO
                         bag_ordini (id_utente,tipo_pagam,tipo_spedi,
                         note,data,totale,spese_spe,spese_pag,nome,cognome,indirizzo,citta,cap,
                         provincia,pagato,spedito,email,telefono,cellulare)
                         VALUES('".mysql_escape_string($_SESSION['user'])."','".mysql_escape_string($_SESSION['metodopag'])."','".mysql_escape_string($_SESSION['metodosped'])."',
                         '".mysql_escape_string($_POST['note'])."',NOW(),'".mysql_escape_string($_POST['totale'])."','".mysql_escape_string($_POST['spesesped'])."',
                         '".mysql_escape_string($_POST['spesepag'])."','".mysql_escape_string($nomesped)."','".mysql_escape_string($cognomesped)."',
                         '".mysql_escape_string($indirsped)."','".mysql_escape_string($cittasped)."','".mysql_escape_string($capsped)."','".mysql_escape_string($provsped)."','n','n',
                         '".mysql_escape_string($emailsped)."','".mysql_escape_string($telsped)."','".mysql_escape_string($cellsped)."'
                         )");

             $db->execute();

             $idord=$db->lastInsertId();


       $testo_email= "<span style='color:#1e6ec3;font-family:Arial,sans-serif;font-size:15px;'>";
          $testo_email.= "<span style='color:#000000;'>Gentile cliente,<br />la ringraziamo per aver acquistato sul nostro sito <br /> e la informiamo che abbiamo ricevuto
              il suo ordine.</span><br /><br />

     <b>Dettaglio ordine numero ".$idord.":</b> <br /><br />";


      foreach($cart->get_contents() as $item){

                          $totaleart=$totaleart+($item['price']*$item['qty']);

                          $testo_email.= "Articolo: ".$item['info']['nome'] ." - Quantità: ".$item['qty']." - Costo: ".number_format($item['price']*$item['qty'],2,',','.')." &euro;<br />";

                          $db->query("INSERT INTO
                                      bag_det_ord (id_articolo,qta,prezzo,id_ordine,taglia,colore)
                                      VALUES('".mysql_escape_string($item['iddb'])."','".mysql_escape_string($item['qty'])."',
                                             '".mysql_escape_string($item['price'])."','".mysql_escape_string($idord)."' ,'".mysql_escape_string($item['info']['taglia'])."','".mysql_escape_string($item['info']['colore'])."'
                                     )");

                           $db->execute();
                                             }
      $iva=($totaleart/100)*22;
      $testo_email.= "<br />Totale articoli: ".number_format($totaleart,2,',','.') ." &euro;<br />";
      $testo_email.= "Totale iva: ".number_format($iva ,2,',','.')." &euro;<br />";
      $testo_email.= "<br />Metodo di spedizione: ".$_SESSION['nomesped'] ." - Costo: ".number_format($_SESSION['costosped'],2,',','.')." &euro;<br />";
      $testo_email.= "Metodo di pagamento: ".$_SESSION['nomepag'] ." - Costo: ".number_format($_SESSION['costopag'],2,',','.')." &euro;<br />";

      $testo_email.= "<br /><b>Totale ordine:</b> ".number_format($totaleart+$iva+$_SESSION['costosped']+$_SESSION['costopag'],2,',','.') ." &euro;<br />";

      if(trim($_POST['note'])!=''){ $testo_email.= "<br /><b>Note ordine:</b> ".$_POST['note'] ." <br />";   }


      if($_SESSION['metodopag']==3){

                                                    $testo_email.= "<br />
                                                    <span style='color:#000000'>
                                                    I dati per effettuare il bonifico bancario sono:<br />
                                                    ".$array_dati_pag[$_SESSION['metodopag']]."
                                                    </span>";

                                    } else if($_SESSION['metodopag']==2){

                                        $testo_email.= "<br />
                                                    <span style='color:#000000'>
                                                    Se non hai ancora pagato l'ordine puoi pagare con carta di credito cliccando
                                                    <a href='".BASE_URL."pagacarta.php?ord=".$idord."'>qui</a>:<br />
                                                    </span>";
                                    }

                                    else if($_SESSION['metodopag']==4){

                                        $testo_email.= "<br />
                                                    <span style='color:#000000'>
                                                    Se non hai ancora pagato l'ordine puoi pagare con paypal cliccando
                                                    <a href='".BASE_URL."pagapaypal.php?ord=".$idord."'>qui</a>:<br />
                                                    </span>";
                                    }


         $testo_email.= "<br />Spediremo appena riceveremo il pagamento.";

          $testo_email.= "<br /><br /><br />
          <div style='font-size:13px;width:200px;float:left;'>
          Sito Internet: <a style='color: #19a9e5;' href='http://www.gevenit.com'>Gevenit.com</a><br />
          Email: <a style='color: #19a9e5;' href='mailto:gevenit@gevenit.com'>gevenit@gevenit.com</a><br />
          </div>
          </span><br /><br /><br />";

/*
         $mail = new phpmailer();
         $mail->IsHTML(true);
         $mail->CharSet = 'UTF-8';
         $mail->From = EMAIL_ADM;
         $mail->FromName = EMAIL_ADM_NAME;
         $mail->AddAddress(mysql_escape_string($_SESSION['email']));
         $mail->AddBCC(EMAIL_ADM);
         $mail->Subject = EMAIL_ADM_NAME." - Ordine num: ".$idord.". ";
         $mail->Body = $testo_email;
         if (!$mail->Send()) {} */
     $bool_result = sendMail(mysql_escape_string($_SESSION['email']), EMAIL_ADM_NAME." - Ordine num: ".$idord.". ", $testo_email, "TESTO ALTERNATIVO" );
     $bool_result = sendMail(EMAIL_ADM, EMAIL_ADM_NAME." - Ordine num: ".$idord.". ", $testo_email, "TESTO ALTERNATIVO" );
     $bool_result = sendMail('multimedia@gieffecomunicazione.com', EMAIL_ADM_NAME." - Ordine num: ".$idord.". ", $testo_email, "TESTO ALTERNATIVO" );

} else { header("Location: ".BASE_URL."carrello.php"); }

include("inc_header.php");
?>

</head>
<body class="bg-body boxed">

<?php
    include("inc_menu.php");
?>

		<!-- BREAKCRUMB -->
		<section class="breakcrumb bg-grey">
			<div class="container">
				<h3 class="pull-left">Conferma ordine </h3>
				<ul class="nav-breakcrumb  pull-right">
					<li><a href="index.php">Home</a></li>
					<li><span>Conferma ordine</span></li>
				</ul>

			</div>
		</section>
		<!-- END BREAKCRUMB -->

		<!-- CHECK OUT -->
		<section class="check-out">
			<div class="container">
				<div class="check-out-cn">

					<!-- STEP CHECK OUT -->
					<ul class="check-out-step text-uppercase ">
						<li data-step="1" ><span>Dati di fatturazione</span></li>
						<li data-step="2" ><span>Dati di spedizione</span></li>
						<li data-step="3" ><span>Metodo di spedizione</span></li>
						<li data-step="4" ><span>Metodo di pagamento</span></li>
						<li data-step="5"><span>Riassunto ordine</span></li>
						<li data-step="6" class="current"><span>Conferma Ordine</span></li>
					</ul>
					<!-- END STEP CHECK OUT -->

					<!-- CHECK OUT FORM -->
                                        <div class="form check-out-form" style="padding-top:15px;">



                                            <div class="row" >
                                                   <div class="col-xs-12">
                                                        <label><b style="font-size:20px;">Conferma ordine numero <?=$idord;?></b></label>
					            </div>
                                                    <br /><br /><br />
                                                    <div class="col-xs-12" style="color:green;">

                                                        La ringraziamo per aver ordinato su Gevenit.com. <br />
                                                        Il suo ordine è stato registrato correttamente.  <br />
                                                        Spediremo non appena verificheremo il pagamento. <br />
                                                        Può sempre monitorare lo stato dei suo ordini da
                                                        <a href="<?=BASE_URL;?>ordini.php" target="_blank" style="color:blue;">questa pagina.</a>

                                                    <?php if($_SESSION['metodopag']==3){ ?>

                                                    <br /><br />
                                                    <span style="color:#000000">
                                                    I dati per effettuare il bonifico bancario sono:<br />
                                                    <?=$array_dati_pag[$_SESSION['metodopag']];?>
                                                    </span>

                                                   <?php  }
                                                    else if($_SESSION['metodopag']==2){

                                                    $importo=$_POST['totale']*100;

                                                    $mac="";
                                                    $mac=md5('URLMS=http://www.gevenit.com/chiudi_servercredem.php&URLDONE=http://www.gevenit.com/esitopagamentocredem.php&NUMORD='.$idord.'&IDNEGOZIO=129280303200680&IMPORTO='.$importo.'&VALUTA=978&TCONTAB=I&TAUTOR=I&OPTIONS=G&aWXY9Z-9FuC-87pP6N-FwL-vwK6twbPsGKHVfZ9cnxXvfec7-Y');

                                                   ?>

                                                        <div style="clear:both"></div>
                                                        <br /><br />
                                                        <form action="https://atpos.ssb.it/atpos/pagamenti/main" method="POST">
                                                        <input type="hidden" name="PAGE" value="MASTER">
                                                        <input type="hidden" name="IMPORTO" value="<?=$importo;?>">
                                                        <input type="hidden" name="VALUTA" value="978">
                                                        <input type="hidden" name="LINGUA" value="ITA">
                                                        <input type="hidden" name="IDNEGOZIO" value="129280303200680">
                                                        <input type="hidden" name="NUMORD" value="<?=$idord;?>">
                                                        <input type="hidden" name="URLDONE" value="http://www.gevenit.com/esitopagamentocredem.php">
                                                        <input type="hidden" name="URLBACK" value="http://www.gevenit.com/esitopagamentocredem.php">
                                                        <input type="hidden" name="URLMS" value="http://www.gevenit.com/chiudi_servercredem.php">
                                                        <input type="hidden" name="TCONTAB" value="I">
                                                        <input type="hidden" name="TAUTOR" value="I">
                                                        <input type="hidden" name="OPTIONS" value="G">
<!--                                                    <input type="hidden" name="EMAIL" value="prova@demo.net">
                                                        <input type="hidden" name="EMAILESERC" value="prova2@demo.net">-->
                                                        <input type="hidden" name="MAC" value="<?=$mac;?>">
                                                        <input type="image" src="<?=BASE_URL;?>images/carte.jpg" >
                                                        </form>


                                                    <?php } else if($_SESSION['metodopag']==4){


                                                   ?>
                                                        <div style="clear:both"></div>
                                                        <br /><br />
                                                        <form  action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" >
                                                        <input type="hidden" name="email" value="<?=$_SESSION['email'];?>" />
                                                        <input type="hidden" name="business" value="EQ9NXAXQ37LGS" />
                                                        <input type="hidden" name="receiver_email" value="gevenit@gevenit.com" />
                                                        <input type="hidden" name="item_name" value="Pagamento ordine n. <?=$idord;?>" />
                                                        <input type="hidden" name="item_number" value="<?=$idord;?>" />
                                                        <input type="hidden" name="amount" value="<?=$_POST['totale'];?>" />
                                                        <input type="hidden" name="quantity" value="1" />
                                                        <input type="hidden" name="currency_code" value="EUR" />
                                                        <input type="hidden" name="return" value="http://www.gevenit.com/esitopagamentopaypal.php?idordine=<?=$idord;?>" />
                                                        <input type="hidden" name="cancel_return" value="<?=BASE_URL;?>index.php" />
                                                        <input type="hidden" name="notify_url" value="http://www.gevenit.com/paypal.php" />
                                                        <input type="hidden" name="no_shipping" value="1" />
                                                        <input type="hidden" name="no_note" value="1" />
                                                        <input type="hidden" name="cmd" value="_xclick">
                                                        <input type="image" src="<?=BASE_URL;?>images/paypal.jpg" border="0" name="submit" alt="PayPal è il metodo rapido e sicuro per pagare e farsi pagare online.">

                                                        </form>





                                                    <?php } ?>

					            </div>

                                                    <div class="col-xs-12" style="margin-top:20px;">
                                                            <a href="<?=BASE_URL;?>ordini.php" class="btn btn-13 text-uppercase pull-right">I miei ordini</a>
                                                    </div>
						</div>


					</div>
					<!-- END CHECK OUT FORM -->

				</div>
			</div>
		</section>
		<!-- END CHECK OUT -->



<?php

$cart->empty_cart();

unset($_SESSION['metodosped']);
unset($_SESSION['nomesped']);
unset($_SESSION['costosped']);
unset($_SESSION['metodopag']);
unset($_SESSION['nomepag']);
unset($_SESSION['costopag']);

include("inc_footer.php");
?>
