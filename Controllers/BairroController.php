<?php

namespace Controllers;

use Models\Bairro;
use Models\Cidade;
use Controllers\Controller;

class BairroController extends Controller{

    public function index(){

        $bairro = new Bairro();
        $bairro->addJoin('cidades', 'cidade', 'id', ['nome']);
        $resultados = $bairro->findAll();
        require_once('views/bairro/index.php');

    }

    public function create(){

        $cidade = new Cidade();
        $cidades = $cidade->findAll();
        require_once('views/bairro/save.php');
        
    }

    public function store(){

        if(isset($_POST)){
            $bairro = new Bairro();
            $bairro->insert([
                'nome' => $_POST['nome'],
                'cidade' => $_POST['cidade']
            ]);
        }
        $this->redirect('bairro');
        
    }

    public function edit($params){

        if(isset($params)){
            $bairro = new Bairro();
            $bairro->find($params['id']);
            $cidade = new Cidade();
            $cidades = $cidade->findAll();
            require_once('views/bairro/save.php');
        } else {
            $this->redirect('bairro');
        }

    }

    public function update($params){

        if(isset($params)){
            $bairro = new Bairro();
            $bairro->find($params['id']);
            $bairro->nome = $_POST['nome'];
            $bairro->cidade = $_POST['cidade'];
            $bairro->save();
        }
        $this->redirect('bairro');

    }

    public function delete(){

        if(isset($_POST)){
            $bairro = new Bairro();
            $bairro->delete($_POST['id']);
        }
        $this->redirect('bairro');

    }

    public function getBairrosFromCidade(){

        if(isset($_POST['cidade']) && filter_var($_POST['cidade'], FILTER_VALIDATE_INT)){
            $bairro = new Bairro();
            $resultados = $bairro->where(['cidade' => $_POST['cidade']]);
            $retorno = json_encode($resultados);
            echo $retorno;
        }
    }

}