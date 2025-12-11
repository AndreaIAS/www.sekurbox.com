<?php
class Database{
    
    private $stmt;
    private $dbh;
    private $error;
 
    public function __construct($DB_HOST,$DB_USER,$DB_PW,$DB_NAME){
        
        if(!$this->dbh){
        
            // Set DSN dalla versione 5.3.6 si può settare qui con: ;charset=utf8
            $dsn = 'mysql:host='.$DB_HOST.';dbname='.$DB_NAME;
        
            // Set options
            $options = array(
                #PDO::ATTR_PERSISTENT=> true,
                #PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND=> "SET NAMES utf8 COLLATE 'utf8_general_ci'",
                PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION
            );
            
            // Create a new PDO instance
            try{
                $this->dbh = new PDO($dsn, $DB_USER, $DB_PW, $options);
            }
            // Catch any errors
            catch(PDOException $e){
                $this->error = $e->getMessage();
            }
        
        }
    }
    
    
    
    // Query function
    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
    }
    
    // Bind function
    public function bind($param, $value, $type = null){
    
        if(is_null($type)){
            
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
            
        }
        
        $this->stmt->bindValue($param, $value, $type);
        
    }
    
    // Execute function
    public function execute($array=''){
        return ($array!='' && is_array($array))?$this->stmt->execute($array):$this->stmt->execute();
        # Chiudo connessione FORSE!
        $this->dbh = null;
    }
    
    // Resultset function
    public function resultset($array=''){
        ($array!='' && is_array($array))?$this->execute($array):$this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Single function
    public function single($array=''){
        ($array!='' && is_array($array))?$this->execute($array):$this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Row Count function
    public function rowCount(){
        return $this->stmt->rowCount();
    }
    
    // Last insert ID function
    public function lastInsertId(){
        return $this->dbh->lastInsertId();
    }
    
    // Begin Transaction function
    public function beginTransaction(){
        return $this->dbh->beginTransaction(); 
    }
    
    // End Transaction function
    public function endTransaction(){
        return $this->dbh->commit();
    }
    
    // Cancel Transaction function
    public function cancelTransaction(){
        return $this->dbh->rollBack();
    }
    
    // Debug Dump Params function
    public function debugDumpParams(){
        return $this->stmt->debugDumpParams();
    }
    
    
     // Debug Dump Params function
    public function Errori(){
        return $this->stmt->errorInfo();
    }
    
}

## USAGE ##

# ISTANZIARE CLASSE DATABASE
# $database = new Database();


# QUERY INSERT
# $database->query('INSERT INTO mytable (FName, LName, Age, Gender) VALUES (:fname, :lname, :age, :gender)');
#
# $database->bind(':fname', 'John');
# $database->bind(':lname', 'Smith');
# $database->bind(':age', '24');
# $database->bind(':gender', 'male');
#
# $database->execute();
#
# Ricavo ultimo id inserito
# echo $database->lastInsertId();


# QUERY TRANSACTION, QUERY MULTIPLE
# $database->beginTransaction();
#
# $database->query('INSERT INTO mytable (FName, LName, Age, Gender) VALUES (:fname, :lname, :age, :gender)');
#
# $database->bind(':fname', 'Jenny');
# $database->bind(':lname', 'Smith');
# $database->bind(':age', '23');
# $database->bind(':gender', 'female');
#
# $database->execute();
#
# $database->bind(':fname', 'Jilly');
# $database->bind(':lname', 'Smith');
# $database->bind(':age', '25');
# $database->bind(':gender', 'female');
#
# $database->execute();
#
# echo $database->lastInsertId();
#
# $database->endTransaction();


# QUERY SINGOLO RISULTATO
# $database->query('SELECT FName, LName, Age, Gender FROM mytable WHERE FName = :fname');
#
# $database->bind(':fname', 'Jenny');
#
# $row = $database->single();


# QUERY MULTI RIGA
# $database->query('SELECT FName, LName, Age, Gender FROM mytable WHERE LName = :lname');
#
# $database->bind(':lname', 'Smith');
#
# $rows = $database->resultset();


# RICAVO NUMERO RECORD ESTRATTI
# echo $database->rowCount();

# UPDATE, DELETE
#
# $database->query('UPDATE table SET pippo=suca WHERE id=1');
# anche con bind volendo
#
# $database->execute();

# RIFERIMENTO
# http://culttt.com/2012/10/01/roll-your-own-pdo-php-class/
?>