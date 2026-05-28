<?php

namespace App\Model;

use App\DAO\PessoaDAO;

// camada intermediária
/**
 * A camada model é responsável por transportar os dados da Controller até a DAO e vice-versa.
 * Também é atribuído a Model a validação dos dados da View e controle de acesso aos métodos
 * da DAO.
 */
class PessoaModel extends Model {

    /**
     * Declaração das propriedades conforme campos da tabela no banco de dados.
     */
    public $id, $nome, $cpf, $data_nascimento;

    /**
     * Declaração do método save que chamará a DAO para gravar no banco de dados
     * o model preenchido.
     */
    public function save() {

        // conectou ao banco
        $dao = new PessoaDAO();

        if(empty($this->id)) {
            $dao->insert($this);
        } else {
            $dao->update($this);
        }
    }

    /**
     * Método que encapsula a chamada à DAO e que abastecerá a propriedade rows;
     * Esse método é importante, pois como a model é "vista" na View a propriedade
     * $rows será acessada e possibilitará listar os registros vindos do banco de dados
     */
    public function getAllRows() {

        $dao = new PessoaDAO();

        // Abastecimento da propriedade $rows com as "linhas" vindas do MySQL
        // via camada DAO.
        $this->rows = $dao->select();
    }

    public function getById(int $id) {

        $dao = new PessoaDAO();

        $obj = $dao->selectById($id);

        /*
        Se encontrar algo, retorna o objeto
        senão, o selectById irá retornar falso
        e retorna uma nova PessoaModel que está vazio
        */
        return ($obj) ? $obj : new PessoaModel();
                       // if : else

        /*
        if($obj) {
            return $obj;
        }
        else {
            return new PessoaModel();
        }
        */
    }

    public function delete(int $id)
    {
        $dao = new PessoaDAO();

        $dao->delete($id);
    }
}