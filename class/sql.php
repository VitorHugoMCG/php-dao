<?php

// A classe Sql estende a classe PDO, permitindo a conexão com o banco de dados e a execução de consultas SQL.
class Sql extends PDO {

    // Propriedade privada para armazenar a conexão com o banco de dados.
    private $conn;

    // O construtor é chamado automaticamente ao criar um objeto da classe.
    // Ele estabelece a conexão com o banco de dados MySQL.
    public function __construct() {
        // Criando uma nova conexão PDO com o banco de dados chamado 'dbphp7'.
        // O usuário do banco é 'root' e a senha está vazia (padrão no XAMPP).
        $this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");
    }

    // Método privado para definir múltiplos parâmetros em uma consulta SQL.
    private function setParams($statement, $parameters = array()) {
        // Percorre cada parâmetro passado para a consulta
        foreach ($parameters as $key => $value) {
            // Chama o método setParam para definir cada um dos parâmetros individualmente.
            $this->setParam($statement, $key, $value);
        }
    }

    // Método privado que associa um único parâmetro a uma consulta preparada.
    private function setParam($statement, $key, $value) {
        // bindParam associa um valor a um marcador de parâmetro SQL (exemplo: :ID, :NAME).
        $statement->bindParam($key, $value);
    }

    // Método público que executa uma consulta SQL genérica com parâmetros opcionais.
    public function execQuery($rawQuery, $params = array()) {
        // Prepara a consulta para evitar injeção de SQL.
        $stmt = $this->conn->prepare($rawQuery);

        // Define os parâmetros na consulta.
        $this->setParams($stmt, $params);

        // Executa a consulta no banco de dados.
        $stmt->execute();

        // Retorna o objeto da consulta preparada para que possa ser utilizado depois.
        return $stmt;
    }

    // Método que executa uma consulta SELECT e retorna os resultados como um array associativo.
    public function select($rawQuery, $params = array()): array {
        // Chama o método execQuery para executar a consulta.
        $stmt = $this->execQuery($rawQuery, $params);

        // Retorna os resultados da consulta em formato de array associativo.
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
