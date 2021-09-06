<?php 

include 'create_table.php';
include 'add_child.php';

$parID = $_POST['id'];

function delete_node($id){
    //In tree data structure, I found after deletion there will be empty array position;
    //e.g. A[0], A[1],A[3],A[4]
    //So I decided to use linear array to delete, and use the linear node to make a tree node
    $linear_data = file_get_contents("linear-data.txt");
    $linear_array = unserialize($linear_data);

    $treeArray = delete_the_node($id, $linear_array);

    $tree_data = serialize($treeArray);
    file_put_contents("tree-data.txt", $tree_data);

    create_table($treeArray, 0);
}

function delete_the_node($id, &$array){
    //Delete the target
    for ($i = 0; $i < count($array); $i++){
        if ($array[$i]["id"] == $id){
            unset($array[$i]);
            break;
        }
    }

    $newArray = array_values($array);
    $linear_data = serialize($newArray);
    file_put_contents("linear-data.txt", $linear_data);

    $newTreeArray["child"] = [];

    //Make the linear array into a tree
    for ($i = 0; $i < count($newArray); $i++){
        if($newArray[$i]["parent"] == 0){
            array_push($newTreeArray["child"], $newArray[$i]);
        } else {
            add_child($newArray[$i]["parent"], $newArray[$i], $newTreeArray);
        }
    }

    echo "<script>alert('Node deleted!');</script>";
    return $newTreeArray;
}

delete_node($parID);

?>