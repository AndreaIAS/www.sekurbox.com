<?php
require ("config.php");
require ("inc_header.php");


if (isset($_REQUEST['opt'])) {$todo = $_REQUEST['opt']; }
else   $todo = 'view';

?>

<script type="text/javascript" src="<?=BASE_URL;?>js/uploadify/jquery.uploadify.js"></script>
<script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=BASE_URL;?>js/custom/general.js"></script>
<script type="text/javascript" src="<?=BASE_URL;?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?=BASE_URL;?>js/plugins/charCount.js"></script>
<script type="text/javascript" src="<?=BASE_URL;?>js/plugins/ui.spinner.min.js"></script>
<script type="text/javascript" src="<?=BASE_URL;?>js/plugins/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?=BASE_URL;?>js/custom/forms.js"></script>
<script type="text/javascript" src="<?=BASE_URL;?>js/plugins/tooltip.jquery.js"></script>
<script type="text/javascript" src="<?=BASE_URL;?>js/plugins/tinymce/jquery.tinymce.js"></script>
<script type="text/javascript" src="<?=BASE_URL;?>js/custom/editor.js"></script>
<link rel="stylesheet" type="text/css" href="<?=BASE_URL;?>js/uploadify/uploadify.css" />

<style>
.stdform label{width: 100px; text-align:right;padding:0px 10px 0px 0px;}
.stdform span.field, .stdform div.field { margin-left: 20px;}
</style>


</head>

<body>

<?php  



require("inc_menu.php"); 
require("inc_leftside.php"); 

     
     $query = "SELECT * FROM confrontaprod";
     $result = mysql_query($query);
     $list=mysql_fetch_array($result);
    
?>

    <div class="centercontent">

        <div class="pageheader">
        <h1 class="pagetitle">Confronta Prodotti</h1>
        </div>

        <div id="contentwrapper" class="contentwrapper">
                	
        <div id="formbasic" class="subcontent">
          

                  <form id="form_tag" class="stdform" action="javascript:void(null)" method="post" >                     
                      <input name="function" value="editconfprod" type="hidden" /> 
                       <input name="id" value="2" type="hidden" />           
                         <p>
                        	<b>Titolo</b><br />
                            <span class="field"><input type="text" name="titolo" id="titolo" class="smallinput" value="<?=$list['titolo'];?>"/></span>
                        </p>
                        
                         <p>
                        	<b>Title</b><br />
                            <span class="field"><input type="text" name="title" id="pag_title" class="smallinput" value="<?=$list['title'];?>"/></span>
                        </p>
                        <p>
                        	<b>Description</b><br />
                            <span class="field"><input type="text" name="description" id="description" class="smallinput" value="<?=$list['description'];?>"/></span>
                        </p>
                        <p>
                        	<b>Keywords</b><br />
                            <span class="field"><input type="text" name="keywords" id="keywords" class="smallinput" value="<?=$list['keywords'];?>"/></span>
                        </p>
                        <p>
                        	<b>Url Rewrite</b><br />
                            <span class="field"><input type="text" name="rewrite" id="rewrite" class="smallinput" value="<?=$list['rewrite'];?>"/></span>
                        </p>
                        <p>
                        	<b>Canonical</b><br />
                            <span class="field"><input type="text" name="canonical" id="canonical" class="smallinput" value="<?=$list['canonical'];?>"/></span>
                        </p>    
                       
                        <p>
                        	<b>Sottotitolo</b><br />
                            <span class="field">
                            <textarea id="testo" name="testo" rows="15" cols="20" style="width:100px;" class="tinymce">
                            <?=$list['testo'];?>
                            </textarea> 
                            </span>
                        </p>
                      
                        <p class="stdformbutton" style="margin-left:470px;">
                        	<button id="submit" class="submit radius2" >Submit Button</button>
                        </p>
                        <p>
                        <div id="err_mess"></div>
                        </p>
                     </form>
                     </div> 

        </div> 

    </div>

<script>

jQuery("#submit").click(  

function () {
   
  
 jQuery.post("<?=BASE_URL;?>execute.php",jQuery("#form_tag").serialize(),
      function(data) {  
   
                    //Se ci sono errori in fase di registrazione 
                    if(data.errore!='no'){
                        
                    jQuery('#err_mess').html('<div style="color:red;">'+data.errore+'</div>').fadeIn(1000);    
                    }  
                     else { 
                        
                     jQuery('#err_mess').html('<div style="color:green;">Operazione effettuata correttamente</div>').fadeIn(1000);    
                     setTimeout(function(){window.location.href = "confronta-prod.php";},1500); 
                            
                           }
                                      
                     }, 
      
      "json"
      );
 
           } 
                  );

</script>      