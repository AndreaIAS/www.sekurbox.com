<?php
require("inc_config.php");


if (isset($_REQUEST['seo'])){

   
   $_REQUEST['seo']=substr($_REQUEST['seo'],(strpos($_REQUEST['seo'],"_")+1)); 
 
    $queryceck= "SELECT * FROM 
                 prodotti  
                 ";
    $resultceck= mysql_query($queryceck);
    $idpage="no";
    while($listceck = mysql_fetch_array($resultceck)){  
    if($listceck['rewrite']==$_REQUEST['seo'] )   {$idpage= $listceck['id'];  }
                                                     }
    if ($idpage=="no") {  
                         header("HTTP/1.0 404 Not Found");
                         header("Location: ".BASE_URL."404.php");
                       }


                           }
                                  
else {  header("Location:".BASE_URL."404.php");  }


?>

<!DOCTYPE html>
<html>
<head>
<script src="<?=BASE_URL;?>js/jquery-1.7.2.min.js"></script>
<script>

function formatNumber(num,dec,thou,pnt,curr1,curr2,n1,n2) {var x = Math.round(num * Math.pow(10,dec));if (x >= 0) n1=n2='';var y = (''+Math.abs(x)).split('');var z = y.length - dec; if (z<0) z--; for(var i = z; i < 0; i++) y.unshift('0'); if (z<0) z = 1; y.splice(z, 0, pnt); if(y[0] == pnt) y.unshift('0'); while (z > 3) {z-=3; y.splice(z,0,thou);}var r = curr1+n1+y.join('')+n2+curr2;return r;}
</script>
<meta charset="utf-8" />

            <?php
            
            
            $query = " SELECT *
                       FROM 
                       prodotti
                       WHERE id='".$idpage."'
                         ";
            
            $result = mysql_query($query);
            $list = mysql_fetch_array($result); 
            $nomeprodotto=$list['nome']; 
            $default='img_'.$list['img_default'].'_crop';
            $rewrite= $list['rewrite']; 
            $coeff= $list['coeff'];         
            
    $queryassociati= " SELECT *
                       FROM 
                       prod_associati
                       WHERE id_prod='".$idpage."'
                         ";          
    $resultassociati = mysql_query($queryassociati);
    $totassociati=mysql_num_rows($resultassociati);
            
            
            $queryser = "SELECT *
                         FROM 
                         servizi
                         ";
            
            $resultser = mysql_query($queryser);
            $listser = mysql_fetch_array($resultser); 
            
          
          
         $querycloud= "SELECT tag_cloud.*,tag.*,tag.id AS idtag
                       FROM 
                       tag_cloud,tag
                       WHERE tag_cloud.id_tag=tag.id
                       AND tag_cloud.id_prodotto='".$idpage."'                    
                       AND tag.macro='s'   ";
         //echo $querycloud;
         
         $resultcloud= mysql_query($querycloud)or die(mysql_error()); 
         $listcloud=mysql_fetch_array($resultcloud);
         $categ=$listcloud['plurale'];
         $icontag=$listcloud['id'];   
         
         //SE LA MACRO è accessori prendo la sottocategoria
         if($listcloud['id_tag']=='58') {
            
         $querysott= "SELECT tag_cloud.*,tag.*,tag.id AS idtag
                       FROM 
                       tag_cloud,tag
                       WHERE tag_cloud.id_tag=tag.id
                       AND tag_cloud.id_prodotto='".$idpage."'                    
                       AND tag.sottomacro='s'   ";        
         $resultsott= mysql_query($querysott)or die(mysql_error()); 
         $listsott=mysql_fetch_array($resultsott);      
         $categ=$listsott['plurale'];
         $icontag=$listsott['idtag'];   
         //echo    $querysott;
         }


         $queryico="SELECT  tag_cloud.*,tag.*,misure_stand.*
                                FROM 
                                tag_cloud,tag,misure_stand
                                WHERE misure_stand.larghezza_std=0
                                AND tag_cloud.nuvoletta='n'
                                AND tag.macro='n'
                                AND tag_cloud.id_tag=tag.id 
                                AND tag.id=misure_stand.id_tag
                                AND tag_cloud.id_prodotto='".$idpage."'
                                ";
                    // echo $queryico;
         $resultico = mysql_query($queryico) or die(mysql_error());
         $listico=mysql_fetch_array($resultico);  
             
            ?>
<title><?=$list['title'];?> | LUNABLU - <?=$list['nome'];?></title>
<meta name="description" content="<?=$list['description'];?>" />
<meta name="keywords" content="<?=$list['keywords'];?>" />
<?php if($list['canonical']!=''){ ?>
<link rel="canonical" href="<?=$list['canonical'];?>"/>
<?php } ?>
<link rel="stylesheet" href="<?=BASE_URL;?>css/all.css" />
<link rel="stylesheet" href="<?=BASE_URL;?>js/fancybox/jquery.fancybox.css" />
<link rel="stylesheet" type="text/css" href="<?=BASE_URL;?>jrating/jquery/jRating.jquery.css" media="screen" />
<script type="text/javascript" src="<?=BASE_URL;?>jrating/jquery/jRating.jquery.js"></script>
<?php include_once("inc/common-meta.php") ?>

<?php
$ua=getBrowser();
if($ua['name']=="Internet Explorer" AND ($ua['version']=='8.0' OR $ua['version']=='9.0')) { ?>
<script src="<?=BASE_URL;?>js/html5shiv.js"></script>       
<?php }  ?>
<?php include_once("inc/analyticstracking.php") ?><!-- Monitoraggio Google Analythics -->
</head>

<body>

<div id="main-wrapper">
	<article class="page-dettaglio-prodotti">
		<?php include('inc/inc-main-header.php'); ?>
		<?php include('inc/inc-main-menu.php'); ?>
		<div id="under-menu">
		 
          <nav style="height:40px;">            
            <ul>
			<li class="title" ><h1><?=$list['title'];?></h1></li>
			</ul>          
		  </nav>
		
	<div class="switcher-nav">
     <?php	
     
     //Faccio le query per impostare le freccette nella barra blu in alto
        
          $queryprodtag2= "SELECT *
                           FROM 
                           prod_tag
                           WHERE prod_tag.id_prodotto='".$idpage."'                    
                       ";
        $resultprodtag2= mysql_query($queryprodtag2)or die(mysql_error()); 
        $listprodtag2=mysql_fetch_array($resultprodtag2); 
        
        //echo $queryprodtag2;
        
        //Nome categoria per la breadcumb
        $querynomecategoria="SELECT prod_tag.*,tag.* 
                             FROM tag,prod_tag
                             WHERE  prod_tag.id_tag=tag.id AND
                             prod_tag.id_tag='".$listprodtag2['id_tag']."' ";
        $resultcategoria=mysql_query($querynomecategoria) or die(mysql_error());
        $listcategoria=mysql_fetch_array($resultcategoria);
        
        //echo $querynomecategoria;
        
         if($listcloud['id_tag']=='58') { $part="AND tag.sottomacro='s' AND tag.id='".$listsott['idtag']."'";}
         else{$part="AND tag.macro='s' AND tag.id='".$listcloud['idtag']."'";     }

        $queryprodtag= "SELECT prod_tag.*,prodotti.* 
                        FROM prodotti,prod_tag
                        WHERE prod_tag.id_tag='".$listprodtag2['id_tag']."'
                        AND prod_tag.id_prodotto IN(SELECT prodotti.id
                        FROM 
                        prodotti
                        INNER JOIN tag_cloud ON tag_cloud.id_prodotto=prodotti.id
                        INNER JOIN tag ON tag_cloud.id_tag=tag.id ".$part." 
                        ) AND prod_tag.id_prodotto=prodotti.id ORDER by prod_tag.id                                                       
                       ";
        
        //echo $queryprodtag;
        $resultprodtag= mysql_query($queryprodtag)or die(mysql_error()); 
        $numrighep=mysql_num_rows($resultprodtag);
        $r=0;
        while($listprodtag=mysql_fetch_array($resultprodtag)) {$r++;
  
             
             if($listprodtag['id_prodotto']==$idpage && $r!=1){$seoprev=$seobefore; $nomeprev=$nomebefore; $titleprev=$titlebefore;}
            
             if($listprodtag['id_prodotto']==$idpage ){$get=$r;}
             
             if($listprodtag['id_prodotto']==$idpage && $r==1){$prendifine='ok';}
             
             if($r==$get+1){$seonext=$listprodtag['rewrite'];$nomenext=$listprodtag['nome'];$titlenext=$listprodtag['title'];}
             
             $seobefore=$listprodtag['rewrite'];$nomebefore=$listprodtag['nome'];$titlebefore=$listprodtag['title'];
             
             if($prendifine=='ok' && $r==$numrighep){$seoprev=$listprodtag['rewrite']; $nomeprev=$listprodtag['nome']; $titleprev=$listprodtag['title'];    }
             
             
             } 
          
             ?>    
      
        
  
   
    	<?php if($numrighep >1){ ?>
    			<ul>
				<li><a href="<?=BASE_URL;?>prod/<?=strtolower(seo_url($nomeprev));?>_<?=$seoprev;?>" rel="prev" title="<?=$titlebefore;?>" class="prev">Precedente</a></li>
					<li class="title"><h5><?=$list['nome'];?></h5></li>
					<li><a href="<?=BASE_URL;?>prod/<?=strtolower(seo_url($nomenext));?>_<?=$seonext;?>" rel="next" title="<?=$titlenext;?>" class="next">Successivo</a></li>
				</ul>
          <?php } else {?>
         <h1  ><?=$list['nome'];?></h1>
           <?php } ?> 
            
	</div>
<!--/.switcher-->
		</div><!-- /#under-menu - area menu attiva in pagina -->
		
		<div class="inner-wrapper">
		
			<div class="tag-list">
           <?php
            
            
            $queryn = "SELECT tag_cloud.*,tag.*
                       FROM 
                       tag_cloud,tag
                       WHERE tag_cloud.id_tag=tag.id
                       AND tag_cloud.id_prodotto='".$idpage."'
                       order by tag_order  ";
            
            $resultn = mysql_query($queryn) or die(mysql_error());
            
       //Se la macro è accessori prendo la sottomacro.     
       if($idmacro==58){
            
         $querysmac= "SELECT tag_pag_prodotti.*,tag.* FROM 
                      tag_pag_prodotti ,tag,tag_cloud
                      WHERE tag_pag_prodotti.id_tag=tag.id
                      AND tag_cloud.id_tag=tag.id
                       AND tag_cloud.id_prodotto='".$idpage."'
                      AND tag.sottomacro='s'
                   ";
         $resultsmac= mysql_query($querysmac)or die(mysql_error());
         $listsmac=mysql_fetch_array($resultsmac);  
         $idtagmacro= strtolower($listsmac['plurale']);
            
                        } else { 
                            
          $querysmac= "SELECT * FROM 
                       tag WHERE id='".$idmacro."' 
                   ";
         $resultsmac= mysql_query($querysmac)or die(mysql_error());
         $listmac=mysql_fetch_array($resultsmac);  
         $idtagmacro= strtolower($listmac['plurale']); }
            
            while($listn = mysql_fetch_array($resultn)){  
            if($listn['nuvoletta']=='s'){
            ?>
				<!--
<a href="<?=BASE_URL;?>list/<?=$idtagmacro;?>-<?=strtolower(seo_url($listn['plurale']));?>" title="<?=$idtagmacro;?> <?=$listn['plurale'];?>"><?=$listn['singolare'];?></a> 
-->
<a href="<?=BASE_URL.strtolower(seo_url($idtagmacro));?>/<?=strtolower(seo_url($idtagmacro."-".$listn['plurale']));?>" title="<?=$idtagmacro;?> <?=$listn['plurale'];?>"><?=$listn['singolare'];?></a> 
	     	<?php }} ?>
        	<div style="float:right;width:150px;">
            <div  style="float:right;margin:0px 13px 0px 0px;font-size:12px;position:relative;">Opinione dei clienti
            <div id="resultvoto" style="color:green;position:absolute;top:-15px;left:0px;"></div>
            </div> 
            <div class="basic" data-average="<?=$list['tot_voti']/$list['num_voti'];?>" data-id="<?=$idpage;?>" style="float:right;"></div>

                    <!-- JS to add -->
                    <script type="text/javascript">
                      $(document).ready(function(){
                    	$(".basic").jRating({
                        step:true,
                        length : 5, // nb of stars
                        showRateInfo:false,
                        decimalLength:1,
                        rateMax:5  
                       });
                      });
                    </script>
            
            </div>
            </div><!--/.tag-list-->
			
			<div class="big-slider" style="min-height: 290px;">
				<div class="slide-container">
				 <?php
                    $queryi = "SELECT slider.*
                               FROM 
                               slider
                               WHERE id_prod='".$idpage."'
                               AND posizione!=15
                               order by posizione  ";
                    
                    $resulti = mysql_query($queryi) or die(mysql_error());
                    while($listi = mysql_fetch_array($resulti)){  
                   
                 ?>
                	<div class="single-slide">
                    <figure>
                    <img src="<?=BASE_URL;?>images/img_slide/<?=$listi['img_crop'];?>"  alt="<?=$listi['img'];?>" />
                    </figure>
                    <a  href="<?=BASE_URL;?>images/img_slide/<?=$listi['img'];?>" class="fancy zoom" rel="group" title="<?=$listi['img'];?>"></a>
                    </div>  
                 <?php } ?>
				
                </div>
				
			</div><!--/.big-slider-->
		   
			<nav  class="breadcrumbs">
			   <a href="<?=BASE_URL;?>" title="Homepage"><span itemprop="title">Homepage</span></a> ›
   	           <a href="<?=BASE_URL;?><?=strtolower(seo_url($listcloud['plurale']));?>" title="<?=$listcloud['plurale'];?>"><span itemprop="title"><?=$listcloud['plurale'];?></span></a> ›
               <a href="<?=BASE_URL;?><?=strtolower(seo_url($categ));?>/<?=strtolower(seo_url($categ));?><?php echo "-".strtolower(seo_url($listcategoria['plurale']));  ?>" title="<?=$categ." ".$listcategoria['plurale'];?>"><span itemprop="title"><?=$categ." ".$listcategoria['plurale'];?></span></a> ›
               <span itemprop="title"><?=$list['nome'];?></span>
			</nav><!--/.breadcrumbs-->
			
			<div class="claim">
				<div class="title"><?=$list['titolo'];?></div>
				<div class="text"><p><?=$list['descrizione_breve'];?></p></div><!--/.text-->
			</div><!--/.claim-->
			  <?php
           
            
           
  
           $querytotp = "SELECT prezzi.*,prezzi.id AS idprezzo
                         FROM 
                         prezzi
                         WHERE prezzi.id_prod='".$idpage."'
                       ";
            
            $resulttotp  = mysql_query($querytotp) or die(mysql_error());
            $listtotp=mysql_fetch_array($resulttotp);
            $totprezzi=mysql_num_rows($resulttotp);
            
 //Caso di più prezzi E' il caso diciamo NORMALE         
  if($totprezzi>1){ ?>
            
			<div class="size-options-box clearfix">
			
             <?php
              $querym = "SELECT tag_cloud.*,tag.*,misure_stand.*,prezzi.*,prezzi.id AS idprezzo
                         FROM 
                         tag_cloud,tag,misure_stand,prezzi
                         WHERE tag_cloud.id_tag=tag.id 
                         AND tag.id=misure_stand.id_tag
                         AND prezzi.id_prod=tag_cloud.id_prodotto
                         AND prezzi.larghezza=misure_stand.larghezza_std
                         AND prezzi.lunghezza=misure_stand.lunghezza_std
                         AND tag_cloud.id_prodotto='".$idpage."'
                         order by misure_stand.larghezza_std ";
            
            $resultm = mysql_query($querym) or die(mysql_error());
           
          /*  if(mysql_num_rows($resultm)==0){
                
            $querym = "SELECT prezzi.*,prezzi.id AS idprezzo,
                         prezzi.larghezza AS  larghezza_std, prezzi.lunghezza AS lunghezza_std
                         FROM 
                         tag_cloud,tag,prezzi
                         WHERE tag_cloud.id_tag=tag.id 
                         AND prezzi.id_prod=tag_cloud.id_prodotto
                         AND tag_cloud.id_prodotto='".$idpage."'
                         GROUP BY idprezzo
                         order by prezzi.larghezza";
          
           // echo $querym;
            $resultm = mysql_query($querym) or die(mysql_error());       
            }*/
            while($listm = mysql_fetch_array($resultm)){ 
            
            ?>
            
				<div class="box-item">
					<div class="size small-mat" >
					<div style="float:left;width:33px;">
                    <img style="margin-right:4px;" src="<?=BASE_URL;?>images/img_mis_stand/<?=$listm['logo_misura'];?>"  border="0" />
                    </div>
                    	<b><?=$listm['alias_mis_std'];?></b><br />
			      <!-- Controllo se è una rete o meno e abilito popup altezza -->
                    <?php if($idmacro=='55'){ ?>
                    <a class="askalt" href="#selaltezza" for="addcar<?=$listm['idprezzo'];?>"><?=$listm['larghezza_std'];?>x<?=$listm['lunghezza_std'];?>  ›</a>                  
                    <?php }  else {?> 
                    <a href="javascript:void(null)" onclick="$('#addcar<?=$listm['idprezzo'];?>').submit();"><?=$listm['larghezza_std'];?>x<?=$listm['lunghezza_std'];?>  ›</a>
                     <?php }  ?>          
						 <? if($listm['prezzo_offerta']>0 AND strtotime($listm['inizio_offerta']) >= strtotime(date('y-m-d')) AND strtotime($listm['scad_offerta']) <= strtotime(date('y-m-d')) ) 
                               $prezzo=$listm['prezzo_offerta']; else $prezzo=$listm['prezzo']; 
                            ?>
                        <div class="price">&euro; <?=number_format($prezzo,0,',','.');?></div>
					</div><!--/.size-->
					<b><a id="inline" href="#mis">Vedi Altre Misure</a> |</b> 
                    
                    <!-- Controllo se è una rete o meno e abilito popup altezza -->
                    <?php if($idmacro=='55'){ ?>
                    <a class="askalt" href="#selaltezza" for="addcar<?=$listm['idprezzo'];?>">Acquista ›</a>                  
                    <?php }  else {?> 
                    <a href="javascript:void(null)" onclick="$('#addcar<?=$listm['idprezzo'];?>').submit();">Acquista ›</a>
                     <?php }  ?> 
      
      <!-- Form del bottone acquista -->
                
     <form id="addcar<?=$listm['idprezzo'];?>" name="addcar<?=$listm['idprezzo'];?>" method="POST" action="<?=BASE_URL;?>cross">
         <input type="hidden" id="item" name="item" value="<?=$listm['idprezzo'];?>" /> 
   		<input type="hidden" id="price" name="price" value="<?=$prezzo;?>" />
         <input type="hidden" id="qty" name="qty" value="1" />
         <input type="hidden" id="action" name="action" value="add" />
         <input type="hidden" id="larghezza" name="larghezza" value="<?=$listm['larghezza_std'];?>" />
         <input type="hidden" id="nome" name="nome" value="<?=$nomeprodotto;?>" />
         <input type="hidden" id="nomepagina" name="nomepagina" value="<?=$listm['singolare']." ".$listm['alias_mis_std'];?>" />
         <input type="hidden" id="lunghezza" name="lunghezza" value="<?= $listm['lunghezza_std'];?>" />
         <input type="hidden" id="icona" name="icona" value="<?=BASE_URL;?>images/img_mis_stand/<?=$listm['logo_misura'];?>" />
         <input type="hidden" id="image_name" name="image_name" value="<?= $list[$default] ;?>" />
         <input type="hidden" id="description" name="description" value="<?= $list['descrizione_breve'] ;?>" />
         <input type="hidden" id="url" name="url" value="<?=BASE_URL;?>prod/<?=strtolower(seo_url($nomeprodotto));?>_<?=$rewrite;?>" />
      </form>
                    
       
				</div><!--/.box-item-->
                
             
			<?php } ?>
           
             
				<div class="box-item last-box-item">
					<div class="size custom-mat">
						<b><a id="persmis" href="#mis">Personalizza<br />Misure ›</a></b>     
					</div><!--/.size-->  
                    
				</div><!--/.box-item-->
			
			</div><!--/.size-options-box-->
 
   <!-- Area fancybox -->           
<div style="display:none">                    
              <!-- Popup altezza -->
              <div id="selaltezza" style="width:760px;height:350px;">   </div>
 
                <!-- Popup altre misure --> 
               <div id="mis" class="claim"> 
                
                <div class="title" style="text-align: left;font-size:42px;font-family: 'MyriadProRegular';"><?=$listcloud['singolare'];?> | <?=$list['nome'];?></div>
                <div class="text" style="text-align: left;font-size:26px;font-family: 'MyriadProRegular';">Per acquistare, clicca la misura desiderata o inserisci le tue misure personalizzate</div>
            
            <div class="step-boxes" style="margin-top: 0px;">
			<section class="step-item step-2" style="padding-left:0px;"></section>
            <section class="step-item step-2" style="padding-left:0px;">
						
			<div class="box-wrapper clearfix"  style="text-align:left; ">
			
            
            <?php                
              $querym = "SELECT  tag_cloud.*,tag.*,misure_stand.*,prezzi.*,prezzi.id AS idprezzo
                         FROM 
                         tag_cloud,tag,misure_stand,prezzi
                         WHERE  tag_cloud.id_tag=tag.id 
                         AND tag.id=misure_stand.id_tag
                         AND prezzi.id_prod=tag_cloud.id_prodotto
                         AND (tag.macro='s' OR tag.sottomacro='s')
                         AND tag_cloud.id_prodotto='".$idpage."'
                         AND larghezza_std <=100 AND larghezza_std >79
                         AND larghezza <=100 AND larghezza >79
                         GROUP BY larghezza,lunghezza
                         order by larghezza  ";
            //echo $querym;
            $resultm  = mysql_query($querym) or die(mysql_error());
            $tot=mysql_num_rows($resultm);
            $i=0;
           	if($tot>0) {
             ?>
            
            <div class="box-item small-mat" style="text-align:left;">
			<div class="title" style="color:#000000;font-size:13px;font-weight:bolder;">
            <?php                                   
            $querymis="SELECT logo_misura FROM misure_stand
                        WHERE larghezza_std=80 AND id_tag='".$icontag."' ";
            $resultmis=mysql_query($querymis);
            $listmis=mysql_fetch_array($resultmis);
            
            ?>
            <img src="<?=BASE_URL;?>images/img_mis_stand/<?=$listmis['logo_misura'];?>" />
            Singolo
            </div>
                                	<div class="field-group">
            <?php
        
            while($listm = mysql_fetch_array($resultm)){  $i++; ?>
                        
            <div class="field-row">
            <div class="box-item" style="font-size: 12px;width: 150px;">
            	 <? if($listm['prezzo_offerta']>0 AND strtotime($listm['inizio_offerta']) >= strtotime(date('y-m-d')) AND strtotime($listm['scad_offerta']) <= strtotime(date('y-m-d')) ) 
                               $prezzo=$listm['prezzo_offerta']; else $prezzo=$listm['prezzo']; 
                            ?>
            <?=$listm['larghezza'];?>x<?=$listm['lunghezza'];?> | 
             
             <?php if($idmacro=='55'){ ?>
                    <a class="askalt" href="#selaltezza"  for="addcars<?=$listm['idprezzo'];?>" >&euro; <?=number_format($prezzo,2,',','.');?> ›</a>                  
                    <?php }  else {?> 
                     <a href="javascript:void(null)"  onclick="$('#addcars<?=$listm['idprezzo'];?>').submit();">&euro; <?=number_format($prezzo,2,',','.');?> ›</a>
               
                     <?php }  ?> 
           <!-- Form misura singola -->
               <form id="addcars<?=$listm['idprezzo'];?>" name="addcars<?=$listm['idprezzo'];?>" method="POST" action="<?=BASE_URL;?>cross">
                 <input type="hidden" id="item" name="item" value="<?=$listm['idprezzo'];?>" /> 
                 <input type="hidden" id="price" name="price" value="<?=$prezzo;?>" />
                 <input type="hidden" id="qty" name="qty" value="1" />
                 <input type="hidden" id="action" name="action" value="add" />
                 <input type="hidden" id="larghezza" name="larghezza" value="<?=$listm['larghezza'];?>" />
                 <input type="hidden" id="nome" name="nome" value="<?=$nomeprodotto;?>" />
                 <input type="hidden" id="nomepagina" name="nomepagina" value="<?=$listm['singolare']." ".$listm['alias_mis_std'];?>" />
                 <input type="hidden" id="lunghezza" name="lunghezza" value="<?= $listm['lunghezza'];?>" />
                 <input type="hidden" id="icona" name="icona" value="<?=BASE_URL;?>images/img_mis_stand/<?=$listm['logo_misura'];?>" />
                 <input type="hidden" id="image_name" name="image_name" value="<?= $list[$default] ;?>" />
                 <input type="hidden" id="description" name="description" value="<?= $list['descrizione_breve'] ;?>" />
                 <input type="hidden" id="url" name="url" value="<?=BASE_URL;?>prod/<?=strtolower(seo_url($nomeprodotto));?>_<?=$rewrite;?>" />
                </form>
          
             </div>
            </div>            
          
            <?php
            
           if($i%3==0 && $i!=$tot ){echo "</div><div class=\"field-group\">"; }
          else if($i==$tot){echo "</div>";}
             } ?>
            </div>  
                      
               <?php }
                        
              $querym = "SELECT  tag_cloud.*,tag.*,misure_stand.*,prezzi.*,prezzi.id AS idprezzo
                         FROM 
                         tag_cloud,tag,misure_stand,prezzi
                         WHERE  tag_cloud.id_tag=tag.id 
                         AND tag.id=misure_stand.id_tag
                         AND prezzi.id_prod=tag_cloud.id_prodotto
                         AND (tag.macro='s' OR tag.sottomacro='s')
                         AND tag_cloud.id_prodotto='".$idpage."'
                         AND larghezza_std >100 AND larghezza_std <=150
                         AND larghezza >100 AND larghezza <=150
                         GROUP BY larghezza,lunghezza
                         order by larghezza ";
            //echo $querym;
            $resultm  = mysql_query($querym) or die(mysql_error());
            $tot=mysql_num_rows($resultm);
            $i=0; 
         	if($tot>0) {
             ?>
                <div class="box-item small-mat" style="text-align:left; width:150px;">
			    <div class="title" style="color:#000000;font-size:13px;font-weight:bolder;">
           <?php                                   
            $querymis="SELECT logo_misura FROM misure_stand
                        WHERE larghezza_std=120  AND id_tag='".$icontag."' ";
            $resultmis=mysql_query($querymis);
            $listmis=mysql_fetch_array($resultmis);
            
            ?>
            <img src="<?=BASE_URL;?>images/img_mis_stand/<?=$listmis['logo_misura'];?>" />
                Piazza e Mezza
                </div>
      	        <div class="field-group">
            <?php

            while($listm = mysql_fetch_array($resultm)){  $i++;?>
                         
             <div class="field-row">
            <div class="sizes-price" style="font-size: 12px;width: 150px;">
            <span class="icon">
            <!-- <img src="<?=$src;?>" /> -->
            </span> 
            <span class="data"><?=$listm['larghezza'];?>x<?=$listm['lunghezza'];?> | 
             <? if($listm['prezzo_offerta']>0 AND strtotime($listm['inizio_offerta']) >= strtotime(date('y-m-d')) AND strtotime($listm['scad_offerta']) <= strtotime(date('y-m-d')) ) 
                               $prezzo=$listm['prezzo_offerta']; else $prezzo=$listm['prezzo']; 
             ?>
           
           <?php if($idmacro=='55'){ ?>
                    <a class="askalt" href="#selaltezza"  for="addcarp<?=$listm['idprezzo'];?>" >&euro; <?=number_format($prezzo,2,',','.');?> ›</a>                  
           <?php }  else {?> 
                     <a href="javascript:void(null)"  onclick="$('#addcarp<?=$listm['idprezzo'];?>').submit();">&euro; <?=number_format($prezzo,2,',','.');?> ›</a>              
           <?php }  ?> 
           
          <!-- Form misura piazza e mezzo-->
               
               <form id="addcarp<?=$listm['idprezzo'];?>" name="addcarp<?=$listm['idprezzo'];?>" method="POST" action="<?=BASE_URL;?>cross">
                 <input type="hidden" id="item" name="item" value="<?=$listm['idprezzo'];?>" /> 
        		<? if($listm['prezzo_offerta']>0 AND strtotime($listm['inizio_offerta']) >= strtotime(date('y-m-d')) AND strtotime($listm['scad_offerta']) <= strtotime(date('y-m-d')) ) { ?>
        			<input type="hidden" id="price" name="price" value="<?= $listm['prezzo_offerta'] ;?>" />
        		<? } else { ?>
        	   		<input type="hidden" id="price" name="price" value="<?=$listm['prezzo'];?>" />
        		<? } ?>
                 <input type="hidden" id="qty" name="qty" value="1" />
                 <input type="hidden" id="action" name="action" value="add" />
                 <input type="hidden" id="larghezza" name="larghezza" value="<?=$listm['larghezza'];?>" />
                 <input type="hidden" id="nome" name="nome" value="<?=$nomeprodotto;?>" />
                 <input type="hidden" id="nomepagina" name="nomepagina" value="<?=$listm['singolare']." ".$listm['alias_mis_std'];?>" />
                 <input type="hidden" id="lunghezza" name="lunghezza" value="<?= $listm['lunghezza'];?>" />
                 <input type="hidden" id="icona" name="icona" value="<?=BASE_URL;?>images/img_mis_stand/<?=$listm['logo_misura'];?>" />
                 <input type="hidden" id="image_name" name="image_name" value="<?= $list[$default] ;?>" />
                 <input type="hidden" id="description" name="description" value="<?= $list['descrizione_breve'] ;?>" />
                 <input type="hidden" id="url" name="url" value="<?=BASE_URL;?>prod/<?=strtolower(seo_url($nomeprodotto));?>_<?=$rewrite;?>" /> 
                </form>
                </span>
             </div>
            </div>
                        
                        
            <?php
            
           if($i%3==0 && $i!=$tot ){echo "</div><div class=\"field-group\">"; }
          else if($i==$tot){echo "</div>";}
             } ?>
            </div>         
           <?php } 
           
                //NOT (prezzi.larghezza=misure_stand.larghezza_std AND prezzi.lunghezza=misure_stand.lunghezza_std)AND 
                         
           $querym = "SELECT  tag_cloud.*,tag.*,misure_stand.*,prezzi.*,prezzi.id AS idprezzo
                         FROM 
                         tag_cloud,tag,misure_stand,prezzi
                         WHERE tag_cloud.id_tag=tag.id 
                         AND tag.id=misure_stand.id_tag
                         AND prezzi.id_prod=tag_cloud.id_prodotto
                         AND (tag.macro='s' OR tag.sottomacro='s')
                         AND tag_cloud.id_prodotto='".$idpage."'
                         AND larghezza_std  >150
                         AND larghezza >150
                         GROUP BY larghezza,lunghezza
                         order by larghezza ";
            
            $resultm  = mysql_query($querym) or die(mysql_error());
            $tot=mysql_num_rows($resultm);
            $i=0;
           if($tot >0) {
           ?>
           
           
           
           
           
              	<div class="box-item small-mat" style="text-align:left; width:200px;">
			    <div class="title" style="color:#000000;font-size:13px;font-weight:bolder;">
                 <?php                                   
            $querymis="SELECT logo_misura FROM misure_stand
                        WHERE larghezza_std=160  AND id_tag='".$icontag."' ";
            $resultmis=mysql_query($querymis);
            $listmis=mysql_fetch_array($resultmis);
            
            ?>
            <img src="<?=BASE_URL;?>images/img_mis_stand/<?=$listmis['logo_misura'];?>" />
                Matrimoniale
                </div>
               	<div class="field-group">
            <?php
         
            while($listm = mysql_fetch_array($resultm)){  $i++; ?>
                        
             <div class="field-row">
            <div class="sizes-price" style="font-size: 12px;width: 150px;">
            <span class="icon">
            <!-- <img src="<?=$src;?>" /> -->
            </span> 
             <? if($listm['prezzo_offerta']>0 AND strtotime($listm['inizio_offerta']) >= strtotime(date('y-m-d')) AND strtotime($listm['scad_offerta']) <= strtotime(date('y-m-d')) ) 
                               $prezzo=$listm['prezzo_offerta']; else $prezzo=$listm['prezzo']; 
             ?>
            <span class="data"><?=$listm['larghezza'];?>x<?=$listm['lunghezza'];?> | 
              
            <?php if($idmacro=='55'){ ?>
                    <a class="askalt" href="#selaltezza"  for="addcarm<?=$listm['idprezzo'];?>" >&euro; <?=number_format($prezzo,2,',','.');?> ›</a>                  
           <?php }  else {?> 
                     <a href="javascript:void(null)"  onclick="$('#addcarm<?=$listm['idprezzo'];?>').submit();">&euro; <?=number_format($prezzo,2,',','.');?> ›</a>              
           <?php }  ?>
           
           <!-- Form misura matrimoniale--> 
            <form id="addcarm<?=$listm['idprezzo'];?>" name="addcarm<?=$listm['idprezzo'];?>" method="POST" action="<?=BASE_URL;?>cross">
                 <input type="hidden" id="item" name="item" value="<?=$listm['idprezzo'];?>" /> 
      	   		 <input type="hidden" id="price" name="price" value="<?=$prezzo;?>" />
                 <input type="hidden" id="qty" name="qty" value="1" />
                 <input type="hidden" id="action" name="action" value="add" />
                 <input type="hidden" id="larghezza" name="larghezza" value="<?=$listm['larghezza'];?>" />
                 <input type="hidden" id="nome" name="nome" value="<?=$nomeprodotto;?>" />
                 <input type="hidden" id="nomepagina" name="nomepagina" value="<?=$listm['singolare']." ".$listm['alias_mis_std'];?>" />
                 <input type="hidden" id="lunghezza" name="lunghezza" value="<?= $listm['lunghezza'];?>" />
                 <input type="hidden" id="icona" name="icona" value="<?=BASE_URL;?>images/img_mis_stand/<?=$listm['logo_misura'];?>" />
                 <input type="hidden" id="image_name" name="image_name" value="<?= $list[$default] ;?>" />
                 <input type="hidden" id="description" name="description" value="<?= $list['descrizione_breve'] ;?>" />
                  <input type="hidden" id="url" name="url" value="<?=BASE_URL;?>prod/<?=strtolower(seo_url($nomeprodotto));?>_<?=$rewrite;?>" />
             </form>
            </span>
             </div>
            </div>
                        
                        
            <?php
            
           if($i%3==0 && $i!=$tot ){echo "</div><div class=\"field-group\">"; }
          else if($i==$tot){echo "</div>";}
             } ?>
            </div>         
		 <?php } ?>
						

  <?php  


      if($coeff>0 AND $coeff!='') {  //mostro il box misure personalizzate solo se ci sono
?>

	<div class="box-item measures-box">
								<div class="title" style="color:#000000;font-size:13px;font-weight:bolder;">Misure Personalizzate</div>
								<div class="content clearfix" >
                                    <div class="col-misure">
										<input type="text" name="misura_altezza" id="misura_altezza" class="daom" />
										<input type="text" name="misura_base" id="misura_base" class="daom" />
									</div><!--/.col-misure-->
									<div class="col-legenda" style="margin-bottom: 20px;">
									inserisci l'altezza (<b>A</b>)<br />
									inserisci la base (<b>B</b>)<br />
									premi calcola 
									</div><!--/.col-legenda-->
                                    <input type="submit" value="Calcola"  onclick="$('#result').load('<?=BASE_URL;?>loadprev.php  #data', {W:$('#misura_base').val(),H:$('#misura_altezza').val(),idprod:'<?=$idpage;?>'})"/>
				           <div id="result" style="float:right;"></div>				
                 
                          </div><!--/.content-->
  </div><!--/.box-item /.measures-box-->


<?php } ?>

						
                        </div><!--box-wrapper-->
					</section><!--/.step-item-2-->
					
                    <script>
                    $(document).ready(function() {
                       
                        jQuery(".daom").keydown(function(event) {  
                              // Allow: backspace, delete, tab and escape
                            if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || 
                                 // Allow: Ctrl+A
                                (event.keyCode == 65 && event.ctrlKey === true) || 
                                 // Allow: home, end, left, right
                                (event.keyCode >= 35 && event.keyCode <= 39)) {
                                     // let it happen, don't do anything
                                     return;
                            }
                            else {
                                // Ensure that it is a number and stop the keypress
                                if ( event.shiftKey|| (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 ) ) 
                                {
                           event.preventDefault(); 
                                }
                            }
                    });
                    });
                    
                    </script>
            </div>
            
            
            </div>
  </div>
		
	<?php }  else if($totassociati >0){ ?>

   	<div class="gal-r-box clearfix">
			
				<h2><?=$list['titolo_associati'];?></h2>
   <div class="clearfix">   
   
   <?php  
   	  
         if($listtotp['prezzo_offerta']>0 AND strtotime($listtotp['inizio_offerta']) >= strtotime(date('y-m-d')) AND strtotime($listtotp['scad_offerta']) <= strtotime(date('y-m-d')) ) 
           $prezzoprod=$listtotp['prezzo_offerta']; else $prezzoprod=$listtotp['prezzo']; 
     
   $x=0;
   while ($listassociati = mysql_fetch_array($resultassociati)){ $x++;
       
           $queryass= "SELECT *
                       FROM 
                       prodotti
                       WHERE id='".$listassociati['id_ass']."'
                       LIMIT 0,1
                       ";          
           $resultass = mysql_query($queryass); 
           $listass=mysql_fetch_array($resultass);
        
     
     $queryprezzoass= " SELECT prezzi.*,prezzi.id AS idprezzo
                         FROM 
                         prezzi
                         WHERE prezzi.id_prod='".$listassociati['id_ass']."'
                       ";
            
     $resultprezzoass= mysql_query($queryprezzoass) or die(mysql_error());
     $listprezzoass=mysql_fetch_array($resultprezzoass);
     
      if($listprezzoass['prezzo_offerta']>0 AND strtotime($listprezzoass['inizio_offerta']) >= strtotime(date('y-m-d')) AND strtotime($listprezzoass['scad_offerta']) <= strtotime(date('y-m-d')) ) 
      $prezzoass=$listprezzoass['prezzo_offerta']; else $prezzoass=$listprezzoass['prezzo'];
      if($x==1){ $prezzostart=$prezzoass; $nomepag=$listass['nome'];$iditem=$idpage.$listass['id'];} 
     
     
    ?>   

					<div onclick="$('#formprice').val(<?=$prezzoprod+$prezzoass;?>);
                                  $('#nomepagina').val('+ <?=$listass['nome'];?>');
                                  $('#item').val(<?=$idpage.$listass['id'];?>);
                                  $('#prezzofinale').html(formatNumber(parseFloat(<?=$prezzoprod+$prezzoass;?>),2,'.',',','','','-',''));
                                  $('.allimg').css('border-color','#dfdfdf');
                                  $('#prodimg<?=$listass['id'];?>').css('border-color','#003399');
                                  "  class="box-item photo-item " style="cursor: pointer;">
						<figure><img class="allimg" id="prodimg<?=$listass['id'];?>" <?php if($x==1) echo 'style="border-color:#003399;"'; ?>  src="<?=BASE_URL;?>images/img_prod/<?=$listass['img_mini_crop'];?>"  alt="<?=$listass['nome'];?>" />
                        <a href="<?=BASE_URL;?>images/img_prod/<?=$listass['img_mini'];?>" class="fancy zoom" rel="group" title="<?=$listass['nome'];?>"></a></figure>
						<figcaption><a href="<?=BASE_URL;?>prod/<?=strtolower(seo_url($listass['nome']));?>_<?=$listass['rewrite'];?>"><?=$listass['nome'];?> ›</a></figcaption>
					</div>
    
    <?php } 
    
     
    
    
    ?>
    	<div class="box-item price-item">
    					<div class="price">
							<span id="prezzofinale">&euro; <?=number_format($prezzoprod+$prezzostart,0,',','.');?></span>
							<small>iva inclusa</small>
						</div>
						<a href="javascript:void(null)" onclick="$('#addcar').submit();" class="button">Acquista ›</a>
        
        </div><!--/.price-item-->
         
        <form id="addcar" name="addcar" method="POST" action="<?=BASE_URL;?>cross">
         <input type="hidden" id="item" name="item" value="<?=$iditem;?>" /> 
   		 <input type="hidden" id="formprice" name="price" value="<?=$prezzoprod+$prezzoass;?>" />
         <input type="hidden" id="qty" name="qty" value="1" />
         <input type="hidden" id="action" name="action" value="add" />
         <input type="hidden" id="larghezza" name="larghezza" value="<?=$listtotp['larghezza'];?>" />
         <input type="hidden" id="nome" name="nome" value="<?=$nomeprodotto;?>" />
         <input type="hidden" id="nomepagina" name="nomepagina" value="+ <?=$nomepag;?>" />
         <input type="hidden" id="lunghezza" name="lunghezza" value="<?= $listtotp['lunghezza'];?>" />
         <input type="hidden" id="icona" name="icona" value="<?=BASE_URL;?>images/img_mis_stand/<?=$listico['logo_misura'];?>" />
         <input type="hidden" id="image_name" name="image_name" value="<?= $list[$default] ;?>" />
         <input type="hidden" id="description" name="description" value="<?= $list['descrizione_breve'] ;?>" />
         <input type="hidden" id="url" name="url" value="<?=BASE_URL;?>prod/<?=strtolower(seo_url($nomeprodotto));?>_<?=$rewrite;?>" />
        </form>
				</div>
    </div><!--/.gal-r-box-->
    <?php } ?>		
			
                
            
			<div class="prod-description-area">
			<?php if($list['sottotitolo1']!='')  {?>
				<div class="description-item clearfix">
					<div class="side-left">
						<h2><?=$list['sottotitolo1'];?></h2>
						<div class="description">
							<p><?=$list['descr_sottotitolo1'];?></p>
						</div><!--/.description-->
						<?php if($list['img_oriz1']!='') { ?>
                         <figure class="thumb">
                         <a  href="<?=BASE_URL;?>images/img_prod/<?=$list['img_oriz1'];?>" class="other"  title="<?=$list['img_oriz1_alt'];?>">
                         <img src="<?=BASE_URL;?>images/img_prod/<?=$list['img_oriz1_crop'];?>"  alt="<?=$list['img_oriz1_alt'];?>" />
                        </a>
                        </figure>
                        <?php } ?>
                       		
					</div><!--/.side-left-->
					<div class="side-right services-boxes">
					 <?php  if($totprezzi>1 || $totassociati >0){ ?>
                    
                    	<aside class="box-item">
							<div class="title ico-con"><?=$listser['tit_9_ser'];?></div>
							<div class="entry"><p><?=$listser['descr_9_ser'];?></p></div>
							<div class="clearfix"><a href="<?=$listser['linkac_9_ser'];?>" rel="<?=$listser['linkac_9_ser_rel'];?>" title="<?=$listser['linkac_9_ser_title'];?>" class="seemore"><?=$listser['linkac_9_ser_anch'];?></a></div>
						</aside><!--/.box-item-->
                     <?php } else if($totprezzi==1 && $totassociati ==0){ 
                        
                     $resultm  = mysql_query($querym) or die(mysql_error());
                     $listm=mysql_fetch_array($resultm);  
                     
                 
                     ?>
                        
                        <aside class="box-item price-item">
							<div class="price">
                            <? if($listtotp['prezzo_offerta']>0 AND strtotime($listtotp['inizio_offerta']) >= strtotime(date('y-m-d')) AND strtotime($listtotp['scad_offerta']) <= strtotime(date('y-m-d')) ) 
                               $prezzo=$listtotp['prezzo_offerta']; else $prezzo=$listtotp['prezzo']; 
                            ?>
								<span>&euro; <?=number_format($prezzo,0,',','.');?></span>
								<small>iva inclusa</small>
							</div>
							<a href="javascript:void(null)" onclick="$('#addcar').submit();" class="button">Acquista ›</a>
                    
                    <div  style="margin:10px 0px 0px 5px;font-size:12px;">Opinione dei clienti</div> 
                    <div class="basic" data-average="<?=$list['tot_voti']/$list['num_voti'];?>" data-id="<?=$idpage;?>" style="margin-left:5px;"></div>

                    <!-- JS to add -->
                    <script type="text/javascript">
                      $(document).ready(function(){
                    	$(".basic").jRating({
                        step:true,
                        length : 5, // nb of stars
                        showRateInfo:false,
                        decimalLength:1,
                        rateMax:5  
                       });
                      });
                    </script>
                    <div id="resultvoto" style="color:green;margin-top:10px;font-size:12px;"></div>
                        
                        </aside><!--/.price-item-->
     <form id="addcar" name="addcar" method="POST" action="<?=BASE_URL;?>cross">
         <input type="hidden" id="item" name="item" value="<?=$listtotp['idprezzo'];?>" /> 
   		 <input type="hidden" id="price" name="price" value="<?=$prezzo;?>" />
         <input type="hidden" id="qty" name="qty" value="1" />
         <input type="hidden" id="action" name="action" value="add" />
         <input type="hidden" id="larghezza" name="larghezza" value="<?=$listtotp['larghezza'];?>" />
         <input type="hidden" id="nome" name="nome" value="<?=$nomeprodotto;?>" />
         <input type="hidden" id="nomepagina" name="nomepagina" value="<?=$listico['singolare']." ".$listico['alias_mis_std'];?>" />
         <input type="hidden" id="lunghezza" name="lunghezza" value="<?= $listtotp['lunghezza'];?>" />
         <input type="hidden" id="icona" name="icona" value="<?=BASE_URL;?>images/img_mis_stand/<?=$listico['logo_misura'];?>" /><!--tonio-->
         <input type="hidden" id="image_name" name="image_name" value="<?= $list[$default] ;?>" />
         <input type="hidden" id="description" name="description" value="<?= $list['descrizione_breve'] ;?>" />
         <input type="hidden" id="url" name="url" value="<?=BASE_URL;?>prod/<?=strtolower(seo_url($nomeprodotto));?>_<?=$rewrite;?>" />
        </form>
                     <?php   } ?>
                     
						<aside class="box-item">
							<div class="title ico-prm"><?=$listser['tit_10_ser'];?></div>
							<div class="entry"><p><?=$listser['descr_10_ser'];?></p></div>
							<div class="clearfix"><a href="<?=$listser['linkac_10_ser'];?>" rel="<?=$listser['linkac_10_ser_rel'];?>" title="<?=$listser['linkac_10_ser_title'];?>"class="seemore"><?=$listser['linkac_10_ser_anch'];?></a></div>
						</aside><!--/.box-item-->
					</div><!--/.side-right-->
				</div><!--/.description-item-->
				<?php } ?>
   	            <?php if($list['sottotitolo2']!='')  {?>
				<div class="description-item clearfix">
					<div class="side-left">
						<h2><?=$list['sottotitolo2'];?></span></h2>
						<div class="description">
							<p><?=$list['descr_sottotitolo2'];?></p>
						</div><!--/.description-->
					   <?php if($list['img_oriz2']!='') { ?>	
                       <figure class="thumb">
                        <a  href="<?=BASE_URL;?>images/img_prod/<?=$list['img_oriz2'];?>" class="other"  title="<?=$list['img_oriz2_alt'];?>">
                         <img src="<?=BASE_URL;?>images/img_prod/<?=$list['img_oriz2_crop'];?>" alt="<?=$list['img_oriz2_alt'];?>" />
                        </a>
                        </figure>
                      <?php } ?>			
					</div><!--/.side-left-->
					<div class="side-right services-boxes">
						<aside class="box-item">
							<div class="title ico-pri"><?=$listser['tit_11_ser'];?></div>
							<div class="entry"><p><?=$listser['descr_11_ser'];?></p></div>
							<div class="clearfix"><a href="<?=$listser['linkac_11_ser'];?>" rel="<?=$listser['linkac_11_ser_rel'];?>"title="<?=$listser['linkac_11_ser_title'];?>" class="seemore"><?=$listser['linkac_11_ser_anch'];?></a></div>
						</aside><!--/.box-item-->
						<aside class="box-item">
							<div class="title ico-aco"><?=$listser['tit_12_ser'];?></div>
							<div class="entry"><p><?=$listser['descr_12_ser'];?></p></div>
							<div class="clearfix"><a href="<?=$listser['linkac_12_ser'];?>" rel="<?=$listser['linkac_12_ser_rel'];?>" title="<?=$listser['linkac_12_ser_title'];?>" class="seemore"><?=$listser['linkac_12_ser_anch'];?></a></div>
						</aside><!--/.box-item-->
					</div><!--/.side-right-->
				</div><!--/.description-item-->
                	<?php } ?>
           <?php if($list['sottotitolo3']!='')  {?>
				<div class="description-item clearfix">
					<div class="side-center">
						<h2><?=$list['sottotitolo3'];?></span></h2>
						<div class="description">
							<p><?=$list['descr_sottotitolo3'];?></p>
						</div><!--/.description-->
					<?php if($list['img_oriz3']!='') { ?>	
                       <figure class="thumb">
                        <a  href="<?=BASE_URL;?>images/img_prod/<?=$list['img_oriz3'];?>" class="other"  title="<?=$list['img_oriz3_alt'];?>">
                         <img src="<?=BASE_URL;?>images/img_prod/<?=$list['img_oriz3_crop'];?>" alt="<?=$list['img_oriz3_alt'];?>" />
                        </a>
                        </figure>
                   <?php } ?>  			
					</div><!--/.side-center-->
					<div class="side-right services-boxes">
						
					</div><!--/.side-right-->
				</div><!--/.description-item-->
                	<?php } ?>   
                     <?php if($list['sottotitolo4']!='')  {?>
				<div class="description-item clearfix">
					<div class="side-center">
						<h2><?=$list['sottotitolo4'];?></span></h2>
						<div class="description">
							<p><?=$list['descr_sottotitolo4'];?></p>
						</div><!--/.description-->
						<?php if($list['img_oriz4']!='') { ?>
                        <figure class="thumb">
                        <a  href="<?=BASE_URL;?>images/img_prod/<?=$list['img_oriz4'];?>" class="other"  title="<?=$list['img_oriz4_alt'];?>">
                         <img src="<?=BASE_URL;?>images/img_prod/<?=$list['img_oriz4_crop'];?>" alt="<?=$list['img_oriz4_alt'];?>" />
                        </a>
                        </figure>
                        <?php } ?>			
					</div><!--/.side-center-->
					<div class="side-right services-boxes">
						
					</div><!--/.side-right-->
				</div><!--/.description-item-->
                	<?php } ?>  
 
			</div><!--/.prod-description-area-->
			<div class="prod-description-area">
            
            
           	</div><!--/.prod-description-area-->
            
            
			<div class="prod-info-grid">
				
				<!-- INIZIO SEZIONE CARATTERISTICHE 1 E 2 -->
                <?php if($list['sez_1_titolo']!='' AND $list['sez_2_titolo']!='') {?>
                <div class="row clearfix">
					<div class="info-item">
						<h3><?=$list['sez_1_titolo'];?></h3>
						<div class="subtitle"><?=$list['sez_1_sottotitolo'];?></div>
						<div class="description"><?=$list['sez_1_descr'];?> 
                        <?php if($list['sez_1_link']!='') {?>
                        <a href="<?=$list['sez_1_link'];?>" class="seemore" rel="<?=$list['sez_1_rel'];?>" title="<?=$list['sez_1_title'];?>" ><?=$list['sez_1_anchor'];?></a>
                        <?php } ?> 
                        </div><!--/.description-->
						<?php if($list['img_1']!='') { ?>
                        <figure>
                         <!--<a  href="<?=BASE_URL;?>images/img_prod/<?=$list['img_1'];?>"   title="<?=$list['sez_1_title'];?>">-->
                         <img src="<?=BASE_URL;?>images/img_prod/<?=$list['img_1_crop'];?>"  alt="<?=$list['img_1_alt'];?>" />
                        <!--</a>-->
                        </figure>
                        <?php } ?> 
					</div><!--/.info-item-->
					<div class="info-item">
						<h3><?=$list['sez_2_titolo'];?></h3>
						<div class="subtitle"><?=$list['sez_2_sottotitolo'];?></div>
						<div class="description"><?=$list['sez_2_descr'];?> 
                         <?php if($list['sez_2_link']!='') {?>
                        <a href="<?=$list['sez_2_link'];?>" class="seemore" rel="<?=$list['sez_2_rel'];?>" title="<?=$list['img_2_title'];?>"><?=$list['sez_2_anchor'];?></a>
                        <?php } ?>
                        </div><!--/.description-->
						<?php if($list['img_2']!='') { ?>
                         <figure>
                         <!--<a  href="<?=BASE_URL;?>images/img_prod/<?=$list['img_2'];?>"   title="<?=$list['sez_2_title'];?>">-->
                         <img src="<?=BASE_URL;?>images/img_prod/<?=$list['img_2_crop'];?>"  alt="<?=$list['img_2_alt'];?>" />
                        <!--</a>-->
                          </figure>
                        <?php } ?>
					</div><!--/.info-item-->
				</div><!--/.row-->
                
              <?php   }  ?>
			  <!-- FINE SEZIONE CARATTERISTICHE 1 E 2 -->
			  
			  <!-- INIZIO SEZIONE CARATTERISTICHE 3 E 4 -->
			  <?php if($list['sez_3_titolo']!='' AND $list['sez_4_titolo']!='') {?>
            	<div class="row clearfix">
					<div class="info-item">
						<h3><?=$list['sez_3_titolo'];?></h3>
						<div class="subtitle"><?=$list['sez_3_sottotitolo'];?></div>
						<div class="description"><?=$list['sez_3_descr'];?> 
                         <?php if($list['sez_3_link']!='') {?>
                        <a href="<?=$list['sez_3_link'];?>" class="seemore" rel="<?=$list['sez_3_rel'];?>" title="<?=$list['img_3_title'];?>"><?=$list['sez_3_anchor'];?></a>
                        <?php } ?>
                        </div><!--/.description-->
						 <?php if($list['img_3']!='') { ?>
                         <figure><!--<a  href="<?=BASE_URL;?>images/img_prod/<?=$list['img_3'];?>"   title="<?=$list['sez_3_title'];?>">-->
                         <img src="<?=BASE_URL;?>images/img_prod/<?=$list['img_3_crop'];?>"  alt="<?=$list['img_3_alt'];?>" />
                        <!--</a>--></figure>
                        <?php } ?>
					</div><!--/.info-item-->
					<div class="info-item">
						<h3><?=$list['sez_4_titolo'];?></h3>
						<div class="subtitle"><?=$list['sez_4_sottotitolo'];?></div>
						<div class="description"><?=$list['sez_4_descr'];?> 
                         <?php if($list['sez_4_link']!='') {?>
                        <a href="<?=$list['sez_4_link'];?>" class="seemore" rel="<?=$list['sez_4_rel'];?>" title="<?=$list['sez_4_title'];?>" ><?=$list['sez_4_anchor'];?></a>ù
                        <?php } ?>
                        </div><!--/.description-->
						<?php if($list['img_4']!='') { ?>
                          <figure><!--<a  href="<?=BASE_URL;?>images/img_prod/<?=$list['img_4'];?>"   title="<?=$list['sez_4_title'];?>">-->
                         <img src="<?=BASE_URL;?>images/img_prod/<?=$list['img_4_crop'];?>"  alt="<?=$list['img_4_alt'];?>" />
                        <!--</a>--></figure>
                        <?php } ?>
					</div><!--/.info-item-->
				</div><!--/.row-->
                 <?php   }  ?>
				 <!-- FINE SEZIONE CARATTERISTICHE 3 E 4 -->
				 
				 <!-- INIZIO SEZIONE CARATTERISTICHE 5 E 6 --> 
				 <?php if($list['sez_5_titolo']!='' AND $list['sez_6_titolo']!='') {?>
            	<div class="row clearfix">
					<div class="info-item">
						<h3><?=$list['sez_5_titolo'];?></h3>
						<div class="subtitle"><?=$list['sez_5_sottotitolo'];?></div>
						<div class="description"><?=$list['sez_5_descr'];?> 
                         <?php if($list['sez_5_link']!='') {?>
                        <a href="<?=$list['sez_5_link'];?>" class="seemore" rel="<?=$list['sez_5_rel'];?>" title="<?=$list['img_5_title'];?>"><?=$list['sez_5_anchor'];?></a>
                        <?php } ?>
                        </div><!--/.description-->
						<?php if($list['img_5']!='') { ?>
                        <figure><!--<a  href="<?=BASE_URL;?>images/img_prod/<?=$list['img_5'];?>"   title="<?=$list['sez_5_title'];?>">-->
                         <img src="<?=BASE_URL;?>images/img_prod/<?=$list['img_5_crop'];?>"  alt="<?=$list['img_5_alt'];?>" />
                        <!--</a>--></figure> 
                        <?php } ?>
					</div><!--/.info-item-->
					<div class="info-item">
						<h3><?=$list['sez_6_titolo'];?></h3>
						<div class="subtitle"><?=$list['sez_6_sottotitolo'];?></div>
						<div class="description"><?=$list['sez_6_descr'];?> 
                         <?php if($list['sez_6_link']!='') {?>
                        <a href="<?=$list['sez_6_link'];?>" class="seemore" rel="<?=$list['sez_6_rel'];?>" title="<?=$list['sez_6_title'];?>" ><?=$list['sez_6_anchor'];?></a>ù
                        <?php } ?>
                        </div><!--/.description-->
						<?php if($list['img_6']!='') { ?>
                        <figure><!--<a  href="<?=BASE_URL;?>images/img_prod/<?=$list['img_6'];?>"   title="<?=$list['sez_6_title'];?>">-->
                         <img src="<?=BASE_URL;?>images/img_prod/<?=$list['img_6_crop'];?>"  alt="<?=$list['img_6_alt'];?>" />
                        <!--</a>--></figure>
                        <?php } ?> 
					</div><!--/.info-item-->
				</div><!--/.row-->
                 <?php   }  ?>
				 <!-- FINE SEZIONE CARATTERISTICHE 5 E 6 -->
				 
                  <!-- INIZIO SEZIONE CARATTERISTICHE 7 E 8 --> 
				 <?php if($list['sez_7_titolo']!='' AND $list['sez_8_titolo']!='') {?>
            	<div class="row clearfix">
					<div class="info-item">
						<h3><?=$list['sez_7_titolo'];?></h3>
						<div class="subtitle"><?=$list['sez_7_sottotitolo'];?></div>
						<div class="description"><?=$list['sez_7_descr'];?> 
                         <?php if($list['sez_7_link']!='') {?>
                        <a href="<?=$list['sez_7_link'];?>" class="seemore" rel="<?=$list['sez_7_rel'];?>" title="<?=$list['img_7_title'];?>"><?=$list['sez_7_anchor'];?></a>
                        <?php } ?>
                        </div><!--/.description-->
						<?php if($list['img_7']!='') { ?>
                         <figure><!--<a  href="<?=BASE_URL;?>images/img_prod/<?=$list['img_7'];?>"   title="<?=$list['sez_7_title'];?>">-->
                         <img src="<?=BASE_URL;?>images/img_prod/<?=$list['img_7_crop'];?>"  alt="<?=$list['img_7_alt'];?>" />
                        <!--</a>--></figure> 
                         <?php } ?>
					</div><!--/.info-item-->
					<div class="info-item">
						<h3><?=$list['sez_8_titolo'];?></h3>
						<div class="subtitle"><?=$list['sez_8_sottotitolo'];?></div>
						<div class="description"><?=$list['sez_8_descr'];?> 
                         <?php if($list['sez_8_link']!='') {?>
                        <a href="<?=$list['sez_8_link'];?>" class="seemore" rel="<?=$list['sez_8_rel'];?>" title="<?=$list['sez_8_title'];?>" ><?=$list['sez_8_anchor'];?></a>ù
                        <?php } ?>
                        </div><!--/.description-->
						<?php if($list['img_8']!='') { ?><figure><!--<a  href="<?=BASE_URL;?>images/img_prod/<?=$list['img_8'];?>"   title="<?=$list['sez_8_title'];?>">-->
                         <img src="<?=BASE_URL;?>images/img_prod/<?=$list['img_8_crop'];?>"  alt="<?=$list['img_8_alt'];?>" />
                        <!--</a>--></figure> <?php } ?>
					</div><!--/.info-item-->
				</div><!--/.row-->
                 <?php   }  ?>
				 <!-- FINE SEZIONE CARATTERISTICHE 7 E 8 -->
                 
			</div><!--/.prod-info-grid-->
			 	<div class="prod-description-area">
               <?php if($list['sottotitolo5']!='')  {?>
				<div class="description-item clearfix" style="margin-bottom: 30px;">
					<div class="side-center">
						<h2><?=$list['sottotitolo5'];?></span></h2>
						<div class="description">
							<p><?=$list['descr_sottotitolo5'];?></p>
						</div><!--/.description-->
						<?php if($list['img_oriz5']!='') { ?>
                        <figure class="thumb">
                        <a  href="<?=BASE_URL;?>images/img_prod/<?=$list['img_oriz5'];?>" class="other"  title="<?=$list['img_oriz5_alt'];?>">
                         <img src="<?=BASE_URL;?>images/img_prod/<?=$list['img_oriz5_crop'];?>" alt="<?=$list['img_oriz5_alt'];?>" />
                        </a>
                        </figure>
                        <?php } ?>			
					</div><!--/.side-center-->
					<div class="side-right services-boxes">
						
					</div><!--/.side-right-->
				</div><!--/.description-item-->
                	<?php } ?>
                 </div>  
                 
                 <?php
                 
                 $querylav="SELECT * FROM title_lavaggi";
                 $resultlav=mysql_query($querylav) or die(mysql_error);
                 $listlav=mysql_fetch_array($resultlav);
                 
                 ?>
                  
			<div class="box-uso">
			  <?php if($idmacro!='55'){ ?>	
     
            <div class="wash-row clearfix">
            <?php
                 $r=0;
                 $querylavt="SELECT  lavaggi.*,tag.* 
                             FROM lavaggi ,tag
                             WHERE 
                             tag.id=lavaggi.id_tag
                             AND lavaggi.rivestimento='s'
                             AND lavaggi.id_prod='".$idpage."' 
                             GROUP BY tag.singolare";
                 $resultlavt=mysql_query($querylavt) or die(mysql_error);
                 $totl=mysql_num_rows($resultlavt);
              

              if ($totl>0) { ?>


                	<div class="col box-wash">
						<h4><?=$listlav['titolo1'];?></h4>
              <p>  
              <?php
                 
                 while ($listlavt=mysql_fetch_array($resultlavt)){$r++;
                 if($r!=$totl ) echo  $listlavt['singolare']." , "; else echo $listlavt['singolare']; 
                 }
                 
                 ?>
                        </p>
						<div class="wash-icons">
							<!--METTERE ICONE CARICATE DINAMICAMENTE, UNA DOPO L'ALTRA, ALTEZZA CONSIGLIATA 50px, LARGEZZA VARIABILE-->
				<?php		
                $resultlavt=mysql_query($querylavt) or die(mysql_error);
                 while ($listlavt=mysql_fetch_array($resultlavt)){?>
               <img src="<?=BASE_URL;?>images/img_tag/<?=$listlavt['image'];?>" />
               <?php  }	?>         
    
						</div><!--/.wash-icons-->
					</div><!--/.col-->

                <?php }
                
                  $r=0;
                                 $querylavt="SELECT lavaggi.*,tag.* 
                                             FROM lavaggi ,tag
                                             WHERE 
                                             tag.id=lavaggi.id_tag
                                             AND lavaggi.struttura='s'
                                             AND lavaggi.id_prod='".$idpage."'
                                             GROUP BY tag.singolare";
                                 $resultlavt=mysql_query($querylavt) or die(mysql_error);
                                 $totl=mysql_num_rows($resultlavt);
               if ($totl>0) { ?> 
                

					<div class="col box-wash">
						<h4><?=$listlav['titolo2'];?></h4>
					<p>	  <?php
               
                 while ($listlavt=mysql_fetch_array($resultlavt)){$r++;
                 if($r!=$totl ) echo  $listlavt['singolare']." , "; else echo $listlavt['singolare']; 
                 }
                 
                 ?>
                 </p>
						<div class="wash-icons">
							<?php		
                $resultlavt=mysql_query($querylavt) or die(mysql_error);
                 while ($listlavt=mysql_fetch_array($resultlavt)){?>
               <img src="<?=BASE_URL;?>images/img_tag/<?=$listlavt['image'];?>" />
               <?php  }	?>   
						</div><!--/.wash-icons-->
					</div><!--/.col-->
               <?php } ?>


				</div><!--/.wash-row-->
              <?php } ?>  
				<div class="text-row">
					<div class="box-wash">
						<h4><?=$listlav['titolo3'];?></h4>
						<p><?=$listcloud['note'];?></p>
						<div class="wash-icons">
							<!--METTERE ICONE CARICATE DINAMICAMENTE, UNA DOPO L'ALTRA, ALTEZZA CONSIGLIATA 50px, LARGEZZA VARIABILE-->
							
						</div><!--/.wash-icons-->
					</div><!--/.box-wash-->
				</div><!--/.text-row-->
			</div><!--/.box-uso-->
		            
		   <div class="illustrated-nav col-3 clearfix">
  
            
            	<div class="col-item clearfix">
					<figure>
                    <img src="<?=BASE_URL;?>images/<?=$listser['image_1'];?>"  alt="<?=$listser['alt_image_1'];?>" />
                    </figure>
					<div class="entry">
						<div class="title"><?=$listser['tit_1'];?></div>
						<div class="clearfix">
                        <a  rel="<?=$listser['rel_image_1'];?>" href="<?=$listser['link_image_1'];?>" class="seemore" title="<?=$listser['title_image_1'];?>"><?=$listser['anchor_image_1'];?></a>
                        </div>
					</div><!--/.entry-->
				</div><!--/.col-item-->
   	            <div class="col-item clearfix">
					<figure>
                    <img src="<?=BASE_URL;?>images/<?=$listser['image_2'];?>"  alt="<?=$listser['alt_image_2'];?>" />
                    </figure>
					<div class="entry">
						<div class="title"><?=$listser['tit_2'];?></div>
						<div class="clearfix">
                        <a  rel="<?=$listser['rel_image_2'];?>" href="<?=$listser['link_image_2'];?>" class="seemore" title="<?=$listser['title_image_2'];?>"><?=$listser['anchor_image_2'];?></a>
                        </div>
					</div><!--/.entry-->
				</div><!--/.col-item-->
               <div class="col-item clearfix">
					<figure>
                    <img src="<?=BASE_URL;?>images/<?=$listser['image_3'];?>"  alt="<?=$listser['alt_image_3'];?>" />
                    </figure>
					<div class="entry">
						<div class="title"><?=$listser['tit_3'];?></div>
						<div class="clearfix">
                        <a  rel="<?=$listser['rel_image_3'];?>" href="<?=$listser['link_image_3'];?>"  class="seemore" title="<?=$listser['title_image_3'];?>"><?=$listser['anchor_image_3'];?></a>
                        </div>
					</div><!--/.entry-->
				</div><!--/.col-item-->
	
                <!--/.col-item-->
			</div><!--/.illustrated-nav-->
			
							<section class="services-boxes">
				<div class="box-wrapper borderless clearfix"><!--/classe borderless rimuove separatore-->
					<div class="box-item">
						<div class="title ico-acq"><?=$listser['tit_1_ser'];?></div>
						<div class="entry"><p><?=$listser['descr_1_ser'];?></p></div>
						<div class="clearfix"><a href="<?=$listser['linkac_1_ser'];?>" class="seemore" rel="<?=$listser['linkac_1_ser_rel'];?>" title="<?=$listser['linkac_1_ser_title'];?>"><?=$listser['linkac_1_ser_anch'];?></a></div>
					</div><!--/.box-item-->
					<div class="box-item">
						<div class="title ico-sic"><?=$listser['tit_2_ser'];?></div>
						<div class="entry"><p><?=$listser['descr_2_ser'];?></p></div>
						<div class="clearfix"><a href="<?=$listser['linkac_2_ser'];?>" class="seemore" rel="<?=$listser['linkac_2_ser_rel'];?>" title="<?=$listser['linkac_2_ser_title'];?>"><?=$listser['linkac_2_ser_anch'];?></a></div>
					</div><!--/.box-item-->
					<div class="box-item">
						<div class="title ico-con"><?=$listser['tit_3_ser'];?></div>
						<div class="entry"><p><?=$listser['descr_3_ser'];?></p></div>
						<div class="clearfix"><a href="<?=$listser['linkac_3_ser'];?>" class="seemore" rel="<?=$listser['linkac_3_ser_rel'];?>" title="<?=$listser['linkac_3_ser_title'];?>"><?=$listser['linkac_3_ser_anch'];?></a></div>
					</div><!--/.box-item-->
					<div class="box-item">
						<div class="title ico-gar"><?=$listser['tit_4_ser'];?></div>
						<div class="entry"><p><?=$listser['descr_4_ser'];?></p></div>
						<div class="clearfix"><a href="<?=$listser['linkac_4_ser'];?>" class="seemore" rel="<?=$listser['linkac_4_ser_rel'];?>" title="<?=$listser['linkac_4_ser_title'];?>"><?=$listser['linkac_4_ser_anch'];?></a></div>
					</div><!--/.box-item-->
				</div><!--/.box-wrapper-->
				<div class="box-wrapper clearfix">
					<div class="box-item">
						<div class="title ico-gmi"><?=$listser['tit_5_ser'];?></div>
						<div class="entry"><p><?=$listser['descr_5_ser'];?></p></div>
						<div class="clearfix"><a href="<?=$listser['linkac_5_ser'];?>" class="seemore" rel="<?=$listser['linkac_5_ser_rel'];?>" title="<?=$listser['linkac_5_ser_title'];?>"><?=$listser['linkac_5_ser_anch'];?></a></div>
					</div><!--/.box-item-->
					<div class="box-item">
						<div class="title ico-tpe"><?=$listser['tit_6_ser'];?></div>
						<div class="entry"><p><?=$listser['descr_6_ser'];?></p></div>
						<div class="clearfix"><a href="<?=$listser['linkac_6_ser'];?>" class="seemore" rel="<?=$listser['linkac_6_ser_rel'];?>" title="<?=$listser['linkac_6_ser_title'];?>"><?=$listser['linkac_6_ser_anch'];?></a></div>
					</div><!--/.box-item-->
					<div class="box-item">
						<div class="title ico-cut"><?=$listser['tit_7_ser'];?></div>
						<div class="entry"><p><?=$listser['descr_7_ser'];?></p></div>
						<div class="clearfix"><a href="<?=$listser['linkac_7_ser'];?>" class="seemore" rel="<?=$listser['linkac_7_ser_rel'];?>" title="<?=$listser['linkac_7_ser_title'];?>"><?=$listser['linkac_7_ser_anch'];?></a></div>
					</div><!--/.box-item-->
					<div class="box-item">
						<div class="title ico-ras"><?=$listser['tit_8_ser'];?></div>
						<div class="entry"><p><?=$listser['descr_8_ser'];?></p></div>
						<div class="clearfix"><a href="<?=$listser['linkac_8_ser'];?>" class="seemore" rel="<?=$listser['linkac_8_ser_rel'];?>" title="<?=$listser['linkac_8_ser_title'];?>"><?=$listser['linkac_8_ser_anch'];?></a></div>
					</div><!--/.box-item-->
				</div><!--/.box-wrapper-->
			</section><!--/.services-boxes-->
		</div><!--.inner-wrapper-->
		
		<?php include("inc/inc-main-footer.php");?>
		
	</article><!--/.page-dettaglio-prodotto-->
</div><!--/#main-wrapper-->


<script src="<?=BASE_URL;?>js/fancybox/jquery.fancybox.pack.js"></script>
<script src="<?=BASE_URL;?>js/custom.js"></script>
<script>
$(function(){
    $(".other").fancybox();
	$(".fancy").fancybox();
    $("a#inline").fancybox({
		'hideOnContentClick': true
	});
    $("a#persmis").fancybox({
		'hideOnContentClick': true
	});
     $(".askalt").each(function() {
        
        var idform=$(this).attr('for');
     
     $(this).fancybox({
        
    'beforeLoad' : function(){$("#selaltezza").load('<?=BASE_URL;?>popup-rete-doghe.php #data', {idform:idform,fuorimis:'<?=$list['fuori_misura_piedi'];?>',mispied:'<?=$list['misura_unica_piedi'];?>'}, function(){
     
         jQuery("#altramis").keydown(function(event) {  
                        // Allow: backspace, delete, tab and escape
                        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || 
                        // Allow: Ctrl+A
                        (event.keyCode == 65 && event.ctrlKey === true) || 
                        // Allow: home, end, left, right
                        (event.keyCode >= 35 && event.keyCode <= 39)) {
                        // let it happen, don't do anything
                        return;
                                                                         }
        else {
            // Ensure that it is a number and stop the keypress
            if ( event.shiftKey|| (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 ) ) 
            {event.preventDefault();}
                 }
                                                                 });
                                                                 
     
                $('#inviaalt').click(function() {                            
                            if($('input[name=test_cm]:checked').val()==0){ 
                                 if($("#altramis").val()==''){alert('Attenzione devi inserire l\' altezza della rete');}
                                 else{
                                  var prezzo =parseFloat($("form#"+idform+" #price").val());   
                                  prezzo =parseFloat(prezzo+25); 
                                  $("form#"+idform+" #price").val(prezzo);   
                                  $("form#"+idform+" #nomepagina").val($("form#"+idform+" #nomepagina").val()+' H'+$("#altramis").val());
                                  $("form#"+idform+" #item").val($("form#"+idform+" #item").val()+$("#altramis").val());  
                                  $('#'+idform).submit();
                                    }
                             
                            
                                                                          } 
                            else{ 
                                
                              $("form#"+idform+" #nomepagina").val($("form#"+idform+" #nomepagina").val()+' H'+$('input[name=test_cm]:checked').val());           
                              $("form#"+idform+" #item").val($("form#"+idform+" #item").val()+$("#altramis").val());
                              $('#'+idform).submit();  
                                }    
                            
                                                                   }) }
    );}
	});
    });
	menuHoverSize();
	bigSlider();
	tagarrow();
});
</script>
</body>
</html>