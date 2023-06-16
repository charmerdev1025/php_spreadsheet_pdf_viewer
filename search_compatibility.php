<?php
	require('vendor/autoload.php');
	// Get the API client and construct the service object.
	error_reporting(E_ERROR | E_PARSE);
	$parser = new \Smalot\PdfParser\Parser(); 

	function getClient()
	{
	    $client = new Google_Client();
	    $client->setApplicationName('php spreadsheet api');
	    $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
	    $client->setAuthConfig('credentials.json');
	    return $client;
	}
	if(isset($_POST['filename'])) {
		$imagePath = './assets/images/Hazard_labels';
		$files = scandir($imagePath);
		$files = array_diff(scandir($imagePath), array('.', '..'));
		$imageLists = array();
		foreach($files as $file){
			array_push($imageLists, $file);
		}
		$target_path = $_POST['filename'];
		$client = getClient();
		$service = new Google_Service_Sheets($client);

		$spreadsheetId = '1fLzXr4Yw7WCQr4YQ_vM0UmYn17gXA05Yl94XlrEdPRk';
		$range = array('Sheet1!A1:F');
		$response = $service->spreadsheets_values->get($spreadsheetId, $range);
		$values = $response->getValues();

		$range4 = array('Sheet4!A2:D');
		$response4 = $service->spreadsheets_values->get($spreadsheetId, $range4);
		$compatibilities = $response4->getValues();
		$pdf = $parser->parseFile($target_path); 
		$text = $pdf->getText();
		$result = array();
		$un_numbers = array();
		$classes = array();
		$count = 0;
		$countArray = array();
		if (empty($values)) {
		    print "No data found.\n";
		} else {
			foreach ($values as $row):
				$un_number = $row[1];
				if(is_numeric($un_number)) {
					if(strpos(strtolower(trim($text)), strtolower(trim($un_number)) ) !== false) {
						foreach ($compatibilities as $compatibility) {
							$real_class = preg_split('/\(.*?\)/',trim($row[4]));
							if(trim($real_class[0]) == trim($compatibility[0])) {
								$row["compatable"] = $compatibility[1];
								$row["noncompatable"] = $compatibility[2];
								break;
							} else {
								$row["compatable"] = "";
								$row["noncompatable"] = "";
							}
						}
						array_push($classes, $row[4]);
						array_push($result, $row);
						array_push($un_numbers, trim($un_number));
					}
				}
			endforeach;
		}
		$classes = array_values(array_unique($classes));
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode([$result,$un_numbers,$imageLists, $classes, $target_path]);
	}

?>


