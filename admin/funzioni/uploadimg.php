<?php

require("../config.php");

if(!isset($_REQUEST['id_file'])){
    $idfile='img_file';
} else {
     $idfile=$_REQUEST['id_file'];
}

  if(count($_FILES[$idfile]['name']) > 0){
      

        //Loop through each file
  
        //Get the temp file path
        $tmpFilePath = $_FILES[$idfile]['tmp_name'];
      

            //Make sure we have a filepath
            if($tmpFilePath != ""){
            
                //save the filename
                $shortname = $_FILES[$idfile]['name'];

                //save the url and the file
                $nomefile=strtolower(date('d-m-Y-H-i-s').'-'.$_FILES[$idfile]['name']);
                $filePath = '../../upload/'.$_REQUEST['folder']."/".$nomefile;

//                     $filePath = 'file/'. date('d-m-Y-H-i-s').'-'.$_FILES['file_attivita']['name'];

                //Upload the file into the temp dir
                if(move_uploaded_file($tmpFilePath, $filePath)) {
                    
                    
//                        $db->query("INSERT INTO file(nome,id_attivita,data,id_utente,id_attrezzatura)
//                                      VALUES('".$nomefile."','".$id_attivita."',NOW(),'".$_SESSION['user']."','".$idattr."') 
//                                     ");
//                        $db->execute();
                        
//                        if(getimagesize($filePath)!=FALSE)  { 
//                            
//                            if(mime_content_type($filePath)=='image/tiff' OR mime_content_type($filePath)=='image/jpeg'){
//                        
//                                    $exif = exif_read_data($filePath);
//                                    if (!empty($exif['Orientation'])) {
//                                        
//                                        $imageResource = imagecreatefromjpeg($filePath); // provided that the image is jpeg. Use relevant function otherwise
//                                        switch ($exif['Orientation']) {
//                                            case 3:
//                                            $image = imagerotate($imageResource, 180, 0);
//                                            break;
//                                            case 6:
//                                            $image = imagerotate($imageResource, -90, 0);
//                                            break;
//                                            case 8:
//                                            $image = imagerotate($imageResource, 90, 0);
//                                            break;
//                                            default:
//                                            $image = $imageResource;
//                                        } 
//                                        
//                                        
//                                       if(!is_null($image) AND !is_null($imageResource) ){
//
//                                        imagejpeg($image, $filePath, 90);
//                                        imagedestroy($imageResource);
//                                        if($image!=$imageResource) imagedestroy($image);
//
//                                    } 
//                                        
//                                }
//      
//                            } 
//                       } 

                      $arr = array("nomefile"=>$nomefile);
                      echo json_encode($arr);

                }
              }
       }  
   






?>
