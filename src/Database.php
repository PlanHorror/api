<?php
//This class is used to connect to the database
    class Database {
        public function __construct(private string $host, private string $user, private string $password, private string $database) {
        }
        public function connect(): PDO {
            $dsn = "mysql:host=$this->host;dbname=$this->database";
            return new PDO($dsn, $this->user, $this->password,[PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_STRINGIFY_FETCHES => false]);
            // ATTR_EMULATE_PREPARES is a constant that is used to disable the emulation of prepared statements
            // ATTR_STRINGIFY_FETCHES is a constant that is used to disable the conversion of numeric values to strings when fetching
        }
    }