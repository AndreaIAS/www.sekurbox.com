<?php 
include 'include/connessione.php';
include "include/lingua.php"; 
include 'include/leggi_immagine.inc.php';			
if ($lingua == "it")
{
$title = "";
$description = "";
$titolo = "Guida all'acquisto";
$h2 ="Come acquistare su www.sekurbox.com";
$testo = "
<p><strong>Introduzione</strong><br />
Acquistare i prodotti nel nostro negozio virtuale &egrave; divertente, facile e sicuro. Siamo aperti ventiquattro ore su ventiquattro senza chiusure domenicali o festive.
Grazie all'esperienza maturata negli anni siamo in grado di offrirvi il meglio della qualit&aacute; con speciali occasioni d'affare che potrete trovare solo nel nostro Internet Shop.<br /><br />
<strong>Come cercare un prodotto</strong><br />
Tutti i nostri prodotti sono elencati nella sezione &quot;Copricapo&quot; accompagnati da una scheda dettagliata che ne specifica le sue caratteristiche.<br /><br />
<strong>Una volta scelto il prodotto</strong><br />
Non appena avete trovato l'articolo desiderato digitate la quantit&agrave; e premete sul pulsante &quot;aggiungi al carrello&quot;. Il vostro carrello &egrave; situato in alto a destra con la 
dicitura &quot;articoli nel carrello Totale €&quot;. Per accedere al carrello potete farlo in due modi : 1) cliccando sulla voce &quot;Carrello&quot; oppure sulla voce &quot;Vai alla cassa&quot;. 
Cliccando sul carrello verrete accompagnati verso l'uscita virtuale costituita dalla cassa. A questo punto potete continuare lo shopping o procedere con il pagamento. Una volta arrivati alla cassa 
vi verranno richiesti il nome, l'indirizzo per la fatturazione ed il recapito per la consegna della merce, l'indirizzo e-mail e un numero di telefono necessario anche al nostro partner 
logistico per poter prendere accordi per la consegna.<br />
<strong>Metodi di pagamento</strong><br />
Per quanto riguarda i mezzi di pagamento, la scelta pu&ograve; essere effettuata nel campo modalit&agrave; di pagamento mediante:<br />
- Pagamenti con carta di credito (gratuito)<br /> 
- Contrassegno (€ 6.00)<br />
- Bonifico bancario (gratuito)<br />
- Bollettino postale (gratuito)<br />
<br />
Di seguito sono riportati gli estremi per effettuare il bonifico bancario dell'importo totale su:<br />
BANCA SELLA<br />
IBAN:  IT 79 I 03268 80110 052641727400<br />
Intestato a: IDM s.r.l.<br />
<br />
Si prega di inviare la contabile del bonifico via email all'indirizzo info@sekurbox.com<br />
Causale sekurbox_NUMERO_ORDINE
Da non dimenticare: il pagamento in contrassegno &egrave; accettato solo per ordini nell'ambito del territorio italiano. Gli ordini che arrivano dall'estero possono essere saldati mediante carta di credito o 
pagamento anticipato.<br />
</p>
<br />
<p>
<strong>Sicurezza dei dati e del pagamento con carta di credito</strong><br />
Tutte le informazioni riguardanti i nostri clienti  sono garantite secondo l'nformativa ai sensi del D. Lgs. 30 giugno 2003, n. 196 sulla tutela dei dati personali. I dati relativi alla vostra carta di credito non vengono gestiti dalla nostra azienda in quanto il sistema di pagamento verr&agrave; gestito in maniera sicura sul circuito Pay-pal. A chiusura della procedura d'ordine verr&agrave; visualizzata una scheda riepilogativa con indicati gli articoli da voi acquistati.<br /><br />
<strong>Spedizioni e Resi</strong><br />
Le spese di spedizione nel territorio italiano ammontano a 10,00 &euro;.<br />
La spedizione degli articoli avverr&agrave; nel primo giorno lavorativo seguente all'ordine per i prodotti disponibili in magazino.<br />
Vi preghiamo di prendere attenta visione delle nostre condizioni generali di vendita prima di procedere all'acquisto.
</p>                
";
}
else
{
$title = "";
$description = "";
$titolo = "Guida all'acquisto";
$h2 ="Come acquistare su www.sekurbox.com";
$testo = "                
";
} 
include 'include/head.php'; 
?>	
<head>
<body>
<div id="contenuto">
	<div id="contenuto2">
    	<div id="top">
			<?php include 'include/top.php'; ?>
        </div>
        <div id="testata">
			<?php include 'include/testata.php'; ?>
        </div>
		<div class="row_top">
        	<div id="titolo_pagina_sn">
                <div id="titolo_pagina">
                    <div id="stile_titolo_pagina"><?php echo $guida_acquisto;?></div>
                    <div id="briciole_di_pane"><a href="http://www.sekurbox.com/<?php echo $lingua; ?>/index.html">Home Page</a> / <?php echo $guida_acquisto;?></div>
                </div>
            </div>  
            <div id="titolo_pagina_ds">
				<?php include 'include/banner-promozionale.php'; ?>
           </div>           
       </div>      
		<div class="row">
        	<div id="colonna_sn">
                <ul class="menu_laterale_case">
                    <?php $pagina="guida_acquisto"; include 'include/menu-sn.php';?>      	
                </ul>            
            </div>
            <div id="colonna_ds">
                 <h2><?php echo $h2; ?></h2>
                 <?php echo $testo; ?>
            </div>
      </div>
        <div class="row">
			<?php include 'include/footer.php'; ?>
        </div>                 
    </div>
</div>
<div id="freccia_su">
	<a href="/#" class="scrolltotop"><img src="http://www.sekurbox.com/images/freccia_su.png" /></a>
</div> 
</body>
</html>      