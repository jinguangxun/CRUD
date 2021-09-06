<?php

//Visualize the Tree node

//jQuery library and code for prevent unnecessary pop up message
echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>";

//Download BUtton
echo "<form action='export_csv.php' method='post'>
            <button type='submit' value='' name='na' style='margin-top:4px;margin-left:4%;'>Download as CSV File</button>
        </form>";

function create_table($tree, $tier){
    if (!is_null($tree)){ 
        if (!is_null($tree["id"])){
            //Add node to HTML
            echo "<button id = '".$tree["id"]."' style='margin-left:".$tier."%;margin-top:4px;'>Node ID: ".$tree["id"]." | Name: ".$tree["name"]." | Description: ".$tree["description"]."</button><br>";

            if ($tree["read_only"] == false){ //If editable

            //Options for the Node, including delete node    
            echo "<div id='display".$tree["id"]."' style = 'display:none;margin-top:4px;margin-bottom:4px;margin-left:".$tier."%;'>
                <button id='update".$tree["id"]."' >Update Name</button>
                <button id='create".$tree["id"]."' >Create Node</button>
                <button id='close".$tree["id"]."' style = 'display:;'>close</button>
                <form action='delete_node.php' method='post'>
                    <button type='submit' value='".$tree["id"]."' name='id' style='margin-top:4px;'>Delete Node</button>
                </form>
                </div>";

            //Update the name layout
            echo "<div id='updateName".$tree["id"]."' style = 'display:none;margin-top:4px;margin-bottom:4px;font-size:14px;font-family: Arial, Helvetica, sans-serif;margin-left:".$tier."%;'>
                    <form action='update_node.php' method='post' >
                        <input type='hidden' name='id' value='".$tree["id"]."'/>
                        New Name: <input type='text' name='newName' required>
                        <input type='submit'>
                    </form>
                    <button id='updateClose".$tree["id"]."' style = 'display:;'>close</button>
                </div>";

            //Create node layout
            echo "<div id='createNode".$tree["id"]."' style = 'display:none;margin-top:4px;margin-bottom:4px;font-size:14px;font-family: Arial, Helvetica, sans-serif;margin-left:".$tier."%;'>
                    <form action='create_node.php' method='post'>
                        <input type='hidden' name='id' value='".$tree["id"]."'/>
                        Name: <input type='text' name='name' required>
                        Description: <input type='text' name='description' required>
                        Read Only: <select type='text' name='readOnly'><option value='1'>Yes</option><option value='0'>No</option></select>
                        <input type='submit'>
                    </form>
                    <button id='createClose".$tree["id"]."' style = 'display:;'>close</button>
                </div>";
             

            //For display and hide
            echo "<script>$(document).ready(function(){
                $('#".$tree["id"]."').click(function(){
                    $('#display".$tree["id"]."').fadeIn();});
                $('#close".$tree["id"]."').click(function(){
                    $('#display".$tree["id"]."').hide();
                    $('#createNode".$tree["id"]."').hide();
                    $('#updateName".$tree["id"]."').hide();});
                $('#update".$tree["id"]."').click(function(){
                    $('#updateName".$tree["id"]."').fadeIn();
                    $('#createNode".$tree["id"]."').hide();});
                $('#updateClose".$tree["id"]."').click(function(){
                    $('#updateName".$tree["id"]."').hide();});
                $('#create".$tree["id"]."').click(function(){
                    $('#createNode".$tree["id"]."').fadeIn();
                    $('#updateName".$tree["id"]."').hide();});
                $('#createClose".$tree["id"]."').click(function(){
                    $('#createNode".$tree["id"]."').hide();});
                });</script>";
            } else { //If not editable
                //Give a prompt
                echo "<div id='prompt".$tree["id"]."' style = 'display:none;;margin-top:4px;margin-bottom:4px;font-size:14px;font-family: Arial, Helvetica, sans-serif;margin-left:".$tier."%;'>
                This is read only node, you can't edit it.
                <button id='promptClose".$tree["id"]."' style = 'display:;'>close</button>
                </div>";

                echo "<script>$(document).ready(function(){
                $('#".$tree["id"]."').click(function(){
                    $('#prompt".$tree["id"]."').fadeIn();});
                $('#promptClose".$tree["id"]."').click(function(){
                    $('#prompt".$tree["id"]."').hide();});
                });</script>";
            }
        }

        //Recursively visualize nodes
        if (!is_null($tree["child"])) {
            for ($i = 0; $i < count($tree["child"]); $i++){
                $result = create_table($tree["child"][$i], $tier+4);
            }
        }

    }
}

?>