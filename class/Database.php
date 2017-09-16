<?php

class Database
{
    private static $instance = NULL;

    private $pdo,
        $errors = FALSE,
        $query,
        $results,
        $count = 0;

    private function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=" . DB_HOST . ";charset=utf8;dbname=" . DB_NAME . ";charset = utf8;", DB_USER, DB_PASS);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function query($sql, $parameters = [])
    {
        $this->errors = false;
        if ($this->query = $this->pdo->prepare($sql)) {
            $x = 1;
            foreach ($parameters as $parameter) {
                $this->query->bindValue($x, $parameter);
                $x++;
            }
        }
        if ($this->query->execute()) {
            $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
            $this->count = $this->query->rowCount();
        } else {
            echo $this->errors = "There was a problem executing this query";
        }
        return $this;
    }

    public function insert($table, $parameters = array())
    {
        if (count($parameters)) {
            $columns = implode(',', array_keys($parameters));
            $placeholders = "";
            $x = 1;
            foreach ($parameters as $parameter) {
                $placeholders .= "?";
                if ($x < count($parameters)) {
                    $placeholders .= ", ";
                }
                $x++;
            }
            $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
            if (!$this->query($sql, $parameters)->errors()) {
                return true;
            }
        }
        return false;
    }

    public function update($table, $id, $parameters = array())
    {
        if (count($parameters)) {
            $set = "";
            $x = 1;
            foreach ($parameters as $column => $value) {
                $set .= $column . "=?";
                if ($x < count($parameters)) {
                    $set .= ", ";
                }
                $x++;
            }
            $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
            if (!$this->query($sql, $parameters)->errors()) {
                return true;
            }
        }
        return false;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function results()
    {
        return $this->results;
    }

    public function count()
    {
        return $this->count;
    }

    public function first()
    {
        return $this->results()[0];
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}