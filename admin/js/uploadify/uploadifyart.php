<?php

include('../../config.php');
 
$targetPath = BASE_PATH_HOME.'img_prod'; // Relative to the root

if (!empty($_FILES) ) {

	$tempFile = $_FILES['Filedata']['tmp_name'];

	$fileParts = pathinfo($_FILES['Filedata']['name']);

        $targetFile =rtrim($targetPath,'/') . '/' . date('YmdHis')."-".$_FILES['Filedata']['name'];

	

	// Validate the file type

	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
        $nome=date('YmdHis')."-".$_FILES['Filedata']['name'];


	

	if (in_array($fileParts['extension'],$fileTypes)) {

		if(move_uploaded_file($tempFile,$targetFile)){
		
        if($_POST['action']=='edit') { 
        mysql_query("UPDATE articoli SET immagine = '".$nome."' WHERE id_articolo='".$_POST['num']."' ");     
                                      } 
      
		}

		echo $nome;

	} else {

		echo 'Invalid file type.';

	}

}

?>