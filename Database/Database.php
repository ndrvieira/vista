<?php

namespace Database;

use PDO;

class Database
{

    protected $table;
    protected $pk_column;
    private $pdo;
    protected $join;
    protected $join_columns;

    /**
     * Realiza conexão com o banco de dados. Configuraçõs do banco de dados ficam em config.php
     * @return void
     */
    public function __construct()
    {

        try {
            $db = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB_NAME, MYSQL_USER, MYSQL_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (Exception $e) {
            echo 'Exception -> ';
            var_dump($e->getMessage());
            $db->rollBack();
        }

        $this->pdo = $db;
    }

    /**
     * Adiciona join para realizar um select depois
     * @param string $foreign_table nome da tabela que deseja realizar o join. (TABELA)
     * @param string $local_column nome da coluna local. (FK)
     * @param string $foreign_column nome da coluna existente na outra tabela que deseja adicionar o join. (PK)
     * @param array $select_columns array com os nomes das colunas da outra tabela que você deseja que apareça no select (nome, endereço, etc)
     * @return void
     */
    public function addJoin($foreign_table, $local_column, $foreign_column, $select_columns){
        if(!is_array($this->join)){
            $this->join = [];
        }
        if(!is_array($this->join_columns)){
            $this->join_columns = [];
        }
        array_push($this->join, "join $foreign_table on $foreign_table.$foreign_column = $this->table.$local_column");
        foreach($select_columns as $column){
            array_push($this->join_columns, $foreign_table.".".$column." as ".$foreign_table."_".$column);
        }
    }

    /**
     * Busca todos os registros do model
     * @param int $offset Offset do select. (Opcional)
     * @param int $limit Limit do select. (Opcional)
     * @return array Array de objetos
     */
    public function findAll($offset = null, $limit = null)
    {
        ($offset) ? "OFFSET $offset" : "";
        ($limit) ? "LIMIT $limit" : "";
        if($this->join) {
            $joins = implode(" ", $this->join);
            $join_columns = implode(",", $this->join_columns);
            $query = "SELECT $this->table.*,$join_columns FROM $this->table $joins $offset $limit";
        } else {
            $query = "SELECT * FROM $this->table $offset $limit";
        }
        $stmt_list = $this->pdo->query($query);
        return $this->array_to_object($stmt_list->fetchAll());
    }

    /**
     * Busca registro por id
     * @param int $id ID da tabela.
     * @return object
     */
    public function find($id)
    {
            
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table where $this->pk_column = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $fetch = $stmt->fetch();
        foreach ($fetch as $key => $value) {
            $this->$key = $value;
        }
        return $fetch;

    }

    /**
     * Busca registro por campo
     * @param array $array_fields Array('nome_coluna' => 'condicao') OBS: a condicao também pode ser um array de condições, que será tratado como: nome_coluna IN (condicao1, condicao2)
     * @return object
     */
    public function where($array_fields)
    {

        $where_string = "";
        $i = 0;
        foreach($array_fields as $key => $value){
            if($i != 0){
                $where_string .= " and ";
            }
            if(is_array($value)){ //se a condicao for um array
                $in_string = "";
                foreach ($value as $condicao_key => $condicao)
                {
                    $nova_condicao_key = ":id".$condicao_key;
                    $in_string .= "$nova_condicao_key,";
                }
                $in_string = rtrim($in_string,",");
                $where_string .= "$key IN ($in_string)";
            } else {
                $where_string .= "$key = :$key";
            }
        }
        
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table where $where_string");
        
        foreach($array_fields as $key => $value){
            if(is_array($value)){
                foreach ($value as $condicao_key => $condicao)
                {
                    $nova_condicao_key = ":id".$condicao_key;
                    $stmt->bindValue($nova_condicao_key, $condicao);
                }
            } else {
                $stmt->bindValue($key, $value);
            }
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Insere registros
     * @param array $regs Array com nome do campo e valor. Ex: ['nome' => 'teste']
     * @return boolean
     */
    public function insert($regs)
    {

        $columns = implode(",", array_keys($regs));
        $columns_bind = ":" . implode(",:", array_keys($regs));

        $stmt = $this->pdo->prepare("INSERT INTO $this->table ($columns) VALUES ($columns_bind)");

        foreach ($regs as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Erro ao inserir registro na tabela " . $this->table, 1);
        }
    }

    /**
     * Salva o model no banco
     * @return void
     */
    public function save()
    {
        foreach ($this as $key => $value) {
            if (in_array($key, $this->columns)) {
                $stmt = $this->pdo->prepare("UPDATE $this->table SET $key = :$key WHERE $this->pk_column = :id");
                $stmt->bindParam('id', $this->id);
                $stmt->bindParam($key, $value);
                if (!$stmt->execute()) {
                    throw new Exception("Erro ao atualizar registro na tabela " . $this->table, 1);
                }
            }
        }
    }

    /**
     * Deleta registro no banco
     * @param int $id ID da tabela
     * @return void
     */
    public function delete($id)
    {
        if(isset($this->relations)){
            $tabela = $this->relations['table'];
            $fk = $this->relations['fk'];
            $stmt = $this->pdo->prepare("SELECT * FROM $tabela WHERE $fk = :id LIMIT 1");
            $stmt->bindParam('id', $id);
            $stmt->execute();
            if($stmt->fetch()){
                echo "Não foi possível deletar este registro, pois este possui relacionamentos";
                die();
            }
        }
        
        $stmt = $this->pdo->prepare("DELETE FROM $this->table WHERE $this->pk_column = :id");
        $stmt->bindParam('id', $id);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao deletar registro na tabela " . $this->table, 1);
        }
    }

    /**
     * Transforma array em objeto (Recursivo)
     * @return object
     */
    public function array_to_object($array)
    {
        $obj = new \stdClass;
        foreach ($array as $k => $v) {
            if (strlen($k)) {
                if (is_array($v)) {
                    $obj->{$k} = $this->array_to_object($v);
                } else {
                    $obj->{$k} = $v;
                }
            }
        }
        return $obj;
    }
}
