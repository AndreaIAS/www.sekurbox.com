<?php 
include 'include/connessione.php';
include "include/lingua.php"; 		
include 'include/leggi_immagine.inc.php';	
if ($lingua == "it")
{
$title = "";
$description = "";
$titolo="Note legali";
$h2 ="Norme di utilizo del sito www.sekurbox.com";
$testo = "<strong>Norme di comportamento per gli utenti:</strong> le seguenti regole riguardano qualsiasi tipo di contenuto generato dall'utente utilizzando i servizi messi a disposizione dal sito.<br />
&Egrave; proibito inviare, distribuire e in ogni modo pubblicare negli spazi abilitati a tale scopo contenuti che presentino rilievi di carattere diffamatorio, calunniatorio, osceno, pornografico, abusivo, e a qualsiasi titolo illegale. Non &egrave; possibile inoltre, utilizzare il sito www.sekurbox.com e i suoi servizi annessi a scopo di frode o per ottenere informazioni sull'account o la password dell'utente.<br /><br />
&Egrave; proibito pubblicare informazioni riservate che consentono di identificare personalmente dati personali dell'utente stesso, compresi fra l'altro i numeri delle carte di credito. &Egrave; proibito pubblicare informazioni quali la password, i nomi utente, i numeri di telefono, gli indirizzi email di altri utenti, a meno che non siano accessibili al pubblico sul web.<br /> &Egrave; proibito utilizzare i commenti per fini commerciali.<br /><br /> 
&Egrave; fatto obbligo per ogni utente di non assumere atteggiamenti violenti o ad aggredire verbalmente gli altri utenti, astenendosi dall'utilizzo di termini calunniosi, e a non interrompere intenzionalmente le discussioni con messaggi ripetitivi, con messaggi privi di significato o con azioni finalizzate alla vendita di prodotti o servizi. Si impegna altres&igrave; a non utilizzare termini violenti o che discriminino sulla base della razza, religione, genere, inclinazioni sessuali, disabilit&agrave; fisiche o mentali e altro. L'uso di linguaggio violento sar&agrave; motivo per la sospensione immediata e per l'espulsione definitiva a tutti o a parte dei servizi del sito <a href='http://www.sekurbox.com'>www.sekurbox.com</a>.<br /><br />
Noi di sekurbox incoraggiamo e promuoviamo le discussioni animate e accogliamo con piacere i dibattiti accesi negli spazi preordinati a tale scopo. Ogni attacco individuale sar&agrave; interpretato come una violazione diretta di queste norme di comportamento e giustificher&agrave; l'immediata e definitiva espulsione da tutti o da alcuni dei servizi del sito.<br /><br />
 
<strong>Invio del materiale da parte dei lettori:</strong> ogni  lettore &egrave; responsabile a titolo individuale per i contenuti dei propri messaggi. Il Proprietario del sito, se non &egrave; in grado di assicurare un controllo puntuale su ognuno dei messaggi ricevuti e non risponde quindi del loro contenuto, in ogni caso si riserva il diritto di cancellare, spostare, modificare i messaggi, che a suo discrezionale giudizio, appaiono abusivi, diffamatori, osceni o lesivi del diritto d'autore e dei marchi e in ogni caso inaccettabili per la filosofia del sito.<br /><br />
L'utente consente la pubblicazione sul sito del materiale inviato ed il suo utilizzo da parte del Proprietario anche per propri fini promozionali.<br />
Il materiale inviato non verr&agrave; restituito e rimarr&agrave; di propriet&agrave; di sekurbox che rimane dunque esentato da ogni responsabilit&agrave; nei confronti dei partecipanti per la perdita o distruzione del materiale inviato.<br /> 
Ogni lettore prende visione e accetta che il materiale inviato per la partecipazione ai servizi del sito (a solo titolo esemplificativo e non esaustivo: commenti, esprimere opinioni, partecipare a sondaggi ed iniziative, inviare immagini o file video e audio) pu&ograve; essere modificato, rimosso, modificato, pubblicato, trasmesso, ed eseguito da sekurbox.<br /><br />
 L'utente rinuncia pertanto a ogni diritto materiale e morale che possa vantare come autore rispetto alle modifiche apportate a tale materiale, anche nel caso in cui le modifiche non siano gradite o accettate dall'autore stesso. L'utente concede al proprietario del sito www.sekurbox.com un diritto illimitato di uso non esclusivo, senza limitazioni di aree geografiche. Il proprietario del sito potr&agrave; pertanto, direttamente o tramite terzi di sua fiducia, utilizzare, copiare, trasmettere, estrarre, pubblicare, distribuire, eseguire pubblicamente, diffondere, creare opere derivate, ospitare, indicizzare, memorizzare, annotare, codificare, modificare ed adattare (includendo senza limitazioni il diritto di adattare per la trasmissione con qualsiasi modalit&agrave; di comunicazione) in qualsiasi forma o con qualsiasi strumento attualmente conosciuto o che verr&agrave; in futuro inventato, ogni immagine e ogni messaggio, anche audio e video, che dovesse essere inviato dal lettore, anche per il tramite di terzi.";
}
else
{
$title = "";
$description = "";
$titolo="Note legali";
$h2 ="Norme di utilizo del sito www.sekurbox.com";
$testo = "";
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
                    <div id="stile_titolo_pagina"><?php echo $note_legali;?></div>
                    <div id="briciole_di_pane"><a href="http://www.sekurbox.com/<?php echo $lingua; ?>/index.html">Home Page</a> / <?php echo $note_legali;?></div>
                </div>
            </div>  
            <div id="titolo_pagina_ds">
				<?php include 'include/banner-promozionale.php'; ?>
           </div>           
       </div>      
		<div class="row">
        	<div id="colonna_sn">
                <ul class="menu_laterale_case">
                    <?php $pagina="note_legali"; include 'include/menu-sn.php';?>      	
                </ul>            
            </div>
            <div id="colonna_ds">
                 <h2><?php echo $h2;?></h2>
                 <p><?php echo $testo;?></p> 
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