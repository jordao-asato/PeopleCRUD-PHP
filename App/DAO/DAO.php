<?php

namespace App\DAO;

use \PDO;

abstract class DAO {

    /**
     * Atributo (ou Propriedade) da classe destinado a armazenar o link (vínculo aberto)
     * de conexão com o banco de dados.
     */
    protected $conexao;

    public function __construct()
    {
        // DSN (Data Source Name) onde o servidor MySQL será encontrado
        // (host) em qual porta o MySQL está operado e qual o nome do banco pretendido
        $dsn = "mysql:host=" . $_ENV['db']['host'] . ";dbname=" . $_ENV['db']['database'];

        // fazer a conexão com o SGBD
        $this->conexao = new PDO($dsn, $_ENV['db']['user'], $_ENV['db']['pass']);
    }
}
