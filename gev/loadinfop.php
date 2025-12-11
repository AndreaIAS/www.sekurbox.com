
<?php
include('inc_config.php');
//*************************  INVIA MAIL  ****************************************

    
 $errore="no";
 
// if($_POST['verify']!=5){
//     
//            $errore="captcha";
//            $arr = array('campo'=>'verify','errore'=>$errore);
//            echo json_encode($arr);
//            exit();    
//     
//     
// }
 $testoagg="<span style='font-family:Arial,sans-serif;font-size:13px;'><br>
                        Richiesta di contatto  dal sito Gevenit.com<br><br>
                        <b>Oggetto:</b>   ".$_POST['subject']."<br>    
                        <b>Email:</b>   ".$_POST['email']."<br>
                        <b>Nome:</b>   ".$_POST['name']."<br>
                        <b>Cognome:</b>   ".$_POST['cognome']."<br>
                        <b>Telefono:</b>   ".$_POST['telefono']."<br><br>
                        <b>Messaggio:</b>  <br />".$_POST['messaggio']."<br>
     <br /> <br /> <br /> <br />
     </span>";   
 
 
  $mail = new phpmailer(); 
             $mail->IsHTML(true);
             $mail->CharSet = 'UTF-8';
             $mail->From = $_POST['email'];
             $mail->FromName = "Gevenit.com";
             $mail->AddAddress('gevenit@gevenit.com'); 
             //$mail->AddAddress('clapton_ci@yahoo.it');            

             $mail->Subject ="Richiesta di contatto  dal sito Gevenit.com";

             $mail->Body =$testoagg; 
                           
             if(!$mail->Send()){
                               
                               }                
        
             //Nessun errore, quindi ritorno errore=no   
            $arr = array('campo'=>'','errore'=>$errore);
            echo json_encode($arr);
            exit();
 


                           
//*************************  FINE INVIA MAIL ****************************************

?>