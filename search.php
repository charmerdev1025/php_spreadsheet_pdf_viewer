<?php
	include('class.pdf2text.php');
	// Get the API client and construct the service object.
	error_reporting(E_ERROR | E_PARSE);
	require('vendor/autoload.php');
	// $parser = new \Smalot\PdfParser\Parser(); 
	use Spatie\PdfToText\Pdf;
	function getClient()
	{
	    $client = new Google_Client();
	    $client->setApplicationName('php spreadsheet api');
	    $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
	    $client->setAuthConfig('credentials.json');
	    return $client;
	}
	if(isset($_POST['filename'])) {
		$iamgePath = './assets/images/Hazard_labels';
		$files = scandir($iamgePath);
		$files = array_diff(scandir($iamgePath), array('.', '..'));
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

		// $a = new PDF2Text();
		// $a->setFilename($target_path); 
		// $a->decodePDF();
		// $content = $a->output();
		// $pdf = $parser->parseFile($target_path); 
		// $content = $pdf->getText();
		$path = 'c:/Program Files/Git/mingw64/bin/pdftotext';
		$content = Pdf::getText($target_path, $path);
		// $pdf->setOptions(['layout']);
		// $content = Pdf::getText('1.pdf');;		
		// var_dump($content);die;
		$result = array();
		$words = array();
		$count = 0;
		$countArray = array();
		if (empty($values)) {
		    print "No data found.\n";
		} else {
			$checkKeyword = false;
			foreach ($values as $row):
				$keywords = explode(",", $row[3]);
			  	$keywords = array_filter($keywords, function($value) {
				  return strlen(trim($value)) > 1;  
				});
				foreach ($keywords as $keyword) {
					if(!is_numeric($keyword)) {
						if(strpos( strtolower(trim($content)), strtolower(trim($keyword)) ) !== false) {
						  	$checkKeyword = true;
						  	array_push($result, $row);
							if(!in_array(trim($keyword), $words)) {
								$count+=substr_count(strtolower(trim($content)),strtolower(trim($keyword)));
								array_push($words, trim($keyword));
								array_push($countArray, substr_count(strtolower(trim($content)),strtolower(trim($keyword))));
							}
							break;
						}
					}
				}
			endforeach;
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode([$result,$words,$countArray,$count,$imageLists]);		
	}

?>


