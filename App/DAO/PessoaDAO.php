<?php

namespace App\DAO;

use App\Model\PessoaModel;
use \PDO;

// acesso ao banco
// toda vez que a classe for chamada, já conecta no bd
/**
 * As classes DAO (Data Access Object) são responsáveis por executar os
 * SQL junto ao banco de dados.
 */
class PessoaDAO extends DAO {

    /**
     * Método construtor, sempre chamado na classe quando a classe é instanciada
     * Exemplo de instanciar classe (criar objeto da classe):
     * $dao = new PessoaDAO();
     * Neste caso, assim que é instânciado, abre uma conexão com o MySQL (Banco de dados)
     * A conexão é aberta via PDO (PHP Data Object) que é um recurso da linguagem para
     * acesso a diversos SGBDs.
     */
    public function __construct() 
    {    
        parent::__construct();   
    }

    /**
     * Método que recebe um model e extrai os dados do model para realizar o insert
     * na tabela correspondente ao model. Note o tipo do parâmetro declarado.
     */
    public function insert(PessoaModel $model) {
        // Trecho de código SQL com marcadores ? para substituição posterior, no prepare
        $sql = "INSERT INTO pessoa (nome, cpf, data_nascimento) VALUES (?, ?, ?)";

        //PREPARED STATMENT
        // Declaração da variável stmt que conterá a montagem da consulta. Observe que
        // estamos acessando o método prepare dentro da propriedade que guarda a conexão
        // com o MySQL, via operador seta "->". Isso significa que o prepare "está dentro"
        // da propriedade $conexao e recebe nossa string sql com os devidor marcadores.
        $stmt = $this->conexao->prepare($sql);

        // Nesta etapa os bindValue são responsáveis por receber um valor e trocar em uma 
        // determinada posição, ou seja, o valor que está em 3, será trocado pelo terceiro ?
        // Note que o bindValue está recebendo o model que veio via parâmetro e acessamos
        // via seta qual dado do model queremos pegar para a posição em questão.
        $stmt->bindValue(1, $model->nome);
        $stmt->bindValue(2, $model->cpf);
        $stmt->bindValue(3, $model->data_nascimento);

        // executa
        $stmt->execute();
    }

    public function update(PessoaModel $model) {
        $sql = "UPDATE pessoa SET nome=?, cpf=?, data_nascimento=? WHERE id=? ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $model->nome);
        $stmt->bindValue(2, $model->cpf);
        $stmt->bindValue(3, $model->data_nascimento);
        $stmt->bindValue(4, $model->id);

        $stmt->execute();
    }

    /**
     * Método que retorna todas os registros da tabela pessoa no banco de dados.
     */
    public function select() {
        // select retorna linhas de resgistro ([campo, valor])
        $sql = "SELECT * FROM pessoa";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute(); // ou query

        return $stmt->fetchAll(PDO::FETCH_CLASS); // retorna todos os registros da tabela pessoa 
                                                 // na forma de um array de objetos
                                                // os objetos são do tipo stdClass e
                                               // foram criados automaticamente pelo
                                              // fetchAll do PDO
    }

    public function selectById(int $id)
     {
        $sql = "SELECT *FROM pessoa WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute(); // necessário retornar, pois virão linhas da tabela

        return $stmt->fetchObject("App\Model\PessoaModel"); // passar o sub namespace
    }

    // deleção pelo id da pessoa
    public function delete($id) {  
        $sql = "DELETE FROM pessoa WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }
}