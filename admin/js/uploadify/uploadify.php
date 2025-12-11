<?php

include('../../config.php');

$targetFolder = BASE_PATH_HOME.'images/img_tag'; // Relative to the root


//$verifyToken = md5('unique_salt' . $_POST['timestamp']);



if (!empty($_FILES) ) {

	$tempFile = $_FILES['Filedata']['tmp_name'];

	$targetPath = $targetFolder;

	$fileParts = pathinfo($_FILES['Filedata']['name']);

	//$targetFile = rtrim($targetPath,'/') . '/' .$_FILES['Filedata']['name'];

	$targetFile = rtrim($targetPath,'/') . '/' .$_POST['num']."-".$_FILES['Filedata']['name'];

	

	// Validate the file type

	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions



	

	if (in_array($fileParts['extension'],$fileTypes)) {

		move_uploaded_file($tempFile,$targetFile);

		echo $_POST['num']."-".$_FILES['Filedata']['name'];

	} else {

		echo 'Invalid file type.';

	}

}

?>