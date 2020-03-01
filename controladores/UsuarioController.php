<?php

require_once "BaseController.php";
require_once "libs/Sesion.php";
require_once "Modelos/Usuario.php";

class UsuarioController extends BaseController {

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

    public function mostrarPerfil() {
/*
        $ses = Sesion::getInstance();
        $usr = $ses->getUsuario();
        $idu = $usr->getIdUsu();

        echo "HOLA";
      */
          $dat = Usuario::find(3);
          echo $this->twig->render("showPerfil.php.twig", ['dat' => $dat]);
         
    }

    public function mostrarCuentas() {
        $dat = Usuario::findAll();
        echo $this->twig->render("showCuentas.php.twig", ['dat' => $dat]);
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

                echo $this->twig->render("Login.php.twig");
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


        header("Location: index.php");
    }

    public function borrar() {
        $id = $_GET['id'];
        $usu = Usuario::find($id);

        $usu->eliminar();

        //mostramos la vista principal
        header("Location: index.php?con=Usuario&ope=mostrarCuentas");
    }

    public function hacerAdmin() {
        $id = $_GET['id'];
        $usu = Usuario::find($id);

        $usu->hacerAdmin();

        header("Location: index.php?con=Usuario&ope=mostrarCuentas");
    }

}
