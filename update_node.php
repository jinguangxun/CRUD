<?php
include 'create_table.php';

$parID = $_POST['id'];
$parName = $_POST['newName'];

function update_node($id, $name){
    //Change name from tree node
    $tree_data = file_get_contents("tree-data.txt");
    $array = unserialize($tree_data);
    change_name($id, $name, $array); //Recursively search for the target
    $tree_data = serialize($array);
    file_put_contents("tree-data.txt", $tree_data);

    //Change name from linear array for back up
    $linear_data = file_get_contents("linear-data.txt");
    $linear_array = unserialize($linear_data);
    update_linear($id, $name, $linear_array);
    
    create_table($array, 0); //Visualize nodes
}

//Recursively search target and update
function change_name($id, $name, &$tree){
    $result = $tree;
    if (!is_null($tree)){ 
        if (intval($tree["id"]) == intval($id)){
            $tree["name"] = $name;
            $result = $tree;
            echo "<script>alert('Name updated!');</script>";
            return $result;
        } else if (!is_null($tree["child"])) {
            for ($i = 0; $i < count($tree["child"]); $i++){
                $result = change_name($id, $name, $tree["child"][$i]);
            }
        } else {
            return $result;
        }
    } else {
        echo "tree is null";
    }

    return $result;
}

//Update name in linear array
function update_linear($id, $name, &$array){
    for ($i = 0; $i < count($array); $i++){
        if ($array[$i]["id"] == $id){
            $array[$i]["name"] = $name;
            break;
        }
    }

    $linear_data = serialize($array);
    file_put_contents("linear-data.txt", $array);
}

update_node($parID, $parName);

?>