<?php

include("inc_config.php");

$title_it = "Sekurbox.com | Account.";
$description_it = "Accedi al nostro sito e scopri tutti i vantaggi. Se non hai ancora un account, registrati compilando i campi del form di registrazione.";


$title_en = "Sekurbox.com | Account.";
$description_en = "Access our website and discover all the advantages. If you do not have an account yet, register by filling in the registration form fields.";

include("inc_header.php");
?>

<meta name="robots" content="noindex">
</head>

<body>
    <div class="wrapper-area">

        <?php
        include("inc_menu.php");
        ?>
        <!-- Inner Page Banner Area Start Here -->
        <div class="inner-page-banner-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcrumb-area">
                            <h1><?= $lang['account']; ?></h1>
                            <ul>
                                <li><a href="<?= BASE_URL . $lng; ?>/">Home</a> /</li>
                                <li>Account</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Inner Page Banner Area End Here -->
        <!-- Login Registration Page Area Start Here -->
        <div class="login-registration-page-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="login-registration-field">

                            <?php if (!isset($_SESSION['user_site'])) { ?>

                                <h2 class="cart-area-title">Login</h2>
                                <div id="errmesslogin"></div>
                                <form id="form_login" action="javascript:void(null)" method="post">
                                    <input type="hidden" name="function" value="login">
                                    <label>EMAIL *</label>
                                    <input type="email" name="email" required placeholder="E-mail" />
                                    <label>Password *</label>
                                    <input type="password" placeholder="Password" name="password" required />
                                    <label class="check"><a href="<?= BASE_URL; ?>recuperapwd.php"><?= $lang['forgot_pwd']; ?></a></label>
                                    <button class="btn-send-message disabled" type="submit" value="Login">Login</button>
                                    <!--                                <span><input type="checkbox" name="remember"/>Remember Me</span>-->
                                </form>
                            <?php } else { ?>

                                <h2 class="cart-area-title"><?= $lang['benvenuto']; ?> <?= $_SESSION['nome']; ?></h2>

                                <div class="form login ">
                                    - <a href="<?= BASE_URL; ?>modificadati.php">Modifica dati personali</a> <br />
                                    - <a href="<?= BASE_URL; ?>change_pwd.php">Modifica password</a> <br />
                                    - <a href="<?= BASE_URL; ?>ordini.php">I tuoi ordini</a> <br />
                                    - <a href="<?= BASE_URL; ?>index.php?logout">Logout</a> <br />
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                        <?php if (!isset($_SESSION['user_site'])) { ?>

                            <div class="login-registration-field">
                                <h2 class="cart-area-title"><?= $lang['registrazione']; ?></h2>

                                <form id="checkout-form" action="javascript:void(null)" method="post">

                                    <input type="hidden" name="function" value="registrati">

                                    <div class="cart-collaterals" style="margin-bottom:10px;">
                                        <label>Tipologia <sup>*</sup></label>
                                        <select name="tipologia" id="tipologia" class="">
                                            <option value="privato" selected="selected">Privato</option>
                                            <option value="installatore">Installatore</option>
                                            <option value="rivenditore">Rivenditore</option>
                                        </select>
                                    </div>

                                    <label><?= $lang['nome']; ?> <sup>*</sup></label>
                                    <input type="text" name="nome" class="input-text" required>

                                    <label><?= $lang['cognome']; ?> <sup>*</sup></label>
                                    <input type="text" name="cognome" id="cognome" class="input-text" required>

                                    <label>Email <sup>*</sup></label>
                                    <input type="email" class="input-text" name="email" required>

                                    <label>Password<sup>*</sup></label>
                                    <input type="password" name="password" id="password2" class="input-text" required>

                                    <label><?= $lang['conf_pwd']; ?><sup>*</sup></label>
                                    <input type="password" name="confpass" class="input-text" data-equal-id="password2" required>

                                    <div id="divragsoc" class="cart-collaterals" style="display:none">
                                        <label><span id="ragsoc"><?= $lang['ragione']; ?></span>
                                            <sup>*</sup></label>
                                        <input type="text" class="input-text" id="ragione" name="ragione">
                                    </div>
                                    <div id="divpiva" style="display:none">
                                        <label><?= $lang['piva']; ?><sup>*</sup></label>
                                        <input type="text" name="p_iva" id="p_iva" class="input-text">
                                    </div>

                                    <div id="divcodfisc">
                                        <label><?= $lang['cod_fisca']; ?><sup>*</sup></label>
                                        <input type="text" name="cod_fiscale" id="cod_fiscale" class="input-text">
                                    </div>

                                    <div class="cart-collaterals">
                                        <label><?= $lang['nazione']; ?><sup>*</sup></label>
                                        <select name="id_nazione" required id="id_nazione" class="select2">
                                            <option value=""><?= $lang['select_nazione']; ?></option>
                                            <?php

                                            $db->query("SELECT *
                                            FROM  
                                            nazioni
                                            ORDER by id
                                           ");
                                            $recordr = $db->resultset();
                                            foreach ($recordr as $list) {
                                            ?>
                                                <option value="<?= $list['id']; ?>" <?php if ($list['id'] == '106') echo "selected='selected'"; ?>><?= $list['nome_' . $lng]; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group" style="margin-top:10px;" id="div_reg">
                                        <label class="control-label" for="id_regione"><?= $lang['regione']; ?></label>
                                        <div class="cart-collaterals">

                                            <select name="id_regione" required class="select2" id="id_regione"
                                                onchange="jQuery('#provincia').load('functionload.php #data',{function:'provincereg',id_regione:jQuery(this).val()},
                                                  function(){$('.select2').select2({
                                                        theme: 'classic',
                                                        dropdownAutoWidth: true,
                                                        width: '100%'
                                             });});">
                                                <option value=""><?= $lang['select_regione']; ?></option>
                                                <?php
                                                $db->query("SELECT *
                                            FROM  
                                            regioni
                                            ORDER by nome
                                           ");
                                                $recordr = $db->resultset();
                                                foreach ($recordr as $list) {
                                                ?>
                                                    <option value="<?= $list['id']; ?>"><?= $list['nome']; ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div id="provincia"></div>
                                    <div id="comune"></div>

                                    <label><?= $lang['indirizzo']; ?> <sup>*</sup></label>
                                    <input type="text" class="input-text" name="indirizzo" required>

                                    <label><?= $lang['cap']; ?><sup>*</sup></label>
                                    <input type="text" name="cap" class="input-text" required>

                                    <label><?= $lang['telefono']; ?>*</label>
                                    <input type="text" name="telefono" class="input-text" required>

                                    <label><?= $lang['cellp']; ?></label>
                                    <input type="text" name="cellulare" class="input-text">

                                    <label><?= $lang['inf_privacy']; ?>:</label>
                                    <textarea class="input-text" style="text-align: left;height: 150px;font-size:11px;width:100%;">
Privacy Policy di sekurbox.com

ALLEGATO A - SCHEMA DI INFORMATIVA
Oggetto: Informativa ai sensi dell’art. 13 del D. Lgs. 196/2003 e dell’articolo 13 del Regolamento UE n. 2016/679
Ai sensi dell’art. 13 del D. Lgs. 196/2003 (di seguito “Codice Privacy”) e dell’art. 13 del Regolamento UE n. 2016/679 (di seguito “GDPR 2016/679”), recante disposizioni a tutela delle persone e di altri soggetti rispetto al trattamento dei dati personali, desideriamo informarLa che i dati personali da Lei forniti formeranno oggetto di trattamento nel rispetto della normativa sopra richiamata e degli obblighi di riservatezza.

Titolare del trattamento
Il Titolare del trattamento è Alicino Stefano domiciliato in via s.antonio 62/a

Responsabile della protezione dei dati (DPO)
Il responsabile della protezione dei dati (DPO) è è Alicino Stefano domiciliato in via s.antonio 62/a

Modalità di trattamento e conservazione
Il trattamento sarà svolto in forma automatizzata e/o manuale, nel rispetto di quanto previsto dall’art. 32 del GDPR 2016/679 e dall’Allegato B del D.Lgs. 196/2003 (artt. 33-36 del Codice) in materia di misure di sicurezza, ad opera di soggetti appositamente incaricati e in ottemperanza a quanto previsto dagli art. 29 GDPR 2016/ 679.
Le segnaliamo che, nel rispetto dei principi di liceità, limitazione delle finalità e minimizzazione dei dati, ai sensi dell’art. 5 GDPR 2016/679, previo il Suo consenso libero ed esplicito espresso in calce alla presente informativa, i Suoi dati personali saranno conservati per il periodo di tempo necessario per il conseguimento delle finalità per le quali sono raccolti e trattati.

Ambito di comunicazione e diffusione
Informiamo inoltre che i dati raccolti non saranno mai diffusi e non saranno oggetto di comunicazione senza Suo esplicito consenso, salvo le comunicazioni necessarie che possono comportare il trasferimento di dati ad enti pubblici, a consulenti o ad altri soggetti per l’adempimento degli obblighi di legge.

Trasferimento dei dati personali
I suoi dati non saranno trasferiti né in Stati membri dell’Unione Europea né in Paesi terzi non appartenenti all’Unione Europea.

Categorie particolari di dati personali
Ai sensi degli articoli 26 e 27 del D.Lgs. 196/2003 e degli articoli 9 e 10 del Regolamento UE n. 2016/679, Lei potrebbe conferire, al COA dati qualificabili come “categorie particolari di dati personali” e cioè quei dati che rivelano “l'origine razziale o etnica, le opinioni politiche, le convinzioni religiose o filosofiche, o l'appartenenza sindacale, nonché dati genetici,
dati biometrici intesi a identificare in modo univoco una persona fisica, dati relativi alla salute o alla vita sessuale o all’orientamento sessuale della persona”. Tali categorie di dati potranno essere trattate dal COA solo previo Suo libero ed esplicito consenso, manifestato in forma scritta in calce alla presente informativa.

Esistenza di un processo decisionale automatizzato, compresa la profilazione
Il COA non adotta alcun processo decisionale automatizzato, compresa la profilazione, di cui all’articolo 22, paragrafi 1 e 4, del Regolamento UE n. 679/2016.

Diritti dell’interessato

In ogni momento, Lei potrà esercitare, ai sensi dell’art. 7 del D.Lgs. 196/2003 e degli articoli dal 15 al 22 del Regolamento UE n. 2016/679, il diritto di:
a) chiedere la conferma dell’esistenza o meno di propri dati personali;
b) ottenere le indicazioni circa le finalità del trattamento, le categorie dei dati personali, i destinatari o le categorie di destinatari a cui i dati personali sono stati o saranno comunicati e, quando possibile, il periodo di conservazione;
c) ottenere la rettifica e la cancellazione dei dati;
d) ottenere la limitazione del trattamento;
e) ottenere la portabilità dei dati, ossia riceverli da un titolare del trattamento, in un formato strutturato, di uso comune e leggibile da dispositivo automatico, e trasmetterli ad un altro titolare del trattamento senza impedimenti;
f) opporsi al trattamento in qualsiasi momento ed anche nel caso di trattamento per finalità di marketing diretto;
g) opporsi ad un processo decisionale automatizzato relativo alle persone ﬁsiche, compresa la profilazione.
h) chiedere al titolare del trattamento l’accesso ai dati personali e la rettifica o la cancellazione degli stessi o la limitazione del trattamento che lo riguardano o di opporsi al loro trattamento, oltre al diritto alla portabilità dei dati;
i) revocare il consenso in qualsiasi momento senza pregiudicare la liceità del trattamento basata sul consenso prestato prima della revoca;
j) proporre reclamo a un’autorità di controllo.



Tipologie di Dati raccolti

Fra i Dati Personali raccolti da questo Sito, in modo autonomo o tramite terze parti, ci sono: Cookie, Dati di utilizzo, Email e Nome.
Altri Dati Personali raccolti potrebbero essere indicati in altre sezioni di questa privacy policy o mediante testi informativi visualizzati contestualmente alla raccolta dei Dati stessi.
I Dati Personali possono essere inseriti volontariamente dall’Utente, oppure raccolti in modo automatico durante l’uso di questo Sito.
L’eventuale utilizzo di Cookie – o di altri strumenti di tracciamento – da parte di questo Sito o dei titolari dei servizi terzi utilizzati da questo Sito, ove non diversamente precisato, ha la finalità di identificare l’Utente e registrare le relative preferenze per finalità strettamente legate all’erogazione del servizio richiesto dall’Utente.
Il mancato conferimento da parte dell’Utente di alcuni Dati Personali potrebbe impedire a questo Sito di erogare i propri servizi.
L’Utente si assume la responsabilità dei Dati Personali di terzi pubblicati o condivisi mediante questo Sito e garantisce di avere il diritto di comunicarli o diffonderli, liberando il Titolare da qualsiasi responsabilità verso terzi.
                                                       </textarea>

                                    <input type="checkbox" name="privacy" required style="width:5%;margin:0px;height:12px;">
                                    Ho preso visione ed accetto l'informativa sulla privacy.
                                    <br /><br />


                                    <button class="btn-send-message disabled" type="submit" value="Login"><?= $lang['registrazione']; ?></button>
                                </form>
                                <div id="errmess"></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Login Registration Page Area End Here -->
        <!-- Footer Area Start Here -->
        <?php
        include("inc_footer.php");
        ?>

    </div>
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->

    <!-- Bootstrap js -->
    <script src="<?= BASE_URL; ?>js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Owl Cauosel JS -->
    <script src="<?= BASE_URL; ?>js/owl.carousel.min.js" type="text/javascript"></script>
    <!-- Meanmenu Js -->
    <script src="<?= BASE_URL; ?>js/jquery.meanmenu.min.js" type="text/javascript"></script>
    <!-- WOW JS -->
    <script src="<?= BASE_URL; ?>js/wow.min.js" type="text/javascript"></script>
    <!-- Plugins js -->
    <script src="<?= BASE_URL; ?>js/plugins.js" type="text/javascript"></script>
    <!-- Countdown js -->
    <script src="<?= BASE_URL; ?>js/jquery.countdown.min.js" type="text/javascript"></script>
    <!-- Srollup js -->
    <script src="<?= BASE_URL; ?>js/jquery.scrollUp.min.js" type="text/javascript"></script>
    <!-- Select2 Js -->
    <script src="<?= BASE_URL; ?>js/select2.min.js" type="text/javascript"></script>
    <!-- Custom Js -->
    <script src="<?= BASE_URL; ?>js/main.js" type="text/javascript"></script>

    <?php include("script_condivisi.php"); ?>


    <script>
        $(document).ready(function() {

            $('[data-equal-id]').bind('input', function() {
                var to_confirm = $(this);
                var to_equal = $('#' + to_confirm.data('equalId'));

                if (to_confirm.val() != to_equal.val())
                    this.setCustomValidity('Le due password devono essere uguali');
                else
                    this.setCustomValidity('');
            });

            $("#tipologia").change(function() {

                if ($('#tipologia option:selected').val() == 'privato') {
                    $('#divragsoc').fadeOut();
                    $('#ragione').prop('required', false);
                    $('#divpiva').fadeOut();
                    $('#p_iva').prop('required', false);
                    $('#divcodfisc').fadeIn();
                    $('#cod_fiscale').prop('required', true);
                } else {
                    $('#ragsoc').fadeIn();
                    $('#divragsoc').fadeIn();
                    $('#ragione').prop('required', true);
                    $('#divcodfisc').fadeOut();
                    $('#cod_fiscale').prop('required', false);
                    $('#divpiva').fadeIn();
                    $('#p_iva').prop('required', true);
                }
            });

            $("#id_nazione").change(function() {

                if ($('#id_nazione option:selected').val() == 106) {
                    $('#div_reg').fadeIn();
                    $('#id_regione').prop('required', true);
                    $('#div_prov').fadeIn();
                    $('#id_provincia').prop('required', true);
                    $('#div_com').fadeIn();
                    $('#id_comune').prop('required', true);
                } else {
                    $('#div_reg').fadeOut();
                    $('#id_regione').prop('required', false);
                    $('#div_prov').fadeOut();
                    $('#id_provincia').prop('required', false);
                    $('#div_com').fadeOut();
                    $('#id_comune').prop('required', false);
                }
            });


            $("#checkout-form").submit(function() {

                $.post("<?= BASE_URL; ?>functionload.php", jQuery("#checkout-form").serialize(),
                    function(data) {
                        //Se ci sono errori in fase di registrazione 
                        if (data.errore != 'no') {
                            if (data.campo == "email") {
                                $('#errmess').html('<span style="color:red;">Attenzione email già presente. Inserire un indirizzo email diverso.</span>');
                            } else {
                                $('#errmess').html('<span style="color:red;">Errore in invio mail di registrazione</span>');
                            }
                        } else {
                            // alert(data.campo);
                            $('#checkout-form').fadeOut();
                            $('#errmess').html('<span style="color:green;margin-left:0px;">Registrazione effettuata correttamente.<br />Attiva il tuo account, dalla mail che ti abbiamo inviato.<br />\n\
            Controlla anche la cartella della posta indesiderata.</span>');
                            setTimeout(function() {
                                window.location.href = "<?php echo BASE_URL; ?>index.php";
                            }, 7000);
                        }
                    },
                    "json");
            });

            $("#form_login").submit(function() {

                $.post("<?= BASE_URL; ?>functionload.php", jQuery("#form_login").serialize(),
                    function(data) {
                        //Se ci sono errori in fase di registrazione 
                        if (data.errore != 'no') {
                            $('#errmesslogin').html('<span style="color:red;">Attenzione, dati errati o account ancora non attivato.</span>');
                        } else {
                            setTimeout(function() {
                                window.location.href = "<?php echo $_SERVER['HTTP_REFERER']; ?>";
                            }, 500);
                        }
                    },
                    "json");
            });

        });
        $('.select2').select2({
            theme: 'classic',
            dropdownAutoWidth: true,
            width: '100%'
        });
    </script>

</body>

</html>