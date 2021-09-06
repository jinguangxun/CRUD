<?php
include 'create_table.php';
include 'add_child.php';

function get_tree($file) {
    // open csv file
    if (!($fp = fopen($file, 'r'))) {
        die("Can't open file...");
    }

    $json["child"] = [];  //tree data structure
    $jsonCopy = [];  //linear array which will be used for making things easier in some cases

    $fp = fopen($file, 'r');
    $keys = preg_split("/\t+/",fgetcsv($fp)[0]);

    //searching where is the 'parent' key in the array
    $parent = 0;
    for ($i = 0; $i < count($keys); $i++){
        if ($keys[$i] == "parent"){
            $parent = $i;
            break;
        }
    }
    
    while(!feof($fp)){
        $values = preg_split("/\t+/",fgetcsv($fp)[0]); //read cvs line

        //Make each csv line as an array and add to tree node
        $tempArray = array_fill_keys($keys, 'none');

        for ($i = 0; $i < count($keys); $i++){
           $tempArray[$keys[$i]] = $values[$i];
        }
        
        $tempArray["child"] = []; 

        //Also add to linear array for backup
        if($tempArray[$keys[0]] !== ""){
            array_push($jsonCopy, $tempArray);
        }


        //If parent is 0, add to root
        if($tempArray[$keys[0]] !== "" and intval($tempArray[$keys[$parent]]) == 0){
            array_push($json["child"], $tempArray);
        } else if ($tempArray[$keys[0]] !== ""){
            add_child($tempArray[$keys[$parent]], $tempArray, $json);         
        }
    }

    //Save the tree on the server, as well as linear array
    $tree_data = serialize($json);
    file_put_contents("tree-data.txt", $tree_data);

    $array_list = serialize($jsonCopy);
    file_put_contents("linear-data.txt", $array_list);

    $read_tree = file_get_contents("tree-data.txt");
    $tree = unserialize($read_tree);

    
    // release file handle
    fclose($fp);

    create_table($tree, 0);
    
    // encode array to json
    return json_encode($json);
}


get_tree('tree_data.csv');


?>