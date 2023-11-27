<?php 
class Database
{
    private $pdo;

    public function __construct()
    {
        $host = "localhost";
        $dbname = "provaP4";
        $user = "root";
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $user);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Conexão bem-sucedida";
        } catch (PDOException $e) {
            echo "Conexão falhou: " . $e->getMessage();
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}
?>
