<?php

// Fabio Benitez Ramirez
require_once 'modelos/modelo.php';
require_once 'modelos/Usuario.php';
require_once 'modelos/Marca.php';
require_once "libs/Sesion.php";

class Modelo_Usuario {

    private $CodigoMod;
    private $idUsu;
    private $favorito;
    private $Comentario;

    public function __construct() {
        
    }

    public function getidUsu() {
        return $this->idUsu;
    }

    public function setidUsu($idUsu) {
        $this->idUsu = $idUsu;

        return $this;
    }

    public function getfavorito() {
        return $this->favorito;
    }

    public function setfavorito($favorito) {
        $this->favorito = $favorito;

        return $this;
    }

    function getComentario() {
        return $this->Comentario;
    }

    function setComentario($Comentario) {
        $this->Comentario = $Comentario;
    }

    public function getcodigoMod() {
        return $this->CodigoMod;
    }

    public function setcodigoMod($codMod) {
        $this->CodigoMod = $codMod;

        return $this;
    }

    public static function MostrarComentarios() {


        $db = new Database();
        $db->query("SELECT * FROM Usuario us , Modelo_Usuario mu where comentario is not null and mu.codigoMod = 7 and mu.idUsu = us.idUsu Order by Comentario");

        $data = [];
        while ($obj = $db->getObject("Modelo_Usuario"))
            array_push($data, $obj);

        //
        return $data;
    }

    public static function findComentarios($codigoModelo): array {
        $db = new Database();
        $db->query("SELECT * FROM Usuario us , Modelo_Usuario mu where comentario is not null and mu.codigoMod = $codigoModelo and mu.idUsu = us.idUsu Order by Comentario;");

        $data = [];
        while ($obj = $db->getObject("Modelo_Usuario"))
            array_push($data, $obj);


        return $data;
    }

    public static function find($codigoModelo): Modelo_Usuario {
        $db = new Database();
        $db->query("SELECT * FROM Usuario us , Modelo_Usuario mu where  mu.codigoMod = $codigoModelo and mu.idUsu = us.idUsu;");
        echo "SELECT * FROM Usuario us , Modelo_Usuario mu where  mu.codigoMod = $codigoModelo and mu.idUsu = us.idUsu;";
        return $db->getObject("Modelo_Usuario");
    }

    
    public function MostrarFavoritos() {
        $db = new Database();
        $idu=3;
        $db->query("SELECT DISTINCT * FROM modelo mo , Modelo_Usuario mu , marcas ma "
                . "where mu.favorito = 1 and mu.idUsu= $idu and mo.CodigoMod = mu.codigoMod and mo.CodigoMarca=ma.CodigoMarca"
                . "  Order by NombreMarca");


        return $db->getObject("Modelo_Usuario");
    }

    public static function findAllFav($idUsu): array {
        $db = new Database();
        $db->query("SELECT DISTINCT * FROM modelo mo , Modelo_Usuario mu , marcas ma "
                . "where mu.favorito = 1 and mu.idUsu= $idUsu and mo.CodigoMod = mu.codigoMod and mo.CodigoMarca=ma.CodigoMarca"
                . "  Order by NombreMarca");

        $data = [];
        while ($obj = $db->getObject("Modelo_Usuario"))
            array_push($data, $obj);


        return $data;
    }

    public function save() {
        $db = new Database();

        $db->query("SELECT COUNT(*) as total FROM modelo_usuario  WHERE CodigoMod= $idMod and idUsu = $idu ; ");

        $item = $db->getObject();

        if ($item->total == 0):

            // insertamos en la base de datos
            $db->query("Insert into modelo_Usuario (idUsu, codigoMod, favorito, comentario) VALUES ($idu,$idMod,0, $comentario);");

            echo " Insert into modelo_Usuario (idUsu, codigoMod, favorito, comentario) VALUES ($idu,$idMod,0, $comentario);";
            die();



        else:


            $db->query("UPDATE modelo_usuario SET comentario = " . $comentario . " WHERE  CodigoMod=$idMod  and idUsu = $idu ;");
        endif;
    }

    public function anadirFav() {
        $db = new Database();



        if (is_null($this->codigoMod)):

            // insertamos en la base de datos
            $sql = "INSERT INTO Modelo_Usuario (idUsu, codigoMod ,favorito) "
                    . "VALUES ({$this->idUsu}, {$this->codigoMod},  {$this->favorito}) ;";

            // $db->query($sql);


            echo $sql;

        else:
            $sql = "UPDATE Modelo_Usuario SET favorito= 1 WHERE idUsu={$this->idUsu} and codigoMod={$this->codigoMod};";

            echo $sql;
         $db->query($sql);

        endif;
         header("Location:index.php?con=especificaciones&ope=listar&id=$this->codigoMod");
    }

    public function eliminarFav() {
        $db = new Database();



        if (is_null($this->codigoMod)):


            // insertamos en la base de datos
            $sql = "INSERT INTO Modelo_Usuario (idUsu, codigoMod ,favorito) "
                    . "VALUES ({$this->idUsu}, {$this->codigoMod},  {$this->favorito}) ;";

            echo $sql;
            // $db->query($sql);


            echo $sql;

        else:
            $sql = "UPDATE Modelo_Usuario SET favorito= 0 WHERE idUsu={$this->idUsu} and codigoMod={$this->codigoMod};";

            echo $sql;
         $db->query($sql);

        endif;
        
         header("Location:index.php?con=especificaciones&ope=listar&id=$this->codigoMod");
    }

}
