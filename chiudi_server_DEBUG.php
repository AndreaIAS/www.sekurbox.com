<html>

    

<?php
$DEBUG = true;

if ($DEBUG) {
    $transactionId = $_POST["transactionID"];
    toFile($transactionId);
    echo "TransactionID: ${transactionId} <br />";
    
    $amount = $_POST["amount"];
    
    forwardTo(new Endpoint(Endpoint::getTypeFromTransactionID($transactionId)), 
        $transactionId, $amount);
    
    exit;
}





include("inc_config.php");


//Leggo l'ID della transazione che mi ritorna gestpay nella variabile (b) che contiene il mio NUM_ORD

require_once "GestPayCrypt.inc.php";   


if (empty($_GET["a"])) {

    die("Parametro mancante: 'a'\n");

}

if (empty($_GET["b"])) {

    die("Parametro mancante: 'b'\n");

}


toFile($_GET);

$crypt = new GestPayCrypt();



$crypt->SetShopLogin($_GET["a"]);

$crypt->SetEncryptedString($_GET["b"]);



if (!$crypt->Decrypt()) {

    die("Error: ".$crypt->GetErrorCode().": ".$crypt->GetErrorDescription()."\n");

}

      

switch ($crypt->GetTransactionResult()) {

    

        case "XX":



            break;



        case "KO":



            break;



        case "OK":

                $transactionId = $crypt->GetShopTransactionID();
                toFile($transactionId);
                echo "TransactionID: ${transactionId} <br />";
                
                $amount = $crypt->GetAmount();

                forwardTo(new Endpoint(Endpoint::getTypeFromTransactionID($transactionId)), 
                    $transactionId, $amount);

                break;

        

        default:       

        

}

function toFile ($val) {
    $file = fopen("log_richieste_chiudi_server.txt", "a");
    fwrite($file, "\n");
    fwrite($file, json_encode($val));
    fclose($file);
}

function forwardTo ($endpoint, $id, $amount) {
    $url = $endpoint->appendArguments($endpoint->getUrlToContact(), 
        array(
            "transactionID" => clearTransactionID($id),
            "amount" => $amount
        ));
    $curl = curl_init($url);
    if ($curl === false) 
        die("Errore durante la creazione della richiesta curl!");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

    echo "Trying to contact ${url} <br /><br />";
    $res = curl_exec($curl);

    echo json_encode($curl, JSON_PRETTY_PRINT);
    echo "Result :  <br />";
    echo json_encode($res, JSON_PRETTY_PRINT);
    toFile("Response: " . $res);

    if ($res === false) {
        $err = curl_error($curl);
        toFile("Error: ${err}");
        
        die($err);
    }

}

/**
 * Tolgo il prefisso dagli id. 
 * Prefissi : MRS, IPC, MHS, SK
 */
function clearTransactionID ($id) {
    $prefix = substr($id, 0, 3);
    if ($prefix === "IPC" ||
         $prefix === "MHS" ||
         $prefix === "MRS")
        return substr($id, 3);

    $prefix = substr($id, 0, 2); // Il prefisso di sekurbox è a 2 caratteri (SK)
    if ($prefix === "SK")
        return substr($id, 2);

    return $id;
}

// ========================================================================================================
// ENDPOINT CLASS =========================================================================================
// ========================================================================================================


class Endpoint {
    const MARSS = "mrss";
    const SEKURBOX = "skrbx";
    const MAHOSY = "mhs";
    const IPCONTROLLER = "ipc";

    private $type = Endpoint::SEKURBOX;

    function __construct ($endpointName = Endpoint::SEKURBOX) {
        $this->type = $endpointName;
    }

    /**
     * In base al prefisso dell'id della transazione (SK, MRS, MHS, IPC) 
     * si ritorna il tipo di endpoit da contattare
     */
    public static function getTypeFromTransactionID ($transactionID) {
        $type = Endpoint::SEKURBOX;
        
        if (substr($transactionID, 0, 3) === "MHS")
            $type = Endpoint::MAHOSY;
        
        elseif (substr($transactionID, 0 , 3) === "IPC")
            $type = Endpoint::IPCONTROLLER;
       
        elseif (substr($transactionID, 0, 3) === "MRS") 
            $type = Endpoint::MARSS;

        return $type;
    }

    function getType () {
        return $this->type;
    }

    function getUrlToContact () {
        $url = "";
        switch ($this->getType()) {
            case Endpoint::SEKURBOX :
                // $url = "https://www.sekurbox.com/"; 
                $url = "https://www.sekurbox.com/sk_aggiorna_bag_ordini.php"; 
                break;
            case Endpoint::MARSS :
                $url = "https://www.marss.eu/PLACEHOLDER";
                break;
            case Endpoint::MAHOSY : 
                $url = "https://api.mahosy.com/default/licenses/endTransaction";
                // $url = "http://192.168.70.108:5353/licenses/endTransaction";
                break;
            case Endpoint::IPCONTROLLER : 
                $url = "https://www.marsscloud.com/chiudi_server.php";
                break;
            default : 
                $url = "https://www.sekurbox.com/sk_aggiorna_bag_ordini.php"; 
        }

        return $url;
    }

    /**
     * $arrParams type array
     */
    function appendArguments ($url, $arrParams) {
        $url .= "?";
        foreach ($arrParams as $k => $v)  {
            $url .= "${k}=${v}&";
        }

        return rtrim($url, "&");
    }
    
}

?>

</html>