<?php
    require ("config.php");
    require ("inc_header.php");    
    if (isset($_REQUEST['opt'])) $todo = $_REQUEST['opt']; else   $todo = 'view';
?>


    <script type="text/javascript" src="<?=BASE_URL;?>js/custom/general.js"></script>
<!--    <script type="text/javascript" src="<?=BASE_URL;?>js/custom/tables.js"></script>-->
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.tagsinput.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/charCount.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/ui.spinner.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/tooltip.jquery.js"></script>
<!--    <script type="text/javascript" src="<?=BASE_URL;?>js/custom/editor.js"></script> -->
 

    <!-- Add fancyBox -->
    <link rel="stylesheet" href="<?=BASE_URL;?>js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
    <script type="text/javascript" src="<?=BASE_URL;?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

    <style>
    .stdform label{width: 100px; text-align:right;padding:0px 0px 0px 0px;}
    .stdform span.field, .stdform div.field { margin-left: 0px;}
       .input-group-btn a.btn{
        background-image:inherit;
        margin-left: 0px;
   
    }
      .input-group-btn a.btn span{
        padding: 0px 5px;
        margin-left: 0px;
        display: inherit;
    }
    </style>


</head>

<body>


<?php  

require("inc_menu.php"); 
require("inc_leftside.php"); 

?>      

       

<?php          
//INIZIO MODIFICA PRODOTTO

     $db->query("SELECT * FROM slider_home ");
     $list=$db->single();
        
     ?>

    <div class="centercontent">   


        <div id="contentwrapper" class="contentwrapper">           	
        <div id="formbasic" class="subcontent">
          

                     <form id="form_prodotti" class="stdform" action="javascript:void(null)" method="post">
                      
                      <input name="function" id="function" value="editsliderhome" type="hidden" />
                     
                       <div class="contenttitle2"><h3>SLIDER HOME</h3></div><!--contenttitle--><br />
<!--                       <span style="color:red;font-size:16px;">Inserire immagini di dimensioni 1170x500 pixel</span>-->
                       
                       <?php for($i=1;$i<=5; $i++){ ?>
                       
                        <p style="width:40%">
		        <b>Immagine <?=$i;?> (1920x909)</b><br />        
                         <?php  if($list['img'.$i]!=''){ ?>
                        <a href="../upload/slider/<?=$list['img'.$i];?>" data-lightbox="immagine" >
                            <img src="../upload/slider/<?=$list['img'.$i];?>" style='width:100px;'/>  
                        </a>
                         <?php } ?>
                        <input  class="img_file" accept="*" name="img_file" for="<?=$i;?>" type="file"   >
                         
                       </p>
                
                       <p>
		       <b>Link immagine <?=$i;?></b><br />
                       <input type="text" name="link_img<?=$i;?>" id="link_img<?=$i;?>" class="smallinput" value="<?=$list['link_img'.$i];?>"  />
                       </p>
                       
                       
                      <?php } ?>
                

                    
                    <p class="stdformbutton" style="margin-left:470px;">
                        <button id="submit" class="submit radius2">Salva</button>
                    </p>
                        <p>
                    <div id="err_mess"></div>
                        </p>

                        </form>


                     </div> 
        

        </div> 

  </div> 



<script>


</script>  
<script type="text/javascript" src="<?=BASE_URL;?>funzionijs/slider_home.js"></script>
 <script src="<?=BASE_URL;?>lightbox/js/lightbox.js" type="text/javascript"></script>  
 <link href="<?=BASE_URL;?>lightbox/css/lightbox.css" rel="stylesheet"> 
</body>

</html>
      