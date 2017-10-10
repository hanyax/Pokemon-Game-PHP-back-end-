<?php
    /**
     * Shawn Xu Section AA 
     * insert.php adds a Pokemon to Pokedex table, given a required name parameter
     * the pokemon given will be added to the database with its name, nickname(if given)
     * and the time added
     */
    
    include 'common.php';
    $db = setDatabase();
    
    if (!isset($_POST["name"])) {
        header("HTTP/1.1 400 bad request");
        print(checkParam("name", NULL, false));
    } else {
        $name = $_POST["name"];
        if (!exist($name, $db)) {
            header("Content-Type: application/json");
            insert($name, $db);
            print(json_encode(['success' => "Success! " . $name . " added to your Pokedex!"]));
        } else {
            header("HTTP/1.1 400 bad request");
            print(json_encode(['error' => "Error: Pokemon " . $name . " already found."]));
        }
    }
?>