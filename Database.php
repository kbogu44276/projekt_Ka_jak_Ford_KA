<?php
class Database {
    private $host = "mysql-20146c17-ka-jak-ford-ka.c.aivencloud.com";
    private $db_name = "defaultdb";
    private $username = "avnadmin";
    private $password = "AVNS_oZzdY04opCD4slZ6RPY";
    private $port = "21296";

    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {

            $options = array(
                PDO::MYSQL_ATTR_SSL_CA => __DIR__ . '/ca.pem',
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
            );

            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8";

            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $exception) {
            echo "Błąd połączenia: " . $exception->getMessage();
        }

        return $this->conn;
    }
}