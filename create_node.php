<?php

include 'create_table.php';

$parent = $_POST['id'];
$newName = $_POST['name'];
$newDescription = $_POST['description'];
$readOnly = $_POST['readOnly'];
$newArrayJson = '{"id":100, "name":"'.$newName.'", "description":"'.$newDescription.'","parent":"'.$parent.'", "read_only":"'.$readOnly.'", "child":[]}';

function create_node($parent, $newArrayJson){
    $newObj = json_decode($newArrayJson);
    $newArray = json_decode(json_encode($newObj), true);  //Change Json to PHP format

    $tree_data = file_get_contents("tree-data.txt");
    $array = unserialize($tree_data);

    $linear_data = file_get_contents("linear-data.txt");
    $linear_array = unserialize($linear_data);

    //Give an ID number to newly added child
    $newArray["id"] = intval($linear_array[count($linear_array)-1]["id"]) + 1;
    $newArray["id"] = $newArray["id"] + "";


    create_the_node($parent, $newArray, $array);
    $tree_data = serialize($array);
    file_put_contents("tree-data.txt", $tree_data);

    add_node($newArray,$linear_array);

    create_table($array, 0);

}

//Recursively find the parent and add the child node
function create_the_node($parent, $newArray, &$tree){
    $result = [];
    if (!is_null($tree)){ 
        if (intval($tree["id"]) == intval($parent)){
            array_push($tree["child"], $newArray);
            $result = $tree;
            echo "<script>alert('New node ID: ".$newArray["id"]." added!');</script>";
            return $result;
        } else if (!is_null($tree["child"])) {
            for ($i = 0; $i < count($tree["child"]); $i++){
                $result = create_the_node($parent, $newArray, $tree["child"][$i]);
            }
        }
    } else {
        echo "tree is null";
    }

    return $return;
}

//Add node to linear array as backup
function add_node($newArray, &$linear){
    array_push($linear, $newArray);
    $array_list = serialize($linear);
    file_put_contents("linear-data.txt", $array_list);
}

create_node($parent, $newArrayJson);


?>