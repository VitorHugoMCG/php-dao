<?php
/**
 * Classe Sql - Uma camada de abstração segura para operações com banco de dados, estendendo PDO.
 * 
 * Esta classe encapsula operações comuns de banco de dados, mantendo a flexibilidade do PDO nativo.
 * Segue o princípio de "separação de preocupações" ao isolar a execução SQL do binding de parâmetros.
 * 
 * Principais Recursos:
 * - Consultas parametrizadas (proteção contra SQL Injection)
 * - Separação clara entre preparação e execução de queries
 * - Métodos especializados para operações específicas (ex: SELECT)
 * - Tipagem estrita (PHP 7+) para maior segurança
 */
class Sql extends PDO {

    /**
     * @var PDO $conn - Conexão ativa com o banco de dados.
     * 
     * Mantida como privada para garantir encapsulamento.
     * Inicializada no construtor.
     */
    private $conn;

    /**
     * Construtor da classe Sql.
     * 
     * Estabelece a conexão com o MySQL usando PDO.
     * 
     * @throws PDOException Se a conexão falhar (tratada pelo PDO).
     */
    public function __construct() {
        $this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");
    }

    /**
     * Associa múltiplos parâmetros a uma declaração preparada (PDO Statement).
     * 
     * Método auxiliar que percorre um array associativo de parâmetros
     * e os vincula à declaração usando setParam().
     * 
     * @param PDOStatement $statement - Declaração preparada.
     * @param array $parameters - Array associativo de parâmetros (ex: [":id" => 1]).
     */
    private function setParams($statement, $parameters = array()) {
        foreach ($parameters as $key => $value) {
            $this->setParam($statement, $key, $value);
        }
    }

    /**
     * Associa um único parâmetro a uma declaração preparada.
     * 
     * Usa bindParam() do PDO para vincular valores de forma segura,
     * prevenindo SQL Injection por padrão.
     * 
     * @param PDOStatement $statement - Declaração preparada.
     * @param string $key - Nome do parâmetro (ex: ":id").
     * @param mixed $value - Valor a ser vinculado.
     */
    private function setParam($statement, $key, $value) {
        $statement->bindParam($key, $value);
    }

    /**
     * Executa uma consulta SQL parametrizada de forma segura.
     * 
     * Substitui o PDO::query() nativo para evitar conflitos de nomes,
     * adicionando suporte a prepared statements com parâmetros dinâmicos.
     * 
     * @param string $rawQuery - Consulta SQL (ex: "SELECT * FROM usuarios WHERE id = :id").
     * @param array $params - Parâmetros opcionais para binding (ex: [":id" => 5]).
     * @return PDOStatement - A declaração executada para processamento adicional.
     */
    public function execQuery($rawQuery, $params = array()) {
        $stmt = $this->conn->prepare($rawQuery);
        $this->setParams($stmt, $params);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Executa uma consulta SELECT e retorna resultados como array associativo.
     * 
     * Método de conveniência para operações SELECT, com tipagem estrita
     * (retorno declarado como `: array`).
     * 
     * @param string $rawQuery - Consulta SELECT a ser executada.
     * @param array $params - Parâmetros opcionais para binding.
     * @return array - Resultados no formato de array associativo.
     */
    public function select($rawQuery, $params = array()): array {
        $stmt = $this->execQuery($rawQuery, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>