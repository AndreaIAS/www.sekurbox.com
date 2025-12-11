<div class="form_intestazione"><?php echo $titolo_login;?></div>
<?php
	if (isset($error)) {
	echo "<p>" . $error . "</p>";
}
?>
<form method="post" action="http://www.sekurbox.com/<?php echo $lingua;?>/login.html">
    <div class="form_row"><label>Email</label></div>                       
    <div class="form_row"><input name="email" type="text" value="<?php echo $email ?>" /></div>
    <div class="form_row"><label>Password</label></div>                       
    <div class="form_row"><input type="password" name="password" value="<?php echo $password ?>" /></div>                        
    <div class="form_row_button">
        <input type="hidden" name="redirect" value="<?php echo $redirect ?>"/>
        <input class="entra" type="submit" value="Login" name="login_btn" />              
    </div>
    <div class="content_cassa_step_1_pwd_dimenticata">
    	<div class="form_row"><a href="http://www.sekurbox.com/<?php echo $lingua;?>/recupera-password.html"><?php echo $password_dimenticata;?></a></div>
    </div>    
</form>                           