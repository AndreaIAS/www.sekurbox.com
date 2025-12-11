<?php 

 //Include config
include('inc_config.php');




//********************************  LOGIN ********************************************
if($_POST['function']=="login"){
          
      $errore="no";
 
                                                
    $db->query(" SELECT * FROM 
                 bag_utenti 
                 WHERE email = '".mysql_escape_string($_POST['email'])."' 
                 AND password = '".mysql_escape_string($_POST['password'])."'
                 AND attivo='s'    ");
    $recordsa = $db->single();
    $list= $db->rowCount();

    if ($list>0){
                 $_SESSION['user']=$recordsa['id'];
                 $_SESSION['nome']=$recordsa['nome']." ".$recordsa['cognome'];
                 $_SESSION['email']=$recordsa['email'];
                 $_SESSION['nazione']=$recordsa['id_nazione'];
                 
                 $arr = array('campo'=>'','errore'=>$errore);
                 echo json_encode($arr);
	     } 
     else{
                $errore="userassente";
                $arr = array('campo'=>'email','errore'=>$errore);
                echo json_encode($arr);
                exit();
         
         }
   

                        }


//********************************FINE  LOGIN ********************************************
                                                 
                                                 

                                     
                                     
//******************************** INSERISCI UTENTE********************************************
if($_POST['function']=='registrati'){

 $errore="no";   
 
 if(isset($_POST['newsletter'])){$newsletter='s';} else { $newsletter='n';}
 
 $db->query("SELECT * FROM 
             bag_utenti 
             WHERE 
             email = '".mysql_escape_string($_POST['email'])."' ");
 $recordsa = $db->resultset();
 $list= $db->rowCount();
 
          if ($list>0){
                $errore="mailpresente";
                $arr = array('campo'=>'email','errore'=>$errore);
                echo json_encode($arr);
                exit();		
	     }
             
             
               //creazione codice attivazione account    
                $usernameStrip = trim($_POST['email']);
                function ActiveCode($nome_utente){
		$chiave_attivazione = md5(time().$nome_utente.secretword);
		return $chiave_attivazione;
	                                          }   
                $chiave = ActiveCode($usernameStrip);
                $linkattivazione = pathactiveuser.'?user='.$usernameStrip.'&active='.$chiave;    

         $db->query("INSERT INTO
                     bag_utenti (cellulare,chiave,data_regis,attivo,ragione,nome,cognome,password,p_iva,cod_fiscale,indirizzo,cap,email,tipologia,telefono,newsletter,id_nazione,id_comune) 
                     VALUES('".mysql_escape_string($_POST['cellulare'])."','".$chiave."',NOW(),'n','".mysql_escape_string($_POST['ragione'])."','".mysql_escape_string($_POST['nome'])."'
                            ,'".mysql_escape_string($_POST['cognome'])."','".mysql_escape_string($_POST['password'])."','".mysql_escape_string($_POST['p_iva'])."' 
                            ,'".mysql_escape_string($_POST['cod_fiscale'])."','".mysql_escape_string($_POST['indirizzo'])."','".mysql_escape_string($_POST['cap'])."',"
                 . "        '".mysql_escape_string($_POST['email'])."' ,'".mysql_escape_string($_POST['tipologia'])."' 
                            ,'".mysql_escape_string($_POST['telefono'])."','".$newsletter."','".mysql_escape_string($_POST['id_nazione'])."','".mysql_escape_string($_POST['id_comune'])."') ");  						


                if($db->execute()){
 
                 $testo_email= "<span style='color:#1e6ec3;font-family:Arial,sans-serif;font-size:15px;'>";
                 $testo_email.= "<span style='color:#000000;'>Ti ringraziamo per esserti registrato sul nostro sito.</span><br /><br />";
                 $testo_email.= "<span style='color:blue;'>Per attivare il tuo account clicca <a href=\"".$linkattivazione."\">qui</a></span><br /> <br />";
                 $testo_email.= "<span style='color:#000000;'>Dopo aver attivato il tuo account puoi accedere al sito con i parametri da te inseriti e qui riportati:</span> <br /><br />";
                 $testo_email.= "<span style='color:#000000;'>E-mail:</span> ".mysql_escape_string($_POST['email'])."<br />";
                 $testo_email.= "<span style='color:#000000;'>Password:</span> ".mysql_escape_string($_POST['password'])."<br /><br />";
                 $testo_email.= "<br /><br /><br />
                 <div style='font-size:13px;width:200px;float:left;'>
                 Sito Internet: <a style='color: #19a9e5;' href='http://www.gevenit.com'>Gevenit.com</a><br />
                 Email: <a style='color: #19a9e5;' href='mailto:gevenit@gevenit.com'>gevenit@gevenit.com</a><br />
                 </div>
                 </span>";


                 $mail = new phpmailer(); 
                 $mail->IsHTML(true);
                 $mail->From = EMAIL_ADM;
                 $mail->FromName =EMAIL_ADM_NAME;
                 $mail->AddAddress(mysql_escape_string($_POST['email']));
                 $mail->AddBCC(EMAIL_ADM);
                 $mail->Subject = "Registrazione a Gevenit.com";
                 $mail->Body = $testo_email;
                 if ($mail->Send()) {

                 } else{
                     
                     $errore="Errore Invio Mail";   
                     $arr = array('campo'=>'','errore'=>$errore);
                     echo json_encode($arr);
                     exit();

                 }
                    
                    
                $arr = array('campo'=>'','errore'=>$errore);
                echo json_encode($arr);
                exit(); 

                                    }

                                                $errore=mysql_error();   
                                                $arr = array('campo'=>'','errore'=>$query);
                                                echo json_encode($arr);
                                                exit();

                                     }


//********************************FINE  INSERISCI UTENTE********************************************     
                                     
//******************************** MODIFICA UTENTE********************************************
if($_POST['function']=='editutente'){

 $errore="no";   

    $db->query("UPDATE
                bag_utenti 
                SET 
                nome='".mysql_escape_string($_POST['nome'])."',
                ragione='".mysql_escape_string($_POST['ragione'])."',
                cognome='".mysql_escape_string($_POST['cognome'])."',
                p_iva='".mysql_escape_string($_POST['p_iva'])."',
                cod_fiscale='".mysql_escape_string($_POST['cod_fiscale'])."',
                indirizzo='".mysql_escape_string($_POST['indirizzo'])."',
                id_nazione='".mysql_escape_string($_POST['id_nazione'])."',
                id_comune='".mysql_escape_string($_POST['id_comune'])."',
                cap='".mysql_escape_string($_POST['cap'])."',
                telefono='".mysql_escape_string($_POST['telefono'])."',
                cellulare='".mysql_escape_string($_POST['cellulare'])."'
                WHERE id='".mysql_escape_string($_POST['id'])."' ");  						

    if($db->execute()){  
                $arr = array('campo'=>'','errore'=>$errore);
                 echo json_encode($arr);
                  exit(); 

                                    }

                                                $errore=mysql_error();   
                                                $arr = array('campo'=>'','errore'=>$query);
                                                echo json_encode($arr);
                                                exit();

                                     }



//********************************FINE  MODIFICA UTENTE********************************************                                     
                                     

                                     







?>