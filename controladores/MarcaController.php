<?php

// Controlador MARCA
//Fabio Benitez Ramirez

require_once "BaseController.php";
require_once "libs/Routing.php";
require_once "modelos/Marca.php";

class MarcaController extends BaseController {

    public function __construct() {
        parent::__construct();
       
    }

    
    public function listar() {
        
        $dat = Marca::findAll();
        echo $this->twig->render("showMarcas.php.twig", ['dat' => $dat]);
      
    }

    /**
     * muestra los contenidos del tablero en un
     * formulario para que el usuario pueda 
     * modificarlos.
     */
    public function editar() {
        // buscamos el tablero
        $dat = Tablero::find($_GET["id"]);

        if (!isset($_GET["nom"])):

            // mostramos el formulario de edición
            //require_once "vistas/editBoard.php" ;
            echo $this->twig->render("editBoard.php.twig");
        else:

            // actualizar la información en la 
            // base de datos.
            $nom = $_GET["nom"];
            $fec = $_GET["fec"];

            // actualizar los datos
            $dat->setNombre($nom);
            $dat->setFecha($fec);

            // refrescar el objeto en la base de datos
            $dat->save();

            // redirigimos a la página principal
            route('index.php', 'tablero', 'listar');
        endif;
    }

    /**
     * actualiza los datos del tablero en la base
     * de datos. FUNCIÓN SEPARADA DE LA QUE MUESTRA
     * EL FORMULARIO CON LOS DATOS DEL TABLERO.
     */
    public function guardar() {
        $idt = $_GET["id"];
        $nom = $_GET["nom"];
        $fec = $_GET["fec"];

        // buscar el tablero
        $tab = Tablero::find($idt);

        // actualizar los datos
        $tab->setNombre($nom);
        $tab->setFecha($fec);

        // refrescar el objeto en la base de datos
        $tab->save();

        // PRO : Es más 'rápido', porque no se hace una nueva
        // llamada al servidor.
        // CON : La URL se queda como está.
        //$this->listar() ;
        // CONS: "Menos eficiente" porque se hace una llamada 
        // más al servidor. 
        // PRO : La URL es la correcta (no es la de editar)
        route('index.php', 'tablero', 'listar');

        //echo "<pre>".print_r($tab, true)."</pre>" ;
    }

    /**
     * borramos el tablero
     */
    public function borrar() {
        $idt = $_GET["id"];
        $tab = Tablero::find($idt);
        $tab->delete();

        // redirigimos al índice
        route('index.php', 'tablero', 'listar');
    }

    public function anadir() {
        if (!isset($_GET["nom"])):
            // si no tengo datos sobre el tablero, 
            // muestro el formulario vacío
            require_once "vistas/addBoard.php";
        else:
            // crear y guardar el tablero
            $nom = $_GET["nom"];
            $fec = $_GET["fec"];

            // creamos el tablero
            $tab = new Tablero();
            $tab->setNombre($nom);
            $tab->setFecha($fec);

            // guardamos el tablero
            $tab->save();

            //echo $_SERVER["HTTP_HOST"] ;
            // redirigimos al índice
            route('index.php', 'tablero', 'listar');

        endif;
    }

}
