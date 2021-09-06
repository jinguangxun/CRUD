<?php


function export_csv(){
	//Use the backup linear array
	$data = file_get_contents("linear-data.txt");
    $array = unserialize($data);

    $fp = fopen('newFile.csv', 'w');

    //First line since it different from rest of lines
    $keys = array_keys($array[0]);
    $firstLine = [];

    for ($i = 0; $i < (count($keys)-1); $i++){
    	$firstLine[$i] = $keys[$i];
    }

    fputcsv($fp, $firstLine, "\t");

    //Write rest of lines
	foreach ($array as $element) {
		$tempArray = [];

		for ($i = 0; $i < (count($keys)-1); $i++){
	    	$tempArray[$keys[$i]] = $element[$keys[$i]];
	    }

	    fputcsv($fp, $tempArray, "\t");
	}

	fclose($fp);

	//Download the file
	$file = 'newFile.csv';

	if (file_exists($file)) {
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename="'.basename($file).'"');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($file));
	    readfile($file);
	    exit;
	}
}

export_csv();

?>