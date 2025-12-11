<?php
include("inc_config.php");

if(!isset($_SESSION['user'])){header("Location: ".BASE_URL."registrati.php");}
//if(!isset($_POST['metodosped'])){header("Location: ".BASE_URL."index.php");}

if(isset($_POST['metodosped'])){   
    $_SESSION['metodosped']=$_POST['metodosped'];
    $_SESSION['nomesped']=$array_testo_sped[$_POST['metodosped']];
//    $_SESSION['costosped']=$array_costo_sped[$_POST['metodosped']];
} 
  
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
				<h3 class="pull-left">Metodo di pagamento </h3>
				<ul class="nav-breakcrumb  pull-right">
					<li><a href="index.php">Home</a></li>
					<li><span>Metodo di pagamento</span></li>
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
						<li data-step="4" class="current"><span>Metodo di pagamento</span></li>
						<li data-step="5"><span>Riassunto ordine</span></li>
						<li data-step="6"><span>Conferma Ordine</span></li>
					</ul>
					<!-- END STEP CHECK OUT -->
					
					<!-- CHECK OUT FORM -->
                                        <div class="form check-out-form" style="padding-top:15px;">
					
                                            
                                         <form id="form_spedizione" action="<?=BASE_URL;?>carrello5.php" method="post" >
                                            <div class="row" >
                                                   <div class="col-xs-12">
                                                        <label><b style="font-size:20px;">Metodo di pagamento</b></label> 
					            </div>
                                                    <br /><br /><br />
							<div class="col-xs-12">
                                                            
                                                            <?php 
                                                           for ($i=1;$i<=count($array_testo_pag); $i++){ ?>
                                    
						            <input type="radio" class="input-text" name="metodopag" value="<?=$i;?>" style="width: 30px" 
                                                            <?php
                                                            if(isset($_SESSION['metodopag'])AND $_SESSION['metodopag']==$i){echo 'checked="checked" ';}
                                                            else if($i==2) echo 'checked="checked" '; ?>
                                                                   
                                                                   > <?=$array_testo_pag[$i];?> &nbsp;&nbsp;( <?=$array_costo_pag[$i];?>  &euro;)  <br />
                                                         
                                                                <?php } ?>
                                                            
                                                            
								
							</div>
							
						</div>
                                        
					 <div class="shop-button clearfix">
					    <a class="btn btn-13 text-uppercase pull-left" href="<?=BASE_URL;?>carrello3.php">Indietro</a>
                                           <button class="btn btn-13 text-uppercase pull-right">Continua</button>
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

                