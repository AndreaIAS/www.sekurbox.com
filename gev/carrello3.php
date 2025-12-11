<?php
include("inc_config.php");

if(!isset($_SESSION['user'])){header("Location: ".BASE_URL."registrati.php");}


if(isset($_POST['nome2'])){
    
    $_SESSION['nome2']=$_POST['nome2'];
    $_SESSION['cognome2']=$_POST['cognome2'];
    $_SESSION['indirizzo2']=$_POST['indirizzo2'];
    $_SESSION['citta2']=$_POST['citta2'];
    $_SESSION['provincia2']=$_POST['provincia2'];
    $_SESSION['cap2']=$_POST['cap2'];
    $_SESSION['email2']=$_POST['email2'];
    $_SESSION['telefono2']=$_POST['telefono2'];
    $_SESSION['cellulare2']=$_POST['cellulare2'];
 
}


//PRENDO IL TOTALE CARELLO
foreach($cart->get_contents() as $item) {
 
    $db->query("SELECT peso
                FROM bag_articoli
                WHERE   bag_articoli.id = '".$item['id']."' 
              ");
    $recordp = $db->single();

    $pesototale=$pesototale+($recordp['peso']*$item['qty']);
    
    

} 


$db->query("SELECT regioni.id AS idreg FROM 
            bag_utenti,regioni,province,comuni 
            WHERE bag_utenti.id_comune=comuni.id
            AND   comuni.id_provincia=province.id
            AND   province.id_regione=regioni.id
            AND   bag_utenti.id = '".mysql_escape_string($_SESSION['user'])."' 
          ");
$recordreg = $db->single();
                                                
if(!in_array($recordreg['idreg'],array('18','19','20'))){
    
    
                                                    
  if($pesototale<=3999){$costosped=8.70 ; }
  if($pesototale>=4000  AND $pesototale<=5999){$costosped=9.79 ; }
  if($pesototale>=6000  AND $pesototale<=10999){$costosped=10.67 ; }
  if($pesototale>=11000 AND $pesototale<=25999){$costosped=15.62 ; }
  if($pesototale>=26000 AND $pesototale<=50999){$costosped=19.8; }
  if($pesototale>=51000 AND $pesototale<=100000){$costosped=31.46 ; }  
  
  if($pesototale>100000){
      
      $q=$pesototale-100000;
      $numv=ceil($q/50000);
      $numf=$numv*0.5;
      $multiplier=1+$numf;
      $costosped=$multiplier*30.36;
      
      
      
  }
      
  
} else 
if($recordreg['idreg']==18){ //CALABRIA
  
  if($pesototale<=3999){$costosped=9.46 ; }
  if($pesototale>=4000  AND $pesototale<=5999){$costosped=10.34 ; }
  if($pesototale>=6000  AND $pesototale<=10999){$costosped=11.44 ; }
  if($pesototale>=11000 AND $pesototale<=25999){$costosped=17.27 ; }
  if($pesototale>=26000 AND $pesototale<=50999){$costosped=21.89; }
  if($pesototale>=51000 AND $pesototale<=100000){$costosped=36.85; }   

    if($pesototale>100000){
      
      $q=$pesototale-100000;
      $numv=ceil($q/50000);
      $numf=$numv*0.5;
      $multiplier=1+$numf;
      $costosped=$multiplier*33.66;        
      
  }
  
    
}else
if($recordreg['idreg']==19){ //SICILIA
  
  if($pesototale<=3999){$costosped=9.57 ; }
  if($pesototale>=4000  AND $pesototale<=5999){$costosped=10.78 ; }
  if($pesototale>=6000  AND $pesototale<=10999){$costosped=11.77 ; }
  if($pesototale>=11000 AND $pesototale<=25999){$costosped=17.27 ; }
  if($pesototale>=26000 AND $pesototale<=50999){$costosped=21.89; }
  if($pesototale>=51000 AND $pesototale<=100000){$costosped=36.85 ; }  
  
    if($pesototale>100000){
      
      $q=$pesototale-100000;
      $numv=ceil($q/50000);
      $numf=$numv*0.5;
      $multiplier=1+$numf;
      $costosped=$multiplier*33.66;     
  }
    
}else
if($recordreg['idreg']==20){//SARDEGNA
  
  if($pesototale<=3999){$costosped=9.79 ; }
  if($pesototale>=4000  AND $pesototale<=5999){$costosped=11.33 ; }
  if($pesototale>=6000  AND $pesototale<=10999){$costosped=12.76 ; }
  if($pesototale>=11000 AND $pesototale<=25999){$costosped=17.27 ; }
  if($pesototale>=26000 AND $pesototale<=50999){$costosped=21.89; }
  if($pesototale>=51000 AND $pesototale<=100000){$costosped=36.85 ; }     
  
    if($pesototale>100000){
      
          $q=$pesototale-100000;
          $numv=ceil($q/50000);
          $numf=$numv*0.5;
          $multiplier=1+$numf;
          $costosped=$multiplier*33.66;       
  }
    
}
    
$array_costo_sped[1]=$costosped;
$_SESSION['costosped']=$costosped;
//echo $_SESSION['costosped'];
  
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
				<h3 class="pull-left">Metodo di spedizione </h3>
				<ul class="nav-breakcrumb  pull-right">
					<li><a href="index.php">Home</a></li>
					<li><span>Metodo di spedizione</span></li>
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
						<li data-step="3" class="current"><span>Metodo di spedizione</span></li>
						<li data-step="4"><span>Metodo di pagamento</span></li>
						<li data-step="5"><span>Riassunto ordine</span></li>
						<li data-step="6"><span>Conferma Ordine</span></li>
					</ul>
					<!-- END STEP CHECK OUT -->
					
					<!-- CHECK OUT FORM -->
                                        <div class="form check-out-form" style="padding-top:15px;">
					
                                            
                                         <form id="form_spedizione" action="<?=BASE_URL;?>carrello4.php" method="post" >
                                                <div class="row" >
                                                   <div class="col-xs-12">
                                                        <label><b style="font-size:20px;">Metodo di spedizione</b></label> 
					            </div>
                                                    <br /><br /><br />
							<div class="col-xs-12">
                                                            
                                                            <?php 
                                                           for ($i=1;$i<=count($array_testo_sped); $i++){ ?>
                                                            
                                                           
						            <input type="radio"required class="input-text" name="metodosped" value="<?=$i;?>" style="width:30px" 
                                                            <?php
                                                            if(isset($_SESSION['metodosped'])AND $_SESSION['metodosped']==$i){echo 'checked="checked" ';}
                                                            else if($i==1) echo 'checked="checked" '; ?>
                                                                   
                                                           > <?=$array_testo_sped[$i];?> &nbsp;&nbsp;( <?=$array_costo_sped[$i];?> &euro;)  <br />
                                                           
                                                            
                                                            <?php } ?>
                                                            
                                                            
								
							</div>
							
						</div>
                                  
  
                                           <div class="shop-button clearfix">
					    <a class="btn btn-13 text-uppercase pull-left" href="<?=BASE_URL;?>carrello2.php">Indietro</a>
                                          <button class="btn btn-13 text-uppercase pull-right" >Continua</button>
                                         </div>        
                                         
                                         </form>  
					</div>
					<!-- END CHECK OUT FORM -->

				</div>
			</div>
		</section>
		<!-- END CHECK OUT -->

	
		
				<?php
include("inc_footer.php");
?>

                