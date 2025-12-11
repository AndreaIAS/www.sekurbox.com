<div class="buttons">
<div class="popup" id="subNavControll">
    <div class="label"><span class="icos-list"></span></div>
</div>
<div class="dropdown">
    <div class="label"><span class="icos-user2"></span>
	<?php 
	if (isset($_SESSION['logged']) && $_SESSION['logged'] ==1) {
	echo "User: " . $_SESSION['username'];	
	}
	else {
		echo "<p>Non sei loggato</p>";
	}
	?></div>
    <div class="body" style="width: 160px;">                   
        <div class="itemLink">
            <a href="logout.php"><span class="icon-off icon-white"></span> Logout</a>
        </div>                                        
    </div>                
</div>
</div>