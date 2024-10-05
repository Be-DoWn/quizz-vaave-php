<?php
//PDO - PHP Data Objects, expect a parameter dns - Data source name

//connecting db

class Database
{
    public $connection;
    public $statement;

    public function __construct($config)
    { //executed immediately


        $dsn = 'mysql:' . http_build_query($config, '', ';'); //short form - http_build_query(data,prifix,sperator)

        // $dns = "mysql:host=localhost;port=3306;dbname=php;charset=utf8mb4";
        $this->connection = new PDO(
            $dsn,
            'root',
            '1234',
            [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );
    }

    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);
        return $this;
    }

    public function prepare($query)
    {
        $this->statement = $this->connection->prepare($query);
        return $this; // return same object
    }

    public function execute($params = [])
    {
        return $this->statement->execute($params); // execute
    }

    public function fetch()
    {
        return $this->statement->fetch();
    }

    public function fetchAll()
    {
        return $this->statement->fetchAll();
    }

}
