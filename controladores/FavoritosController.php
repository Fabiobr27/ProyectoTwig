<?php

// Controlador TABLERO
// Modelo Vista Controlador
// curso 2019/20

require_once "BaseController.php";
require_once "libs/Routing.php";
require_once "modelos/Modelo_Usuario.php";
require_once "libs/Sesion.php";

class FavoritosController extends BaseController {

    public function __construct() {
        parent::__construct();
        //echo "instanciado el controlador Tablero<br/>" ;
    }

    /**
     * muestra un listado de TODOS los tableros
     * contenidos en la base de datos.
     */
    public function listar() {

        $dat = Modelo_Usuario::findAllFav(3);
        echo $this->twig->render("showFavoritos.php.twig", ['dat' => $dat]);
    }

    public function anadirFav() {
       $id = $_GET['id'];
        $usu = Modelo_Usuario::find($id);



        $usu->anadirFav();

    }

    public function eliminarFav() {
        $id = $_GET['id'];
        $usu = Modelo_Usuario::find($id);



        $usu->eliminarFav();

        //mostramos la vista principal
         
         
    }

}
