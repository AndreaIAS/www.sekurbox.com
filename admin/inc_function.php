<?php   

function calcola_num_figli($idut){
     
    require_once ("classe_Database.php");
 $db=new Database(DB_HOST,DB_USER,DB_PW,DB_NAME); 
 
     $db->query( "SELECT bag_utenti.* 
                  FROM 
                  bag_utenti
                  WHERE codice_madre='".$idut."'");  
     $records = $db->resultset();
     
     $conta=0;
                
     if ($db->rowCount() == 0) {    return 0; }
            
        else{ 
                 
                    foreach ($records as $list)  {     
                        
                        $conta++;
                    
                        $db->query( "SELECT bag_utenti.* 
                                     FROM 
                                     bag_utenti
                                     WHERE codice_madre='".$list['id']."'");
                        $records1 = $db->resultset();       
                        
                            foreach ($records1 as $list1)  {

                                $conta++;    

                                $db->query( "SELECT bag_utenti.* 
                                             FROM 
                                             bag_utenti
                                             WHERE codice_madre='".$list1['id']."'");
                                $records2 = $db->resultset();     

                                foreach ($records2 as $list2)  { $conta++; }    
                            }

                        }
        }
     
     return $conta;
}



function emailpresente($value){
 $query = "SELECT * FROM 
           fre_users 
           WHERE 
           email = '".$value."' 
           AND attivo='s' ";
 $res = mysql_query($query);
 if (mysql_num_rows($res)==0) {
  return 0;
 }else{
  return 1;
 }
}

function userpresente($value){
 $query = "SELECT * FROM 
           fre_users 
           WHERE 
           username = '".$value."' 
           AND attivo='s' ";
 $res = mysql_query($query);
 if (mysql_num_rows($res)==0) {
  return 0;
 }else{
  return 1;
 }
}

function login_result($user,$password){
 $query = "SELECT * FROM 
           fre_users 
           WHERE 
           username = '".$user."' AND pwd='".$password."'
           AND attivo='s' ";
 $res = mysql_query($query);
 if (mysql_num_rows($res)==0) {
  return 0;
 }else{
  $list = mysql_fetch_array($res);
  return $list;
 }
}

function lang_in($user){
 $query = "SELECT * FROM 
           fre_user_lang 
           WHERE id_user = '$user' ";
 $result = mysql_query($query);
 $array = array();
 while ($list = mysql_fetch_array($result)) {
 	$array[] = $list['id_lang'];
 }
 return $array;
}

function RandomStringGenerator($length){
global $string;
    $pattern = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
if(empty($length)){
    $length = "10";
    }
for($i=0; $i<$length; $i++){
    $string .= $pattern{rand(0,61)};
    }

return $string;
}

function siti_cate($id_sito,$id_cat){

 $query = "SELECT * FROM 
           bag_siti_cat 
           WHERE 
           id_sito = '".$id_sito."' 
           AND id_cat = '".$id_cat."' ";
 $result = mysql_query($query);
 if (mysql_num_rows($result)==0) {
 	return '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" class="form_class">
 	         <input type="hidden" value="'.$id_cat.'" name="id_cat">
 	         <input type="hidden" value="'.$id_sito.'" name="id_sito">
             <input type="submit" style="background:url(images_adm/attivo_n.png);width:16px;height:16px;border:0;cursor:pointer;" value="" name="attivo">
            </form>';
 }else{
 	$list = mysql_fetch_array($result);
 	return '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" class="form_class">
 	         <input type="hidden" value="'.$list['id'].'" name="id">
             <input type="submit" style="background:url(images_adm/attivo_s.png);width:16px;height:16px;border:0;cursor:pointer;" value="" name="non_attivo">
            </form>';
 }

}

function siti_fil($id_sito,$id_cat){

 $query = "SELECT * FROM 
           bag_fil_siti 
           WHERE 
           id_sito = '".$id_sito."' 
           AND id_filtro = '".$id_cat."' ";
 $result = mysql_query($query);
 if (mysql_num_rows($result)==0) {
 	return '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" class="form_class">
 	         <input type="hidden" value="'.$id_cat.'" name="id_filtro">
 	         <input type="hidden" value="'.$id_sito.'" name="id_sito">
             <input type="submit" style="background:url(images_adm/attivo_n.png);width:16px;height:16px;border:0;cursor:pointer;" value="" name="attivo">
            </form>';
 }else{
 	$list = mysql_fetch_array($result);
 	return '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" class="form_class">
 	         <input type="hidden" value="'.$list['id'].'" name="id">
             <input type="submit" style="background:url(images_adm/attivo_s.png);width:16px;height:16px;border:0;cursor:pointer;" value="" name="non_attivo">
            </form>';
 }

}


function testi_box($id_sito,$id_cat){

 $query = "SELECT * FROM 
           bag_box_tes 
           WHERE 
           id_testo = '".$id_cat."' 
           AND id_box = '".$id_sito."' ";
 $result = mysql_query($query);
 if (mysql_num_rows($result)==0) {
 	return '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" class="form_class">
 	         <input type="hidden" value="'.$id_sito.'" name="id_box">
 	         <input type="hidden" value="'.$id_cat.'" name="id_testo">
             <input type="submit" style="background:url(images_adm/attivo_n.png);width:16px;height:16px;border:0;cursor:pointer;" value="" name="attivo">
            </form>';
 }else{
 	$list = mysql_fetch_array($result);
 	return '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" class="form_class">
 	         <input type="hidden" value="'.$list['id'].'" name="id">
             <input type="submit" style="background:url(images_adm/attivo_s.png);width:16px;height:16px;border:0;cursor:pointer;" value="" name="non_attivo">
            </form>';
 }

}

function testi_siti($id_sito,$id_cat){

 $query = "SELECT * FROM 
           bag_siti_testi 
           WHERE 
           id_testo = '".$id_cat."' 
           AND id_sito = '".$id_sito."' ";
 $result = mysql_query($query);
 if (mysql_num_rows($result)==0) {
 	return '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" class="form_class">
 	         <input type="hidden" value="'.$id_sito.'" name="id_sito">
 	         <input type="hidden" value="'.$id_cat.'" name="id_testo">
             <input type="submit" style="background:url(images_adm/attivo_n.png);width:16px;height:16px;border:0;cursor:pointer;" value="" name="attivo_sit">
            </form>';
 }else{
 	$list = mysql_fetch_array($result);
 	return '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" class="form_class">
 	         <input type="hidden" value="'.$list['id'].'" name="id">
             <input type="submit" style="background:url(images_adm/attivo_s.png);width:16px;height:16px;border:0;cursor:pointer;" value="" name="non_attivo_sit">
            </form>';
 }

}

function table_campi($id_scheda,$array_flag){
	
 $query = "SELECT * FROM 
           bag_campi 
           WHERE 
           id_scheda = '$id_scheda' 
           ORDER BY posizione ";
 $result = mysql_query($query);
 if (mysql_num_rows($result)==0) {
 	
 	return "<p>Nessun record inserito<p>";
 	
 }else{
 	
     $text = '<table width="500px">
     <tr>';
     for($i=0;$i<1;$i++){ 
      $text.= '<td style="width:300px;"><img src="images_adm/flags/'.$array_flag[$i] .'.png" align="absmiddle"></td>'; 
      }  
$text.= '<td style="width:60px;">Posizione</td>
      <td style="width:30px;">Edit</td>
      <td style="width:30px;">Del</td>
     </tr>';
    while ($list = mysql_fetch_array($result)) {
    
     $text.='<tr>';
     for($i=0;$i<1;$i++){ 
      $text.= "<th>".$list['titolo_'.$array_flag[$i]]."</th>"; 
      } 
     $text.='<th style="width:60px;text-align:right;">'. $list['posizione'] .'</th>
     <th><form id="form_edit_'. $list['id'] .'" action="javascript:void(null);" onsubmit="xajax_EdiFor(xajax.getFormValues(\'form_edit_'. $list['id'] .'\'));" class="form_class">';
      foreach ($array_flag as $val)
      $text.="<input type=\"hidden\" name=\"flags[]\" id=\"flags[]\" value =\"$val\">";
     $text.='<input type="hidden" value="'. $list['id'] .'" name="id_campo">
     <input type="hidden" value="campi" name="opt">
     <input type="hidden" value="'.$id_scheda.'" name="id">
     <input type="submit" value="" style="background:url(images_adm/edit.png);height:16px;width:16px;border:0px;cursor:pointer;" name="edit">
     </form></th>
     <th><form action="schede.php" method="POST" class="form_class">
     <input type="hidden" value="'. $list['id'] .'" name="id_campo">
     <input type="hidden" value="bag_cam_val" name="table">
     <input type="hidden" value="campi" name="opt">
     <input type="hidden" value="'.$id_scheda.'" name="id">
     <input type="submit" value="" onClick="return confirmSubmit_cam()" style="background:url(images_adm/del.png);height:16px;width:16px;border:0px;cursor:pointer;" name="delete">
     </form></th>
    </tr>';
    	
    }
    
    $text.='   </table>
   <table width="500px">
    <tr>
     <td>&nbsp;</td>
    </tr>
   </table>';
    
    return $text;
 	
 }
	
}

function table_campi_var($id_scheda){
	
 $query = "SELECT * FROM 
           bag_sce_cam 
           WHERE 
           id_scelta = '$id_scheda' 
           ORDER BY posizione ";
 $result = mysql_query($query);
 if (mysql_num_rows($result)==0) {
 	
 	return "<p>Nessun record inserito<p>";
 	
 }else{
 	
     $text = '<table width="800px">
     <tr>
      <td style="width:170px;">Valore <img src="images_adm/flags/it.png"></td>
      <td style="width:170px;">Valore <img src="images_adm/flags/uk.png"></td>
      <td style="width:170px;">Valore <img src="images_adm/flags/pl.png"></td>
      <td style="width:170px;">Valore <img src="images_adm/flags/cr.png"></td>
      <td style="width:60px;">Posizione</td>
      <td style="width:30px;">Edit</td>
      <td style="width:30px;">Del</td>
     </tr>';
    while ($list = mysql_fetch_array($result)) {
    
     $text.='<tr>
     <th>'.$list['titolo_it'].'</th>
     <th>'.$list['titolo_uk'].'</th>
     <th>'.$list['titolo_pl'].'</th>
     <th>'.$list['titolo_cr'].'</th>
     <th style="width:60px;text-align:right;">'. $list['posizione'] .'</th>
     <th><form id="form_edit_'. $list['id'] .'" action="javascript:void(null);" onsubmit="xajax_EdiForCam(xajax.getFormValues(\'form_edit_'. $list['id'] .'\'));" class="form_class">
     <input type="hidden" value="'. $list['id'] .'" name="id_campo">
     <input type="hidden" value="campi" name="opt">
     <input type="hidden" value="'.$id_scheda.'" name="id">
     <input type="submit" value="" style="background:url(images_adm/edit.png);height:16px;width:16px;border:0px;cursor:pointer;" name="edit">
     </form></th>
     <th><form action="'. $_SERVER['PHP_SELF'] .'" method="POST" class="form_class">
     <input type="hidden" value="'. $list['id'] .'" name="id_campo">
     <input type="hidden" value="bag_sce_cam" name="table">
     <input type="hidden" value="campi" name="opt">
     <input type="hidden" value="'.$id_scheda.'" name="id">
     <input type="submit" value="" onClick="return confirmSubmit_cam()" style="background:url(images_adm/del.png);height:16px;width:16px;border:0px;cursor:pointer;" name="delete">
     </form></th>
    </tr>';
    	
    }
    
    $text.='   </table>
   <table width="800px">
    <tr>
     <td>&nbsp;</td>
    </tr>
   </table>';
    
    return $text;
 	
 }
	
}

function table_campi_fil($id_scheda){
	
 $query = "SELECT * FROM 
           bag_fil_cam 
           WHERE 
           id_scelta = '$id_scheda' 
           ORDER BY posizione ";
 $result = mysql_query($query);
 if (mysql_num_rows($result)==0) {
 	
 	return "<p>Nessun record inserito<p>";
 	
 }else{
 	
     $text = '<table width="800px">
     <tr>
      <td style="width:170px;">Valore <img src="images_adm/flags/it.png"></td>
      <td style="width:170px;">Valore <img src="images_adm/flags/uk.png"></td>
      <td style="width:170px;">Valore <img src="images_adm/flags/pl.png"></td>
      <td style="width:170px;">Valore <img src="images_adm/flags/cr.png"></td>
      <td style="width:60px;">Posizione</td>
      <td style="width:30px;">Edit</td>
      <td style="width:30px;">Del</td>
     </tr>';
    while ($list = mysql_fetch_array($result)) {
    
     $text.='<tr>
     <th>'.$list['titolo_it'].'</th>
     <th>'.$list['titolo_uk'].'</th>
     <th>'.$list['titolo_pl'].'</th>
     <th>'.$list['titolo_cr'].'</th>
     <th style="width:60px;text-align:right;">'. $list['posizione'] .'</th>
     <th><form id="form_edit_'. $list['id'] .'" action="javascript:void(null);" onsubmit="xajax_EdiFilCam(xajax.getFormValues(\'form_edit_'. $list['id'] .'\'));" class="form_class">
     <input type="hidden" value="'. $list['id'] .'" name="id_campo">
     <input type="hidden" value="campi" name="opt">
     <input type="hidden" value="'.$id_scheda.'" name="id">
     <input type="submit" value="" style="background:url(images_adm/edit.png);height:16px;width:16px;border:0px;cursor:pointer;" name="edit">
     </form></th>
     <th><form action="'. $_SERVER['PHP_SELF'] .'" method="POST" class="form_class">
     <input type="hidden" value="'. $list['id'] .'" name="id_campo">
     <input type="hidden" value="bag_fil_cam" name="table">
     <input type="hidden" value="campi" name="opt">
     <input type="hidden" value="'.$id_scheda.'" name="id">
     <input type="submit" value="" onClick="return confirmSubmit_cam()" style="background:url(images_adm/del.png);height:16px;width:16px;border:0px;cursor:pointer;" name="delete">
     </form></th>
    </tr>';
    	
    }
    
    $text.='   </table>
   <table width="800px">
    <tr>
     <td>&nbsp;</td>
    </tr>
   </table>';
    
    return $text;
 	
 }
	
}


function table_scheda() {
	
$query = "SELECT * FROM 
          bag_scheda 
          ORDER BY id ";
$result = mysql_query($query);

$text_table = '';
if (mysql_num_rows($result)==0) {

$text_table.= '<center><p style="font-size:11px;"><B>Nessun record presente</B></p></center>';

}else{

$text_table.= '<table width="100%">
    <tr>
     <td>Titolo</td>
     <td style="width:30px;">Campi</td>
     <td style="width:30px;">Stato</td>
     <td style="width:30px;">Duplica</td>
     <td style="width:30px;">Edit</td>
     <td style="width:30px;">Del</td>
    </tr>';
 
while ($list = mysql_fetch_array($result)) {

$text_table.= '<tr>
     <th>'.$list['nome'].'</th>
     <th><form action="'. $_SERVER['PHP_SELF'] .'" method="POST" class="form_class">
     <input type="hidden" value="'. $list['id'] .'" name="id">
     <input type="hidden" value="campi" name="opt">
     <input type="submit" value="" style="background:url(images_adm/campi.png);height:16px;width:16px;border:0px;cursor:pointer;" name="edit_campi">
     </form></th>
     <th style="width:30px;"><form action="javascript:void(null);" onsubmit="xajax_AggSta(xajax.getFormValues(\'form_attivo_'. $list['id'] .'\'));" id="form_attivo_'. $list['id'] .'" class="form_class">
 	         <input type="hidden" value="'. $list['id'] .'" id="id" name="id">
 	         <input type="hidden" value="bag_scheda" name="table">
 	         <input type="hidden" value="attivo" name="campo">
 	         <input type="hidden" value="'. $list['attivo'] .'" name="stato_'. $list['id'] .'" id="stato_'. $list['id'] .'">
             <input type="submit" style="background:url(images_adm/attivo_'. $list['attivo'] .'.png);width:16px;height:16px;border:0;cursor:pointer;" value="" id="att_'. $list['id'] .'" name="att_'. $list['id'] .'">
            </form></th>
     <th style="text-align:center"><form action="javascript:void(null);" onsubmit="xajax.$(\'dup_'. $list['id'] .'\').style.background=\'url(images_adm/loading_blu.gif)\';xajax_DupSch(xajax.getFormValues(\'form_duplica_'. $list['id'] .'\'));" id="form_duplica_'. $list['id'] .'" class="form_class">
 	         <input type="hidden" value="'. $list['id'] .'" id="id" name="id">
             <input type="submit" style="background:url(images_adm/duplica.png);width:16px;height:16px;border:0;cursor:pointer;" value="" id="dup_'. $list['id'] .'" name="att_'. $list['id'] .'">
            </form></th>
     <th><form action="'. $_SERVER['PHP_SELF'] .'" method="POST" class="form_class">
     <input type="hidden" value="'. $list['id'] .'" name="id">
     <input type="hidden" value="edit" name="opt">
     <input type="submit" value="" style="background:url(images_adm/edit.png);height:16px;width:16px;border:0px;cursor:pointer;" name="edit">
     </form></th>
     <th><form action="'. $_SERVER['PHP_SELF'] .'" method="POST" class="form_class">
     <input type="hidden" value="'. $list['id'] .'" name="id">
     <input type="hidden" value="bag_categorie" name="table">
     <input type="submit" value="" style="background:url(images_adm/del.png);height:16px;width:16px;border:0px;cursor:pointer;" name="delete">
     </form></th>
    </tr>';

 }

 $text_table.='</table>
   <table width="100%">
    <tr>
     <td>&nbsp;</td>
    </tr>
   </table>';
 
}

 return $text_table;

}

function check_varia($id_art,$id_sce){
	
	$query = "SELECT * FROM 
	          bag_sce_art 
	          WHERE 
	          id_articolo = '".$id_art."' 
	          AND id_scelta = '".$id_sce."' ";
	$result = mysql_query($query);
	if (mysql_num_rows($result)>0) {
	 return "checked";
	}else
	 return "";
}

function check_testi($id_art,$id_tes){
	
	$query = "SELECT * FROM 
	          bag_tes_art 
	          WHERE 
	          id_articolo = '".$id_art."' 
	          AND id_testo = '".$id_tes."' ";
	$result = mysql_query($query);
	if (mysql_num_rows($result)>0) {
	 return "checked";
	}else
	 return "";
}

function check_filtri($id_art,$id_sce){
	
	$query = "SELECT * FROM 
	          bag_fil_art 
	          WHERE 
	          id_articolo = '".$id_art."' 
	          AND id_scelta = '".$id_sce."' ";
	$result = mysql_query($query);
	if (mysql_num_rows($result)>0) {
	 return "selected";
	}else
	 return "";
}

function seo_url($testo){

 $html['url']=strip_tags(preg_replace('#[^A-Za-z0-9-]#', '', $testo));
 $reWriteUrl = ereg_replace("-"," ",$html['url']);
 $reWriteUrl = ucWords($reWriteUrl);
 return $reWriteUrl;
	
}

//trasforma la data datepicker italiana in data mysql

function sistemadata($cdate){
        list($day,$month,$year)=explode("/",$cdate);
        return $year."-".$month."-".$day;
} 
?>
