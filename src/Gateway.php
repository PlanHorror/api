<?php
    class Gateway{
        private PDO $conn;
        public function __construct(Database $db) {
            $this->conn = $db->connect();
        }
        public function get_all(): array {
            $stmt = $this->conn->query("SELECT * FROM user");
            // prepare() is a PDO method that prepares a statement for execution and returns a statement object.
            $data = [];
            // while loop when fetching each row from the database, this loop will continue until there are no more rows to fetch.
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $row["is_active"] = (bool)$row["is_active"];
                // (bool) is used to convert the value to a boolean
                $data[] = $row;
                // in php [] is used to add an element to an array
            }
            return $data;
        }
        public function getById(string $id): array{
            $sql = "SELECT * FROM user where id = $id";
            $stmt = $this->conn->query($sql);
            $data = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $row["is_active"] = (bool)$row["is_active"];
                $data[] = $row;
            }
            return $data;
        }
        function create($data){
            $sql = "INSERT INTO user (username,first_name,last_name, email, gender,is_active) VALUES (:username,:first_name,:last_name, :email, :gender,:is_active)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":username", $data["username"], PDO::PARAM_STR);
            $stmt->bindValue(":first_name", $data["first_name"], PDO::PARAM_STR);
            $stmt->bindValue(":last_name", $data["last_name"], PDO::PARAM_STR);
            $stmt->bindValue(":email", $data["email"], PDO::PARAM_STR);
            $stmt->bindValue(":gender",$data["gender"], PDO::PARAM_STR);
            // bindValue() is a PDO method that binds a value to a parameter in a prepared statement.
            // PDO::PARAM_STR is a constant that specifies the data type of the parameter.
            // PDO::PARAM_BOOL is a constant that specifies the data type of the parameter.
            $stmt->bindValue(":is_active", (bool)$data["is_active"], PDO::PARAM_BOOL);
            $stmt->execute();
            return $this->conn->lastInsertId();
            // lastInsertId() is a PDO method that returns the ID of the last inserted row or sequence value.
        }
    }