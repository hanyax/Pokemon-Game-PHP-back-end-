<?php
    /**
     * Shawn Xu Section AA 
     * If passed name, delete.php removes the Pokemon with the given name (case-insenstive) 
     * from Pokedex database. If passed in mode=removeall, this php will remove all the pokemon
     * from database
     */
     
    include 'common.php';
    $db = setDatabase();
    
    if (isset($_POST["name"])) {
        $name = $_POST["name"];
        if (exist($name, $db)) {
            header("Content-Type: application/json");
            remove($name, $db);
            print(json_encode(['success' => "Success! " . $name . " removed from your Pokedex!"]));
        } else {
            header("HTTP/1.1 400 bad request");
            print(json_encode(['error' => "Error: Pokemon " . $name . " not found in your Pokedex."]));
        }
    } else {
        if (isset($_POST["mode"])) {
            $mode = $_POST["mode"];
            if ($mode == "removeall") {
                header("Content-Type: application/json");
                removeAll($db);
            } else {
                header("HTTP/1.1 400 bad request");
                print(json_encode(['error' => "Error: Unknown mode " . $mode . "."]));
            }
        } else {
            header("HTTP/1.1 400 bad request");
            print(checkParam("name", "mode", true));
        }
    }
    
    // Remove all the pokemon from the database
    function removeAll($db) {
        try {
            $db->exec("TRUNCATE TABLE Pokedex");
        } catch (PDOException $pdoex) {
            print(json_encode(['exception' => $pdoex]));
        }
        print(json_encode(['success' => "Success! All Pokemon removed from your Pokedex!"]));
    }
    
?>