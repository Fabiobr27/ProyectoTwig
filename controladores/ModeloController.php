<?php

// Controlador NOTA
// Modelo Vista Controlador
// curso 2019/20
// Utilizamos: 
// https://www.tiny.cloud/docs/api/tinymce/root_tinymce/
// https://www.sitepoint.com/best-html-wysiwyg-plugins/

require_once "BaseController.php";
require_once "libs/Routing.php";
require_once "modelos/Modelo.php";
require_once "modelos/Marca.php";
require_once "modelos/Usuario.php";
require_once "libs/Sesion.php";

class ModeloController extends BaseController {

    public function __construct() {
        parent::__construct();
        //echo "instanciado el controlador Tablero<br/>" ;
    }

    /**
     * muestra un listado de TODOS los tableros
     * contenidos en la base de datos.
     */
    public function listar() {
        // obtenemos información sobre el tablero
        $tab = Marca::find($_GET["id"]);

        // obtenemos una relación de las notas del tablero
        $dat = Modelo::findAll($_GET["id"]);
/*
        $ses = Sesion::getInstance();
        $usr = $ses->getUsuario();
        $idu = $usr->getIdUsu();
        $usu = Usuario::find($idu);
*/
        // mostramos la información
        echo $this->twig->render("showModelos.php.twig", ['tab' => $tab, 'dat' => $dat, /*'usu' => $usu*/]);
    }
}

    /**
     * Cambiar el estado de la nota
     */
 
