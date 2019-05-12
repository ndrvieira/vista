<?php

class Routes{

    public $url;
    public $controller;
    public $function;
    public $params;

    /**
     * Verifica se a url é uma API para não carregar o index.php
     * @return void
     */
    public function apiRoute(){

        $this->url = $_SERVER['REQUEST_URI'];
        $explode_route = explode("/", $_SERVER['REQUEST_URI']);

        if(isset($explode_route[1]) && $explode_route[1] == 'api'){
            $this->loadRoute();
            die(); //previne que o restante da página execute
        }

    }

    /**
     * Carrega a rota com base na url.
     * Valor após a primeira barra = Instancia o controlador. Exemplo: /bairro = new Controller\BairroController;
     * Valor após a segunda barra = Chama a função. Exemplo /bairro/create = $controlador->create();
     * @return void
     */
    public function loadRoute(){

        $this->url = $_SERVER['REQUEST_URI'];

        $explode_route = explode("/", $_SERVER['REQUEST_URI']);

        $this->function = "index"; //por padrão a função é index

        if(empty($explode_route[1]) OR end($explode_route) == 'index.php'){

            $className = "Controllers\\Controller";
            $controllerClass = new $className();
            
        } elseif(isset($explode_route[1]) && $explode_route[1] == 'api'){

            $className = "Controllers\\Controller";
            $controllerClass = new $className();
            $this->function = "api";
            $this->params = [
                'controller' => $explode_route[2],
                'funcao' => $explode_route[3]
            ];

        } else {

            $this->controller = ucfirst($explode_route[1])."Controller";

            if(file_exists('Controllers/'.$this->controller.'.php')){ //se existir instancia o controlador

                $className = "Controllers\\{$this->controller}";
                $controllerClass = new $className();

            } else {

                echo "Erro. Controlador $this->controller não encontrado";

            }

            if(isset($explode_route[2])){ //seta função no controlador

                $this->function = $explode_route[2];

            }

            if(isset($explode_route[3])){ //seta id

                $this->params = [
                    'id' => $explode_route[3]
                ];
                
            }
        }

        call_user_func_array([$controllerClass, $this->function], [$this->params]); //chama a função
        return;
    }

}