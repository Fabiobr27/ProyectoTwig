<?php

// Fabio Benitez Ramirez
require_once("Database.php");
require_once("./modelos/Usuario.php");

class Sesion {

    private $usuario;
    private $time_expire = 30000;    
    private static $instancia = null;

   
    private function __construct() {
        
    }

   
    private function __clone() {
        
    }

   
    public function getUsuario() {
        return $this->usuario;
    }

    public function close() {
       
        $_SESSION = [];

        
        session_destroy();
    }

   
    public static function getInstance() {
        session_start();

       
        if (isset($_SESSION["_sesion"])):
            self::$instancia = unserialize($_SESSION["_sesion"]);
        else:
            if (self::$instancia === null)
                self::$instancia = new Sesion();
        endif;

       
        return self::$instancia;
    }



    public function login(string $ema, string $pas): bool {
  
        $db = new Database();

        
        $sql = "SELECT * FROM usuario WHERE email='{$ema}' AND pass=MD5('$pas') ;";

        $db->query($sql);

            if($db->getObject("Usuario")){
            $this->usuario = $db->getObject("Usuario");

           
          
            return true;

            }else{
                 return false;
            }

   
       
    }

  
  
    public function isExpired(): bool {
        return (time() - $_SESSION["time"] > $this->time_expire);
    }

    
    public function isLogged(): bool {
        return !empty($_SESSION);
    }

  
    public function checkActiveSession(): bool {
        if ($this->isLogged())
            if (!$this->isExpired())
                return true;
     
        return false;
    }

  
    public function redirect(string $url) {
        header("Location: $url");
        die();
    }

    
    public function __sleep() {
        return ["usuario", "instancia"];
    }

}
