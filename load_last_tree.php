<?php
include 'create_table.php';
//Read tree from the data that saved on server, instead of loading tree_data.csv again

function load_last_tree(){
    $tree_data = file_get_contents("tree-data.txt");
    $array = unserialize($tree_data);

    create_table($array, 0);
}

load_last_tree();
?>