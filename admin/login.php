<?php
require ("config.php");
require ("inc_header.php");
?>
<!--<script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.uniform.min.js"></script>-->
<script type="text/javascript" src="<?=BASE_URL;?>js/custom/general.js"></script>
<script type="text/javascript" src="<?=BASE_URL;?>js/custom/index.js"></script>
</head>

<body class="loginpage"> 
	<div class="loginbox">
            <div class="loginboxinner" style="background: inherit">
        	
            <div class="logo">
            	<img src="<?=BASE_URL;?>images/logosek.png" />
               
            </div><!--logo-->
            
            <br clear="all" /><br />
            
            <div class="nousername">
				<div class="loginmsg">Username errato.</div>
            </div><!--nousername-->
            
            <div class="nopassword">
				<div class="loginmsg">Password errata.</div>
                <div class="loginf">
                    <div class="thumb"><img alt="" src="images/thumbs/avatar1.png" /></div>
                    <div class="userlogged">
                        <h4></h4>
                        <a href="index.html">Not <span></span>?</a> 
                    </div>
                </div><!--loginf-->
            </div><!--nopassword-->
            
            <form id="signupForm"  action="javascript:void(null);" method="POST">
             <input name="function" type="hidden" value="login"/>	
                <div class="username">
                	<div class="usernameinner">
                    	<input type="text" name="username" id="username" />
                    </div>
                </div>
                
                <div class="password">
                	<div class="passwordinner">
                    	<input type="password" name="password" id="password" />
                    </div>
                </div>
                
                <button id="login">Entra</button>
                
              <!--
  <div class="keep"><input type="checkbox" /> Keep me logged in</div>
-->
            
            </form>
            
        </div><!--loginboxinner-->
    </div><!--loginbox-->


</body>


<script type="text/javascript">

jQuery(document).ready(function() {

        jQuery("#login").click(   
        
        function () {
        //  alert(jQuery("#signupForm").serialize());
         jQuery.post("<?=BASE_URL;?>functionload.php",jQuery("#signupForm").serialize(),
              
              function(data) {                        
                            //Se ci sono errori in fase di registrazione 
                            if(data.errore!='no'){
                            switch(data.errore){
        
                              case "request": {if(data.campo=="username") {jQuery('.nousername').fadeIn('slow');  }
                                               else{jQuery('.nopassword').fadeIn('slow');    }  }
                                    break;
                                    
                              case "notmatch":{
                                
                                           if(data.campo=='password'){ jQuery('.nopassword').fadeIn('slow'); }
                                           else                      { jQuery('.nousername').fadeIn('slow');                                          }     
                                                 } 
                                    break;
       
                              default: caption ="default";
                                              
                                                  }                 
                             
                                                 }  
                             else { 
                              
                                  setTimeout(function(){window.location.href = "categorie.php";},500); 
                                  
                                  }
                                              
                             }, 
              
              "json"
              );
         
                   } 
                          );


 });
 
</script>


</html>

