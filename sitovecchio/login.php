<?php 
include 'include/connessione.php';
include "include/lingua.php"; 
include 'include/leggi_immagine.inc.php';
			
if ($lingua == "it")
{
$title = "";
$description = "";
}
else
{
$title = "";
$description = "";
} 
include 'include/head.php';
//filtra i valori in arrivo
$email = (isset($_POST['email'])) ? trim($_POST['email']) : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : 'http://www.sekurbox.com/' . $lingua . '/area-riservata.html';


if (isset($_POST['login_btn'])) {
	$query = "SELECT * FROM clienti WHERE email = '" . mysql_real_escape_string($email) . "' AND password = '" . mysql_real_escape_string($password) . "' ";
	$result = mysql_query($query, $db) or die(mysql_error($db));
	$riga = mysql_fetch_assoc($result);
	//extract($riga);
	$id_regione = $riga['id_regione'];
	$id_cliente = $riga['id_cliente'];
	
	if (mysql_num_rows($result) > 0) {
            
        $row = mysql_fetch_assoc($result);
        
        $_SESSION['email'] = $email;
        $_SESSION['logged'] = 1;
	$_SESSION['id_regione'] = $id_regione;
        $_SESSION['user']=$id_cliente;
				
		header ('Refresh: 2; URL=' . $redirect);
        echo '<center><p>'.$logok.'</p>';
		echo '<img src="http://www.sekurbox.com/Admin/img/loaders/1d_2.gif">';
        echo '<p>'.$ifnotview.' <a href="'.$redirect .'">'.$cliccaqui.'</a></p></center>';
				
        mysql_free_result($result);
        mysql_close($db);
        die();
    } else {
        // set these explicitly just to make sure
        $_SESSION['email'] = '';
        $_SESSION['logged'] = 0;

 $error = '<span class="userpass_errata">'.$errlog.'</span>';
    }
    mysql_free_result($result);
}
?>
<script src="http://www.sekurbox.com/js/jquery.validate.min.js" type="text/javascript"></script>
<script>
$().ready(function() {
	$("#signupForm").validate({
		rules: {	
				email: {
				required: true,
				email: true
			},									
			password: {
				required: true
			}		
			},
		messages: {
			email: "Email errata",
			password: "Password errata"
		}
	});
});
</script>
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
                    <div id="stile_titolo_pagina">Login</div>
                    <div id="briciole_di_pane"><a href="http://www.sekurbox.com/<?php echo $lingua; ?>/index.html">Home Page</a> / Login</div>
                </div>
            </div>  
            <div id="titolo_pagina_ds">
				<?php include 'include/banner-promozionale.php'; ?>
           </div>           
       </div>      
		<div class="row">
        	<div id="colonna_sn">
                <ul class="menu_laterale_case">
                    <?php $pagina="login"; include 'include/menu-sn.php';?>      	
                </ul>            
            </div>
            <div id="colonna_ds">
                <div class="form">
                    <?php 
                    
                    $redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : 'http://www.sekurbox.com/' . $lingua . '/area-riservata.html';
                    include 'include/form-login.php'; ?>
                </div>
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