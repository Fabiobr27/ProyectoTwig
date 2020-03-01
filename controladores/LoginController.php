<?php

require_once "BaseController.php";
require_once "libs/Sesion.php";
require_once "Modelos/Marca.php";
require_once "Modelos/Usuario.php";

class LoginController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    public function mostrar() {
        $sesion = Sesion::getInstance();
        if ($sesion->checkActiveSession()) {
            $this->inicio();
        } else {
            echo $this->twig->render("Login.php.twig");
        }
    }

    public function IniciarSesion() {

        if (isset($_GET['email'])) {
            $ses = Sesion::getInstance();

            $email = $_GET['email'];
            $pass = $_GET['pass'];

            $existe = $ses->login($email, $pass);

            if ($existe) {
                $this->inicio();
            } else {

                //echo $this->twig->render("Login.php.twig");
            }
        }
    }

    public function inicio() {
        $dat = Marca::findAll();
        echo $this->twig->render("showMarcas.php.twig", ['dat' => $dat]);
    }

    public function logout() {


        session_start();


        $ses = Sesion::getInstance();

        $ses->close();

        $ses->redirect("index.php");




        $_SESSION[] = [];

        session_destroy();


        //header("Location: index.php");
    }

    public function registro() {

        if (!isset($_GET["nombre"])):

            echo $this->twig->render("Registro.php.twig");
        else:


            // crear y guardar el tablero
            $nom = $_GET["nombre"];
            $fec = $_GET["fnac"];
            $ape = $_GET["apellidos"];
            $pass = $_GET["pass"];
            $ema = $_GET["email"];
            // creamos el tablero
            $usu = new Usuario();
            $usu->setNombre($nom);
            $usu->setFecha($fec);
            $usu->setApellidos($ape);
            $usu->setPass($pass);
            $usu->setEmail($ema);

            // guardamos el tablero
            $usu->insertar();

            //echo $_SERVER["HTTP_HOST"] ;
            // redirigimos al índice
           header("Location: index.php");

        endif;
    }

}
