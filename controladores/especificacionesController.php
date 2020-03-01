<?php

// Controlador Especificaciones
// Modelo Vista Controlador
// curso 2019/20
// Utilizamos: 
// https://www.tiny.cloud/docs/api/tinymce/root_tinymce/
// https://www.sitepoint.com/best-html-wysiwyg-plugins/

require_once "BaseController.php";
require_once "libs/Routing.php";
require_once "modelos/Modelo.php";
require_once "modelos/Marca.php";
require_once "modelos/Especificaciones.php";
require_once "modelos/Modelo_Usuario.php";

class especificacionesController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * muestra un listado de TODOS los tableros
     * contenidos en la base de datos.
     */
    public function listar() {
        // obtenemos información sobre el tablero
        $tab = Modelo::find($_GET["id"]);

        // obtenemos una relación de las notas del tablero
        $dat = Especificaciones::findAll($_GET["id"]);

        $com = Modelo_Usuario::findComentarios($_GET["id"]);
        // mostramos la información
        echo $this->twig->render("showEspecificacion.php.twig", ['tab' => $tab, 'dat' => $dat, 'com' => $com]);
    }

    /**
     * Añadir una nueva nota al tablero
     */
    public function editar() {
        // buscamos el tablero
        $dat = Modelo_Usuario::find($_GET["id"]);

        if (!isset($_GET["genero"])):

            // mostramos el formulario de edición
            require_once "vistas/editGenero.php";
        else:

            // actualizar la información en la 
            // base de datos.
            $gen = $_GET["genero"];


            // actualizar los datos
            $dat->setGenero($gen);


            // refrescar el objeto en la base de datos
            $dat->save();

            // redirigimos a la página principal
            route('index.php', 'Serie', 'listar');
        endif;
    }

    public function borrar() {
        $idCodigo = $_GET["id"];
        $Mod_usu = Modelo_Usuario::findComentarios($idCodigo);
        $Mod_usu->delete();

        // redirigimos al índice
        //route('index.php', 'genero', 'listar');
    }

    public function anadirComentarios() {
        $com = Modelo_Usuario::findComentarios($_GET["id"]);
        if (!isset($_GET["comentario"])):

            require_once "vistas/addSerie.php";
        else:
            // crear y guardar el tablero
            $com = $_GET["comentario"];
            







            $mod_usu = new Modelo_Usuario();
            $mod_usu->setComentario($Com);
           



            $mod_usu->save();


            route('index.php', 'Marca', 'listar');
        endif;
    }

}
