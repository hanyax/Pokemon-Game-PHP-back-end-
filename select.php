<?php
    /** Shawn Xu Section AA 
     *  Return JSON response of all Pokemon in Pokedex database, 
     *  including the name, nickname, and found date/time for each Pokemon    
     */
    
    include 'common.php';
    $db = setDatabase();
    
    $rows = $db -> query("SELECT * from Pokedex");
    
    $selected = [];
    foreach ($rows as $row) {
        $selected[] = [
            "name" => $row["name"],
            "nickname" => $row["nickname"],
            "datefound" => $row["datefound"]
        ];
    }
    
    $result = [];
    $result[] = [
        "pokemon" => $selected,
    ]; 
    
    print(json_encode($result));
    
?>