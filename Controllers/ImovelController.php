<?php

namespace Controllers;

use Controllers\Controller;
use Services\Api;

class ImovelController extends Controller{

    public function getImoveis(){

        $api = new Api;
        $resultados = $api->request();

    }

    public function show($codigo){

        $api = new Api;
        $resultados = $api->requestCodigo($codigo['id']);

    }

}