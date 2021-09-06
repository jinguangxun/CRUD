<!DOCTYPE html>
<html>
<head>
	<title>CRUD</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
	    if ( window.history.replaceState ) {
	        window.history.replaceState( null, null, window.location.href );
	    }
	</script>
</head>
<body>
	<div style="margin-left:7%;margin-top:6%;">
		<p>NOTES:</p>
		<p style="margin-left:5px;">After finish loading the tree,</p>
		<p style="margin-left:5px;">you could click each node to see the possible options.</p>
		<div style="line-height: 270%;">
			<form action='get_tree.php' method='post'>
		        <input type='submit' value='Browse The Tree by loading tree_data.csv' name='na' />
		    </form>
		    <form action='load_last_tree.php' method='post'>
		        <input type='submit' value='Browse The Tree from where we left last time' name='na' />
		    </form>
	    </div>
    </div>
</body>
</html>