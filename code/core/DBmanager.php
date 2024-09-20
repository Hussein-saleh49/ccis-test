<?php
class DBmanager{
    private $host;
    private $dbname;
    private $user;
    private $password;
    public $pdo;

    public function __construct( ){
        $configs=include_once __DIR__."/../config/dataconfig.php";
        $this->setparms($configs);
       $this->getconnection();

    }
    public function setparms(array $configs ) : void{  
        extract($configs);
        $this->host =$host ?? null;
        $this->dbname =$dbname?? null ;
        $this->user =$user ?? null;
        $this->password =$password ?? null;
    } 
  

    

    public function getconnection() :PDO{
         $this->pdo=new PDO($this->getdsn(),$this->user,$this->password);
         return $this->pdo;
    
    }

    public function doquery( $sql , ...$args){
          $stmt= $this->pdo->prepare($sql);
            $stmt->execute($args);
            return $stmt;


    }

   private function getdsn() :string{
        return sprintf("mysql:host=%s;dbname=%s", $this-> host , $this->dbname);
    }
}
?>