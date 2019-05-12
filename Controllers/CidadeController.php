<?php

namespace Controllers;

use Models\Cidade;
use Controllers\Controller;

class CidadeController extends Controller{

    public function index(){

        $cidade = new Cidade();
        $resultados = $cidade->findAll();
        require_once('views/cidade/index.php');

    }

    public function create(){

        require_once('views/cidade/save.php');
        
    }

    public function store(){

        if(isset($_POST)){
            $cidade = new Cidade();
            $cidade->insert([
                'nome' => $_POST['nome']
            ]);
        }
        $this->redirect('cidade');
        
    }

    public function edit($params){

        if(isset($params)){
            $cidade = new Cidade();
            $cidade->find($params['id']);
            require_once('views/cidade/save.php');
        } else {
            $this->redirect('cidade');
        }

    }

    public function update($params){

        if(isset($params)){
            $cidade = new Cidade();
            $cidade->find($params['id']);
            $cidade->nome = $_POST['nome'];
            $cidade->save();
        }
        $this->redirect('cidade');
    }
    
    public function delete(){
        
        if(isset($_POST)){
            $cidade = new Cidade();
            $cidade->delete($_POST['id']);
        }
        $this->redirect('cidade');

    }

}