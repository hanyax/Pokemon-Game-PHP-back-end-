<?php
    /**
     * Shawn Xu Section AA
     * update.php updates a Pokemon in your Pokedex table with the given 
     * name (case-insensitive) parameter to have the given 
     * nickname (overwriting any previous nicknames) and maintain the found time unchanged
     */

    include 'common.php';
    $db = setDatabase();
    
    if (isset($_POST["name"])) {
        if (isset($_POST["nickname"])) {
            $name = $_POST["name"];
            $nickname = $_POST["nickname"];
            update($name, $nickname, $db);
        } else {
            header("HTTP/1.1 400 bad request");
            print(checkParam("nickname", NULL, false));
        }
    } else {
        header("HTTP/1.1 400 bad request");
        if (isset($_POST["nickname"])) {
            print(checkParam("name", NULL, false));
        } else {
            print(checkParam("name", "nickname", false));
        }
    }
    
    // Check if the pokemon is in the database
    // If pokemon is in the database, update its nickname
    function update($name, $nickname, $db) {
        if (exist($name, $db)) {
            header("Content-Type: application/json");
            $nickname = $_POST["nickname"];
            $db->exec("
            UPDATE Pokedex SET nickname = '$nickname' WHERE name = '$name'    
            ");
            print(json_encode(['success' => "Success! Your " . $name . " is now named " . $nickname . "!"]));
        } else {
            header("HTTP/1.1 400 bad request");
            print(json_encode(['error' => "Error: Pokemon " . $mypokemon . " not found in your Pokedex."]));
        }
    }
?>