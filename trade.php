<?php
    /**
     * Shawn Xu Section AA
     * trade.php takes a Pokemon to remove from your Pokedex mypokemon (case-insensitive) and a Pokemon to add
     * to your Pokedex theirpokemon. This php will return error messgae in JSON if user already have their pokemon
     * or user does not have the pokemon being trade out
     */

    include 'common.php';
    $db = setDatabase();
    
    if (isset($_POST["mypokemon"])) {
        if (isset($_POST["theirpokemon"])) {
            trade($db, $_POST["mypokemon"], $_POST["theirpokemon"]);
        } else {
            header("HTTP/1.1 400 bad request");
            print(checkParam("theirpokemon", NULL, false));
        }
    } else { 
        if (isset($_POST["theirpokemon"])) {
            header("HTTP/1.1 400 bad request");
            print(checkParam("mypokemon",NULL, false));
        } else {
            header("HTTP/1.1 400 bad request");
            print(checkParam("mypokemon", "theirpokemon", false));
        }
    }
    
    // Check if current database has the pokemon to be traded and to be added
    // If database has the pokemon to be traded and does not have the pokemon to
    // be added, add the pokemon to be added and delete the pokemon to be traded
    function trade($db, $mypokemon, $theirpokemon) {
        if(!exist($mypokemon, $db)) {
            header("HTTP/1.1 400 bad request");
            print(json_encode(['error' => "Error: Pokemon " . $mypokemon . " not found in your Pokedex."]));
        } else {
            if(!exist($theirpokemon, $db)) {
                header("Content-Type: application/json");
                remove($mypokemon, $db);
                insert($theirpokemon, $db);
                print(json_encode(['success' => "Success! You have trade your " . $mypokemon . 
                                    " for " . $theirpokemon . "!"]));
            } else {
                header("HTTP/1.1 400 bad request");
                print(json_encode(['error' => "Error: You have already found " . $theirpokemon . "."]));
            }
        }
    }
?>