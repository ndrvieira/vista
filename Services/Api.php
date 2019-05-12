<?php

namespace Services;

use Models\Bairro;
use Models\Cidade;

class Api {

    public $dados;

    public function request(){

        $cidade = new Cidade();
        $cidade->find($_POST['cidade']);
        
        $bairro = new Bairro();
        $bairros_resultado = $bairro->where(['id' => $_POST['bairro']]);

        $filtros_add = [
            'Bairro' => [],
            'Cidade' => str_replace(" ", "+", $cidade->nome)
        ];
        foreach($bairros_resultado as $bairro){
            array_push($filtros_add['Bairro'], str_replace(" ", "+", $bairro['nome']));
        }
        $this->setDados();
        $this->dados['filter'] = $filtros_add;
        
        $resultados = $this->curl();
        require('views/imovel/list.php');
    }

    public function requestCodigo($codigo){

        $filtros_add = [
            'Codigo' => $codigo,
        ];
        $this->setDados();
        $this->dados['filter'] = $filtros_add;
        
        $resultados = $this->curl();
        require('views/imovel/show.php');
    }

    public function curl(){

        $key = 'c9fdd79584fb8d369a6a579af1a8f681';
        $postFields = json_encode($this->dados);
        $url = 'http://sandbox-rest.vistahost.com.br/imoveis/listar?key=' . $key;
        $url .= '&pesquisa=' . $postFields;
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        $result = curl_exec($ch);
    
        return json_decode($result, true);

    }

    public function setDados(){

        $this->dados = [
            'fields' => [
                'Codigo',
                'Status',
                'FotoDestaque',
                'Caracteristicas',
                'Categoria',
                'Dormitorios',
                'Vagas',
                'AreaTotal',
                'AreaPrivativa',
                'Cidade',
                'Bairro',
                'ValorVenda',
                'ValorLocacao',
                'Moeda',
                'Vagas',
                'Suites',
                'Churrasqueira',
                'Lareira',
                'Latitude',
                'Longitude',
                [
                    'Agencia' => [
                        'Nome',
                        'Fone',
                        'Endereco',
                        'Bairro',
                        'Cidade'
                    ]
                ]
            ],
            'order' => [
                "Bairro" => "asc"
            ],
            'paginacao' => [
                "pagina" => 1,
                "quantidade" => 50
            ]
        ];
    }
}
