<?php

namespace Models;

use Database\Database;

class Cidade extends Database{

    protected $table = 'cidades';

    protected $pk_column = 'id';
    protected $columns = ['nome'];

    protected $relations = [
        'table' => 'bairros',
        'fk' => 'cidade',
        'pk' => 'id'
    ];

}