<?php
    /**
     * Shawn Xu Section AA
     * Here is all the reuseable functions to reduce redundency
     */

    error_reporting(E_ALL);
    // Function for setting up the database object
    function setDatabase() {
        $db = new PDO("mysql:dbname=hw7;host=localhost;charset=utf8", "root", "");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return ($db);
    }
    
    // Check required paramber nad return corresponding error messgae
    function checkParam($param1, $param2, $isChooseOne) {
        $result = [];
        if ($param2 == NULL) {
            $result[] = ["error" => "Missing $param1 parameter"];
        } else {
            if ($isChooseOne) {
                $result[] = ["error" => "Missing $param1 or $param2 parameter"];
            } else {
                $result[] = ["error" => "Missing $param1 and $param2 parameter"];
            }
        }
        return json_encode($result);
    }
    
    // Check if pokemon exist in the database
    // return true if it does and false if it does not
    function exist($name, $db) {
        $resultSet = $db -> query("SELECT * from Pokedex WHERE name = '$name'");
        $count = $resultSet->rowCount();
        return (!$count == 0);
    }
    
    // Remove pokemon from database
    // require: pokemon is in the database
    function remove($name, $db) {
        try {
            $rowsAffected = $db->exec("
            DELETE FROM Pokedex WHERE name = '$name'");
        } catch (PDOException $pdoex) {
            print(json_encode(['exception' => $pdoex]));
        }
    }
    
    // Insert pokemon to the database
    // require: pokemon is not in the database
    function insert($name, $db) {
        date_default_timezone_set('America/Los_Angeles');
        $time = date('y-m-d H:i:s');
        if (isset($_POST["nickname"])) {
            $nickname = $_POST["nickname"];
        } else {
            $nickname = strtoupper($name);
        }
        try {
            $db->exec("
            INSERT INTO Pokedex
                (name, nickname, datefound)
            VALUES
                ('$name', '$nickname', '$time')    
            ");
        } catch (PDOException $pdoex) {
            print(json_encode(['exception' => $pdoex]));
        }
    }
    
?>