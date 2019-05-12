<?php

namespace Models;

use Database\Database;

class Bairro extends Database{

    protected $table = 'bairros';

    protected $pk_column = 'id';
    protected $columns = ['nome', 'cidade'];

}