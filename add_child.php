<?php

//Recursively add child node to the tree
function add_child($parent, $child, &$tree){
    $result = [];
    if (!is_null($tree)){ 
        if (intval($tree["id"]) == intval($parent)){
            array_push($tree["child"], $child);
            $result = $tree;
            return $result;
        } else if (!is_null($tree["child"])) {
            for ($i = 0; $i < count($tree["child"]); $i++){
                $result = add_child($parent, $child, $tree["child"][$i]);
            }
        }
    } else {
        echo "tree is null";
    }

    return $result;
}

?>