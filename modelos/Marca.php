<?php

// Modelo TABLERO
// Modelo Vista Controlador
// curso 2019/20

require_once "libs/Database.php";

class Marca {

    private $NombreMarca;
    private $CodigoMarca;
    private $anioFundacion;
    private $logo;

    /**/

    public function __construct() {
        
    }

    public function getCodigoMarca() {
        return $this->CodigoMarca;
    }

    public function setCodigoMarca($CodigoMarca) {
        $this->CodigoMarca = $CodigoMarca;

        return $this;
    }

    public function getNombreMarca() {
        return $this->NombreMarca;
    }

    public function setNombreMarca($NombreMarca) {
        $this->NombreMarca = $NombreMarca;

        return $this;
    }

    public function getlogo() {
        return $this->logo;
    }

    /**
     * @param mixed $poster
     *
     * @return self
     */
    public function setlogo($logo) {
        $this->logo = $logo;

        return $this;
    }

    public function getanioFundacion() {
        return $this->anioFundacion;
    }

    public function setanioFundacion($anioFundacion) {
        $this->anioFundacion = $anioFundacion;

        return $this;
    }


    /**
     * busque y devuelva los tableros almacenados
     * en la base de datos.
     */
    public static function findAll() {
        $db = new Database();
        $db->query("SELECT * FROM Marcas ;");

        $data = [];
        while ($obj = $db->getObject("Marca"))
            array_push($data, $obj);

        //
        return $data;
    }

    /**
     * busque y devuelva los tableros almacenados
     * en la base de datos.
     */
    public static function find(int $id): Marca {
        $db = new Database();
        $db->query("SELECT * FROM marcas WHERE codigoMarca = $id ;");

        //
        return $db->getObject("Marca");
    }

    /**
     * actualizar el objeto en la base de datos
     */
    public function save() {
        $db = new Database();

        if (is_null($this->idTab)):

            // insertamos en la base de datos
            $db->query("INSERT INTO tablero (nombre, fecha) VALUES ('{$this->nombre}', '{$this->fecha}') ;");

            // obtener el último ID
            $this->idTab = $db->lastId();
        else:

            // actualizamos el tablero
            $db->query("UPDATE tablero SET nombre='{$this->nombre}', fecha='{$this->fecha}' WHERE idTab={$this->idTab} ;");
        endif;

        return $this;
    }

    /**
     * borra un tablero de la base de datos
     */
    public function delete() {
        $db = new Database();
        $db->query("DELETE FROM tablero WHERE idTab={$this->idTab} ;");
    }

}
