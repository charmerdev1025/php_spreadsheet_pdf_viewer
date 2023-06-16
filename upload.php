<?php
	// ----------------- Database connection ----------------
	// $hostname 			=			"localhost";
	// $username			=			"root";
	// $password 			=			"root";
	// $dbname 			=			"jquery_file_upload";

	// $conn				=			mysqli_connect($hostname, $username, $password, $dbname) or die("Db connect error" .mysqli_connect_error());


	// Get the API client and construct the service object.

	// if (empty($values)) {
	//     print "No data found.\n";
	// } else {

	// 	echo "<table>";

	// 	foreach ($values as $row):
	// 	    echo "<tr>";
		    
	// 	    foreach ($row as $cell):
	// 	        echo "<td>" . $cell . "</td>";
	// 	    endforeach;
		    
	// 	    echo "</tr>";
	// 	endforeach;

	// 	echo "</table>";
	// }
	// ------------- Check if file is not empty ------------

	if(!empty($_FILES)) {

		$fileName = $_FILES['file']['name'];
		$source_path = $_FILES['file']['tmp_name'];
		$fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
		$targetFile	= time()."-".strtolower(str_replace(" ","-",$fileName));

		$target_path = "./uploads/".$targetFile;

		if(move_uploaded_file($source_path, $target_path)) {
			echo $target_path;
		}		
	}


?>