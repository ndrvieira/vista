<?php

namespace Controllers;

use Models\Cidade;

class Controller{

    public function index(){
        $cidade = new Cidade();
        $cidades = $cidade->findAll();
        require_once('views/inicio.php');
    }

    public function redirect($url){
        header('Location: '.URL.'/'.$url);
    }

    public function api($params){

        $controllerName = ucfirst($params['controller']);
        $className = "Controllers\\{$controllerName}Controller";
        $controllerClass = new $className();

        call_user_func_array([$controllerClass, $params['funcao']], [null]); //chama a função

    }

}